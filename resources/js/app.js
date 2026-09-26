/* Chatterie Ô Coeur Blanc — interactions du site public.
   Volontairement sans dependance : menu, lecture de robe, lightbox, reveal, compteurs. */

const reduit = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ---------- menu mobile ---------- */
const burger = document.getElementById('burger');
const menu = document.getElementById('menu');

/* Le panneau couvre l'ecran : sans ce verrou, le doigt fait defiler la page
   derriere lui et on repart de la mauvaise hauteur en refermant. */
const verrouiller = (actif) => {
    document.body.style.overflow = actif ? 'hidden' : '';
};

const basculerMenu = (ouvrir) => {
    if (!burger || !menu) return;
    burger.setAttribute('aria-expanded', String(ouvrir));
    menu.hidden = !ouvrir;
    verrouiller(ouvrir);
    // Voir app.css : le bandeau doit cesser d'etre le bloc conteneur du
    // panneau, sans quoi celui-ci est rogne a la hauteur de la barre.
    document.getElementById('nav')?.classList.toggle('menu-ouvert', ouvrir);
};

const syncMenu = () => {
    if (!burger || !menu) return;
    if (window.innerWidth > 1100) {
        // Retour au bandeau horizontal : le menu redevient visible en
        // permanence, et le verrou n'a plus lieu d'etre.
        menu.hidden = false;
        burger.setAttribute('aria-expanded', 'false');
        verrouiller(false);
        document.getElementById('nav')?.classList.remove('menu-ouvert');
    } else if (burger.getAttribute('aria-expanded') !== 'true') {
        menu.hidden = true;
    }
};

burger?.addEventListener('click', () => {
    basculerMenu(burger.getAttribute('aria-expanded') !== 'true');
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && burger?.getAttribute('aria-expanded') === 'true') {
        basculerMenu(false);
        burger.focus();
    }
});

/* Les liens d'ancre ne changent pas de page : sans cela le panneau resterait
   ouvert par-dessus l'endroit vers lequel il vient de faire defiler. */
menu?.addEventListener('click', (e) => {
    const lien = e.target.closest('a[href*="#"]');
    if (lien && burger?.getAttribute('aria-expanded') === 'true') basculerMenu(false);
});

window.addEventListener('resize', syncMenu);
syncMenu();

/* ---------- barre de navigation ---------- */
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => nav?.classList.toggle('stuck', window.scrollY > 12), { passive: true });

/* ---------- lecture de robe ---------- */
const coat = document.getElementById('coat');
const coatInfo = document.getElementById('coatinfo');

if (coat && coatInfo) {
    const points = JSON.parse(coat.dataset.points || '[]');

    const afficher = (i) => {
        const p = points[i];
        if (!p) return;
        coatInfo.innerHTML =
            `<span class="k">${p.k}</span><h3>${p.t}</h3><p>${p.d}</p>`;
        coat.querySelectorAll('.hot').forEach((h) =>
            h.setAttribute('aria-pressed', String(Number(h.dataset.coat) === i)));
    };

    coat.addEventListener('click', (e) => {
        const b = e.target.closest('[data-coat]');
        if (b) afficher(Number(b.dataset.coat));
    });
    coat.addEventListener('mouseover', (e) => {
        const b = e.target.closest('[data-coat]');
        if (b) afficher(Number(b.dataset.coat));
    });
    afficher(0);
}

/* ---------- vue plein ecran ----------

   Un seul mecanisme pour deux usages : la mosaique de la galerie, ou chaque
   vignette est son propre declencheur, et la visionneuse des fiches, ou c'est
   la grande photo qui agrandit la vue courante.

   Dans les deux cas la liste des images est lue sur le conteneur marque
   data-lightbox, a partir des elements porteurs d'un data-full. Rien n'est
   duplique : les vignettes de la visionneuse servent aussi de liste. */

let lb = null;
let lbListe = [];
let lbIndex = 0;

