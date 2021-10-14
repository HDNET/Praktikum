<?php


namespace App\Repository;


use App\Entity\Color;

class ColorRepository
{
    public function findAll(): array
    {
        $colorRed = new Color('red', '');
        $colorBlue = new Color('blue', '');
        $colorGreen = new Color('green', '');
        $colorGray = new Color('gray', '');

        return [
            $colorRed,
            $colorBlue,
            $colorGreen,
            $colorGray,
        ];
    }
}