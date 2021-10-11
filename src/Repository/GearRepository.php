<?php

namespace App\Repository;

use App\Entity\Gearshift;

class GearRepository
{
    public function findAll(): array
    {
        $gear1 = new Gearshift('1304179',
            'Alivio RD-M3100 Schaltwerk 9-fach schwarz',
            30,
            'Das SHIMANO ALIVIO M3100 Schaltwerk besitzt dank seines SHIMANO SHADOW Designs ein flaches Profil, das eine aggressive Fahrweise ermöglicht und die Gefahr, an Hindernissen anzustoßen, verringert.',
            2021,
            'Gesamtkapazität: 45 Zähne, Max. Differenz vorne: 22 Zähne, Max. größtes Ritzel: 36 Zähne, Min. größtes Ritzel: 32 Zähne',
            9);

        $gear2 = new Gearshift('1008026',
            'GRX RD-RX810 Schaltwerk 11-fach Direct Mount schwarz',
            89,
            'Für Fahrten auf rauen Strecken, durch Schotter und Schlamm vorgesehen, damit Sie komfortabel und stressfrei überall hinkommen, wo Sie hin möchten und das einzigartige Gefühl von Leistung erreichen. Die erste von Shimano für Gravelfahrten entwickelte Komponentengruppe.',
            2021,
            'Gesamtkapazität: 40 Zähne, Max. Differenz vorne: 17 Zähne, Max. größtes Ritzel: 34 Zähne, Min. größtes Ritzel: 30 Zähne',
            11);

        return [
            $gear1,
            $gear2,
        ];
    }
}