const peindre = () => {
    const f = lbListe[lbIndex];
    lb.querySelector('img').src = f.dataset.full;
    lb.querySelector('img').alt = f.querySelector('img').alt;
    lb.querySelector('.cap').textContent =
        `${f.dataset.legende}  ·  ${lbIndex + 1} / ${lbListe.length}`;
};

const deplacer = (d) => {
    lbIndex = (lbIndex + d + lbListe.length) % lbListe.length;
    peindre();
};

const fermer = () => {
    if (!lb) return;
    lb.hidden = true;
    document.body.style.overflow = '';
};

const ouvrir = (items, index) => {
    if (!items.length) return;

    lbListe = items;
    lbIndex = Math.max(0, index);

    if (!lb) {
        lb = document.createElement('div');
        lb.id = 'lb';
        lb.innerHTML =
            '<button class="x" type="button">Fermer</button><img alt=""><p class="cap"></p>' +
            '<div class="nav"><button type="button" data-d="-1">← Précédent</button>' +
            '<button type="button" data-d="1">Suivant →</button></div>';
        document.body.appendChild(lb);
        lb.addEventListener('click', (ev) => {
            if (ev.target === lb || ev.target.classList.contains('x')) return fermer();
            const b = ev.target.closest('[data-d]');
            if (b) deplacer(Number(b.dataset.d));
        });
        /* Glissement du doigt : sur un telephone, personne ne cherche les
           boutons. Seuil de 45 px pour ne pas confondre avec un appui. */
        let departX = null;
        lb.addEventListener('pointerdown', (ev) => { departX = ev.clientX; });
        lb.addEventListener('pointerup', (ev) => {
            if (departX === null) return;
            const dx = ev.clientX - departX;
            departX = null;
            if (Math.abs(dx) > 45) deplacer(dx < 0 ? 1 : -1);
        });

        document.addEventListener('keydown', (ev) => {
            if (!lb || lb.hidden) return;
            if (ev.key === 'Escape') fermer();
            if (ev.key === 'ArrowLeft') deplacer(-1);
            if (ev.key === 'ArrowRight') deplacer(1);
        });
    }

    lb.hidden = false;
    document.body.style.overflow = 'hidden';
    peindre();
};

/* Les figures masquees par le filtre de la galerie ne doivent pas entrer dans
   la visionneuse : sinon on filtre « Chatons » et les fleches font defiler les
   trente-six photos. hidden couvre les deux cas — le masquage pose par le
   serveur et celui applique par le filtre. */
const listeDe = (conteneur) =>
    [...conteneur.querySelectorAll('[data-full]')].filter((el) => !el.hidden);

document.addEventListener('click', (e) => {
    // Galerie : on ouvre sur la vignette cliquee.
    const vignette = e.target.closest('[data-lightbox] figure[data-full]');
    if (vignette) {
        const items = listeDe(vignette.closest('[data-lightbox]'));
        return ouvrir(items, items.indexOf(vignette));
    }

    // Fiche : on ouvre sur la vue affichee.
    const scene = e.target.closest('[data-zoom]');
    if (scene) {
        const conteneur = scene.closest('[data-lightbox]');
        if (!conteneur) return;
        const items = listeDe(conteneur);
        return ouvrir(items, items.findIndex((v) => v.getAttribute('aria-current') === 'true'));
    }
});

// La scene est annoncee comme un bouton : elle doit repondre au clavier.
document.addEventListener('keydown', (e) => {
    if (e.key !== 'Enter' && e.key !== ' ') return;
    const scene = e.target.closest?.('[data-zoom]');
    if (!scene) return;
    e.preventDefault();
    scene.click();
});


