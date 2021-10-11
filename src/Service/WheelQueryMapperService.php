<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use App\Entity\Bike;
use App\Entity\Brake;
use App\Repository\BrakeRepository;
use App\Repository\FrameRepository;
use App\Repository\GearRepository;
use App\Repository\WheelRepository;

class WheelQueryMapperService
{
    public function __construct(protected BrakeRepository $brakeRepository, protected GearRepository $gearRepository, protected FrameRepository $frameRepository, protected WheelRepository $wheelRepository)
    {
    }

    protected function getValue(int $index): mixed
    {
        $callback = function (AbstractEntity $var) use ($index, $parameters) {
            return str_contains($var->getLabel(), $parameters[$index]);
        };

        $resultArray = \array_filter($this->brakeRepository->findAll(), $callback);
        if (\count($resultArray) != 1) {
            throw new \RuntimeException('Should find only one!');
        }
        return $resultArray[0];
    }

    public function getBikeFromQuery(array $parameters): Bike
    {
        $result = new Bike();

        $result->setBrake($this->getValue(0));
        $result->setFrame($this->getValue(1));
        $result->setGearshift($this->getValue(2));
        $result->setWheel($this->getValue(3));

        return $result;
    }
}
