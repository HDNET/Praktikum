<?php

namespace App\Entity;

class Frame extends AbstractEntity
{
    public function __construct(string $articleNumber, string $label, float $price, string $description, int $modellyear, string $properties)
    {
        parent::__construct($articleNumber, $label, $price, $description, $modellyear, $properties);
    }
}
