<?php

namespace App\Entity;

class Wheel extends AbstractEntity
{
    public function __construct(string $articleNumber, string $label, float $price, string $description, int $modellyear, string $properties)
    {
        parent::__construct($articleNumber, $label, $price, $description, $modellyear, $properties);
    }
}
