<?php

namespace App\Entity;

class Brake extends AbstractEntity
{
    /**
     * @var string
     */
    protected $materialType;

    public function __construct(string $articleNumber, string $label, float $price, string $description, int $modellyear, string $properties, string $materialType)
    {
        parent::__construct($articleNumber, $label, $price, $description, $modellyear, $properties);

        $this->materialType = $materialType;
    }

    /**
     * @return string
     */
    public function getMaterialType(): string
    {
        return $this->materialType;
    }

    /**
     * @param string $materialType
     */
    public function setMaterialType(string $materialType): void
    {
        $this->materialType = $materialType;
    }
}
