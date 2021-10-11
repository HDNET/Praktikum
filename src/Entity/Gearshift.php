<?php

namespace App\Entity;

class Gearshift extends AbstractEntity
{
    /**
     * @var int
     */
    protected $gearCount;

    public function __construct(string $articleNumber, string $label, float $price, string $description, int $modellyear, string $properties, int $gearCount)
    {
        parent::__construct($articleNumber, $label, $price, $description, $modellyear, $properties);

        $this->gearCount = $gearCount;
    }

    /**
     * @return int
     */
    public function getGearCount(): int
    {
        return $this->gearCount;
    }

    /**
     * @param int $gearCount
     */
    public function setGearCount(int $gearCount): void
    {
        $this->gearCount = $gearCount;
    }
}
