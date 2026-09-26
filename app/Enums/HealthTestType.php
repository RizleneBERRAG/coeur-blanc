<?php

namespace App\Enums;

enum HealthTestType: string
{
    case Hcm     = 'hcm';
    case PkDef   = 'pk_def';
    case PraB    = 'pra_b';
    case FivFelv = 'fiv_felv';

    public function libelle(): string
    {
        return match ($this) {
            self::Hcm     => 'HCM — échographie cardiaque',
            self::PkDef   => 'PK-Def — déficit en pyruvate kinase',
            self::PraB    => 'PRA-b — atrophie rétinienne',
            self::FivFelv => 'FIV / FeLV',
        };
    }

    public function methode(): string
    {
        return match ($this) {
            self::Hcm     => 'Contrôle annuel',
            self::PkDef,
            self::PraB    => 'Test ADN',
            self::FivFelv => 'Dépistage sanguin',
        };
    }

    /** Les depistages exiges avant toute mise a la reproduction. */
    public static function requisReproduction(): array
    {
        return [self::Hcm, self::PkDef, self::PraB, self::FivFelv];
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($c) => [$c->value => $c->libelle()])->all();
    }
}
