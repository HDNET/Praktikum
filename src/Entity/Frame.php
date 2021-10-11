<?php

namespace App\Entity;

class Frame
{
    /**
     * @var string
     */
    protected $articleNumber;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $modellyear;

    /**
     * @var string
     */
    protected $properties;

    public function __construct(string $articleNumber, string $label, float $price, string $description, int $modellyear, string $properties)
    {
        $this->articleNumber = $articleNumber;
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
        $this->modellyear = $modellyear;
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    /**
     * @param mixed $articleNumber
     */
    public function setArticleNumber(string $articleNumber): void
    {
        $this->articleNumber = $articleNumber;
    }

    /**
     * @return mixed
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getModellyear(): int
    {
        return $this->modellyear;
    }

    /**
     * @param mixed $modellyear
     */
    public function setModellyear(int $modellyear): void
    {
        $this->modellyear = $modellyear;
    }

    /**
     * @return mixed
     */
    public function getProperties(): string
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties(string $properties): void
    {
        $this->properties = $properties;
    }
}
