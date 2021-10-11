<?php

namespace App\Repository;

use App\Entity\Frame;

class FrameRepository
{
    public function findAll(): array
    {
        $frame1 = new Frame('932961',
            'Cody Tapered Rahmen',
            449,
            'Eine technische Meisterleistung aus gefaltetem, nahtlosem Cr-Mo Stahlrohren. Mit hydrogeformten Kettenstreben, Steuerrohr im Sanduhr Design und verstärkte Partien an den empfindlichen Stellen ist dieser Rahmen atemberaubend. Deswegen fährt auch Dirtjump Star Szymon Godziek diesen Rahmen. Einzige Änderung gegenüber unserem bekannten Cody Rahmen, dass Dartmoor sich entschieden haben ihn auch mit einem tapered Steuerrohr anzubieten.',
            2021,
            'Federgabel kompatibel, Scheibenbremsaufnahme');

        $frame2 = new Frame('1302055',
            'GRIFFIN PRO',
            407,
            'Das Griffon ist eine reinrassige Dirtjumpmaschine. Durch die Verwendung eines hochwertigen 6061-t6-Aluminiumrahmens und Radio Bikes eigenen Radio-Ovalrohren für eine insgesamt steifere und haltbarere Konstruktion als ein durchschnittlicher Dirtjump-Rahmen konnten sie eine leichte und reaktionsfähige Dirt-/Slopestylewaffe entwickeln, die alles bewältigen kann, von riesigen Wettkampf-Setups bis hin zu bahnbrechenden innovativen Tricks.',
            2021,
            'Federgabel kompatibel, Scheibenbremsaufnahme');

        return [
            $frame1,
            $frame2,
        ];
    }
}
