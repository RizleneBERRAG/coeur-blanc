<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Faq;
use App\Models\Kitten;
use App\Models\Litter;
use App\Models\Photo;

class PageController extends Controller
{
    public function home()
    {
        $portee = Litter::publiees()
            ->with(['pere', 'mere', 'kittens' => fn ($q) => $q->publies()])
            ->orderByDesc('date_naissance')
            ->first();

        return view('pages.home', [
            'portee'   => $portee,
            'chatons'  => $portee?->kittens ?? collect(),
            'chats'    => Cat::publies()->get(),
            'nbDispo'  => Kitten::publies()->disponibles()->count(),
            'photos'   => Photo::publiees()->inRandomOrder()->limit(12)->get(),
        ]);
    }

    public function breed()
    {
        return view('pages.breed');
    }

    public function gallery()
    {
        $photos = Photo::publiees()->orderBy('ordre')->get();

        return view('pages.gallery', [
            'photos'      => $photos,
            'categories'  => $photos->pluck('categorie')->filter()->unique()->values(),
        ]);
    }

    public function faq()
    {
        return view('pages.faq', ['faqs' => Faq::publiees()->get()]);
    }

    public function legal()
    {
        return view('pages.legal');
    }
}