/* ---------- apparition au defilement + compteurs ---------- */
const compter = (el) => {
    const cible = parseInt(el.dataset.count, 10);
    if (Number.isNaN(cible)) return;
    if (reduit() || cible === 0) { el.textContent = cible; return; }

    const debut = performance.now();
    const tick = (t) => {
        const p = Math.min(1, (t - debut) / 900);
        el.textContent = Math.round(cible * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
};

if (!reduit()) {
    const io = new IntersectionObserver((entrees) => {
        entrees.forEach((e) => {
            if (!e.isIntersecting) return;
            e.target.classList.remove('pre');
            if (e.target.dataset.count !== undefined) compter(e.target);
            io.unobserve(e.target);
        });
    }, { rootMargin: '0px 0px -7% 0px' });

    const cibles = '.band .shead,.band .two,.grid>*,.repros>*,.cells>*,.masonry figure,.ledger .row,.legalgrid>*,.record';

    document.querySelectorAll(cibles).forEach((el, i) => {
        if (el.getBoundingClientRect().top > window.innerHeight * 1.02) {
            el.classList.add('reveal', 'pre');
            el.style.transitionDelay = `${Math.min(i, 5) * 40}ms`;
            io.observe(el);
        }
    });

    document.querySelectorAll('[data-count]').forEach((el) => {
        if (el.getBoundingClientRect().top < window.innerHeight * 1.02) compter(el);
        else io.observe(el);
    });

    // Filet de securite : rien ne doit rester invisible si l'observer ne declenche pas.
    setTimeout(() => document.querySelectorAll('.reveal.pre').forEach((el) => {
        if (el.getBoundingClientRect().top < window.innerHeight * 1.2) el.classList.remove('pre');
    }), 2200);
}

/* ---------- transitions de page : la photo suit le clic ----------

   Le navigateur sait deja fondre une page dans l'autre (regle
   @view-transition dans app.css). Ce bloc ajoute le seul detail qu'il ne
   peut pas deviner : quelle image de la liste correspond a la grande photo
   de la fiche. Une fois les deux nommees pareil, il ne les fait plus
   disparaitre puis reapparaitre — il deplace la meme image d'un cadre a
   l'autre.

   Le nom est pose au dernier moment et retire des la fin du trajet : deux
   elements portant le meme nom au meme instant annulent la transition, et
   le visiteur peut tres bien cliquer une deuxieme carte juste apres.

   pageswap se declenche sur la page qui part, pagereveal sur celle qui
   arrive. Les deux n'existent pas partout ; la ou elles manquent, il ne se
   passe rien de plus qu'avant. */

const NOM_VT = 'photo-fiche';

const photoDeLaFiche = () =>
    // Dans une visionneuse, c'est la vue affichee qui doit suivre le clic,
    // pas la premiere image de la pile.
    document.querySelector('.detail .photo img.visible')
    ?? document.querySelector('.detail .photo img');

const photoDeLaCarte = (url) => {
    if (!url) return null;
    const chemin = new URL(url, location.href).pathname;
    const lien = [...document.querySelectorAll('a.fiche, a.repro')]
        .find((a) => new URL(a.href, location.href).pathname === chemin);
    return lien?.querySelector('img') ?? null;
};

const nommer = (img, transition) => {
    if (!img) return;
    img.style.viewTransitionName = NOM_VT;
    transition?.finished.finally(() => { img.style.viewTransitionName = ''; });
};

window.addEventListener('pageswap', (e) => {
    if (!e.viewTransition) return;
    nommer(photoDeLaCarte(e.activation?.entry?.url) ?? photoDeLaFiche(), e.viewTransition);
});

window.addEventListener('pagereveal', (e) => {
    if (!e.viewTransition) return;
    // Sur une fiche c'est la grande photo ; sur une liste, la vignette d'ou
    // l'on vient — le retour arriere replie l'image sur sa carte.
    nommer(photoDeLaFiche() ?? photoDeLaCarte(window.navigation?.activation?.from?.url), e.viewTransition);
});


/* ---------- visionneuse de fiche ----------

   Le ruban de vignettes pilote la scene. Les images sont deja dans le
   document : changer de vue, c'est deplacer une classe, jamais charger.

   Le ruban est un tablist : la fleche gauche et la fleche droite y
   circulent, et le focus suit, comme l'attend un lecteur d'ecran. Au doigt,
   un glissement horizontal sur la grande photo fait la meme chose. */

document.querySelectorAll('.viewer').forEach((viewer) => {
    const vues = [...viewer.querySelectorAll('.viewer-scene img')];
    const vignettes = [...viewer.querySelectorAll('.viewer-vignette')];
    const compteur = viewer.querySelector('.viewer-compteur b');
    let courant = 0;

    const montrer = (i, prendreLeFocus = false) => {
        courant = (i + vues.length) % vues.length;

        vues.forEach((img, n) => img.classList.toggle('visible', n === courant));
        vignettes.forEach((v, n) => {
            if (n === courant) v.setAttribute('aria-current', 'true');
            else v.removeAttribute('aria-current');
            v.tabIndex = n === courant ? 0 : -1;
        });

        if (compteur) compteur.textContent = courant + 1;

        const active = vignettes[courant];
        active?.scrollIntoView({ block: 'nearest', inline: 'nearest',
            behavior: reduit() ? 'auto' : 'smooth' });
        if (prendreLeFocus) active?.focus();
    };

    vignettes.forEach((v, i) => v.addEventListener('click', () => montrer(i)));

    viewer.querySelector('.viewer-rail')?.addEventListener('keydown', (e) => {
        const pas = { ArrowRight: 1, ArrowLeft: -1, Home: -courant, End: vues.length - 1 - courant }[e.key];
        if (pas === undefined) return;
        e.preventDefault();
        montrer(courant + pas, true);
    });

    /* Glissement au doigt. Le seuil de 40 px evite de changer de photo sur un
       defilement vertical un peu oblique ; au-dela de 340 px on considere que
       le doigt a balaye l'ecran et non la photo. */
    const scene = viewer.querySelector('.viewer-scene');
    let depart = null;

    scene?.addEventListener('pointerdown', (e) => {
        depart = e.pointerType === 'touch' ? { x: e.clientX, y: e.clientY } : null;
    });

    scene?.addEventListener('pointerup', (e) => {
        if (!depart) return;
        const dx = e.clientX - depart.x;
        const dy = e.clientY - depart.y;
        depart = null;
        if (Math.abs(dx) < 40 || Math.abs(dx) > 340 || Math.abs(dy) > Math.abs(dx)) return;

        /* Le pointerup sera suivi d'un click, qui ouvrirait la vue plein
           ecran par-dessus la photo qu'on vient de faire defiler. On le
           neutralise une fois, en phase de capture : il n'atteint jamais
           l'ecouteur pose sur le document. */
        scene.addEventListener('click', (ev) => {
            ev.stopPropagation();
            ev.preventDefault();
        }, { capture: true, once: true });

        montrer(courant + (dx < 0 ? 1 : -1));
    });
});

/* ------------------------------------------------------------------
   Questions frequentes — ouvrir celle qu'on vient chercher

   Chaque question porte une ancre, pour qu'on puisse envoyer un lien
   direct vers une reponse. Mais l'ancre designe le <details> lui-meme,
   et un navigateur ne deplie que ceux dont la CIBLE est a l'interieur :
   sans cela, le visiteur atterrit sur une question fermee.
   ------------------------------------------------------------------ */
(() => {
    const ouvrirLaCible = () => {
        const id = decodeURIComponent(location.hash.slice(1));
        if (!id) return;

        const bloc = document.getElementById(id);
        if (!(bloc instanceof HTMLDetailsElement)) return;

        bloc.open = true;

        /* Ouvrir change les hauteurs, et le navigateur a deja fait son propre
           defilement — celui de l'ancre, ou celui qu'il restaure d'une visite
           precedente. On repositionne a la frame suivante, une fois qu'il a fini.
           On ne touche pas aux autres questions : leur etat appartient au
           visiteur, et le navigateur le restaure lui-meme. */
        /* 'instant' et non le defilement doux global : un defilement doux lance
           pendant le chargement se fait annuler par celui du navigateur. On
           repositionne une fois a la frame suivante, puis apres le chargement
           des images, qui decalent encore les hauteurs. */
        const positionner = () => bloc.scrollIntoView({ block: 'start', behavior: 'instant' });

        requestAnimationFrame(positionner);
        if (document.readyState !== 'complete') {
            window.addEventListener('load', positionner, { once: true });
        }
    };

    ouvrirLaCible();
    window.addEventListener('hashchange', ouvrirLaCible);
})();

/* ------------------------------------------------------------------
   Galerie — filtrer sur place

   Les filtres sont des liens : sans JavaScript ils rechargent la page
   avec ?categorie= et fonctionnent quand meme. Ici on les intercepte et
   on masque les figures, sans recharger ni perdre la position.

   Le serveur rendait deja toutes les photos — il les filtrait a
   l'affichage apres les avoir toutes chargees — donc rien de plus n'est
   telecharge.
   ------------------------------------------------------------------ */
(() => {
    const barre = document.querySelector('[data-filtre-galerie]');
    const grille = document.getElementById('mas');
    if (!barre || !grille) return;

    const figures = [...grille.querySelectorAll('figure')];
    const vide = document.getElementById('galerie-vide');

    const appliquer = (categorie) => {
        let visibles = 0;

        for (const figure of figures) {
            const garde = !categorie || figure.dataset.categorie === categorie;
            figure.hidden = !garde;
            if (garde) visibles++;
        }

        for (const lien of barre.querySelectorAll('a')) {
            lien.setAttribute('aria-pressed', String(lien.dataset.categorie === categorie));
        }

        if (vide) vide.hidden = visibles > 0;
    };

    barre.addEventListener('click', (e) => {
        const lien = e.target.closest('a[data-categorie]');
        if (!lien || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;

        e.preventDefault();
        const categorie = lien.dataset.categorie;

        appliquer(categorie);

        /* L'adresse suit, pour que le filtre se partage et que le bouton
           « precedent » du navigateur le defasse. */
        history.pushState({ categorie }, '', lien.getAttribute('href'));
    });

    window.addEventListener('popstate', () => {
        appliquer(new URL(location.href).searchParams.get('categorie') || '');
    });
})();

/* ------------------------------------------------------------------
   Filtre des chatons par statut — cote navigateur.

   Le filtre etait entierement cote serveur : chaque clic rechargeait la
   page avec ?statut=. Cela marche sur le site complet, mais la copie
   statique n'a pas de serveur pour lire la requete — sur GitHub Pages,
   cliquer « Disponibles » renvoyait les cinq chatons.

   Le serveur rend maintenant toute la portee et masque les fiches qui ne
   correspondent pas ; ce script reprend la main. Les liens restent des
   liens : sans JavaScript, ils rechargent et le serveur fait le travail.

   Meme mecanique que le filtre de la galerie, plus haut.
   ------------------------------------------------------------------ */
(() => {
    const barre = document.querySelector('[data-filtre-chatons]');
    const grille = document.getElementById('chatons');
    if (!barre || !grille) return;

    const fiches = [...grille.querySelectorAll('[data-statut]')];
    const vide = document.getElementById('chatons-vide');

    const appliquer = (statut) => {
        let visibles = 0;

        for (const fiche of fiches) {
            const garde = !statut || fiche.dataset.statut === statut;
            fiche.hidden = !garde;
            if (garde) visibles++;
        }

        for (const lien of barre.querySelectorAll('a')) {
            lien.setAttribute('aria-pressed', String(lien.dataset.statut === statut));
        }

        if (vide) vide.hidden = visibles > 0;
    };

    barre.addEventListener('click', (e) => {
        const lien = e.target.closest('a[data-statut]');
        if (!lien || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;

        e.preventDefault();
        appliquer(lien.dataset.statut);

        /* L'adresse suit, pour que le filtre se partage et que le bouton
           « precedent » du navigateur le defasse. */
        history.pushState({ statut: lien.dataset.statut }, '', lien.getAttribute('href'));
    });

    window.addEventListener('popstate', () => {
        appliquer(new URL(location.href).searchParams.get('statut') || '');
    });

    /* Sur la copie statique, le serveur n'a pas pu lire ?statut= : une adresse
       partagee arrive donc sans filtre applique. On le pose au chargement. */
    appliquer(new URL(location.href).searchParams.get('statut') || '');
})();
