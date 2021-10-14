<?php


namespace App\Repository;


use App\Entity\Size;

class SizeRepository
{
    public function findAll(): array
    {

        $size19 = new Size(19, '"19');
        $size20 = new Size(20, '"20');
        $size21 = new Size(21, '"21');
        $size22 = new Size(22, '"22');

        return [
            $size19,
            $size20,
            $size21,
            $size22,
        ];
    }
}