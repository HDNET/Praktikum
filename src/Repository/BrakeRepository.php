<?php


namespace App\Repository;


use App\Entity\Brake;

class BrakeRepository
{
    public function findAll(): array
    {
        $brake1 = new Brake('1031609',
            'ARO-09 Ai2 Bremsscheibe 6-Loch silber',
            29.95,
            'Die AiRotor-Technologie geht bis an die Grenzen! Der Bremsring ist aus hochwertigem Edelstahl SUS410 geschliffen und gehärtet auf HRC 47 Standard. Eine außergewöhnliche Wärmeabfuhr aus dem Bremsring und ein extrem geringes Gewicht sind weitere Merkmale, welche die hohe Qualität dieser Bremsscheibe unterstreichen.',
            2021,
            'Gewicht 160mm: 85 g / Gewicht 180mm: 112 g',
            'Edelstahl');

        $brake2 = new Brake('1008014',
            'GRX BR-RX810 Scheibenbremssattel Vorderrad schwarz',
            80,
            'Für Fahrten auf rauen Strecken, durch Schotter und Schlamm vorgesehen, damit Sie komfortabel und stressfrei überall hinkommen, wo Sie hin möchten und das einzigartige Gefühl von Leistung erreichen. Die erste von Shimano für Gravelfahrten entwickelte Komponentengruppe.',
            2021,
            'Bremsflüssigkeit: Mineralöl, Typ: Shimano',
            'Aluminium');

        return [
            $brake1,
            $brake2,
        ];
    }
}
