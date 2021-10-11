<?php

namespace App\Repository;

use App\Entity\Wheel;

class WheelRepository
{
    public function findAll(): array
    {
        $wheel1 = new Wheel('224739',
            'Marathon Plus Tour Drahtreifen Performance 28" Reflex',
            38,
            'Ob Asphalt oder Naturstraße, der vielseitige Reifen ist auf allen Wegen zu Hause. Im Alltag oder auf ganz großer Tour. Der robuste Aufbau steckt alle Misshandlungen weg. Sicher durch SmartGuard, den wirksamsten Schutzgürtel, den es für Fahrradreifen gibt.',
            2021,
            'Reflexstreifen, Pannenschutz');

        $wheel2 = new Wheel('512234',
            'Minion DHR II Faltreifen 27.5" DualC TR EXO',
            48,
            'Alle Maxxis WT Reifen sind für eine innere Felgenbreite von 35 mm optimiert, funktionieren aber ausgezeichnet auf allen Felgen mit einem Innenmass zwischen 30 und 39 mm.',
            2021,
            'Tubeless Ready');

        return [
            $wheel1,
            $wheel2,
        ];
    }
}
