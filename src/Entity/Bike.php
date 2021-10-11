<?php

namespace App\Entity;

class Bike
{
    /**
     * @var Brake
     */
    protected $brake;

    /**
     * @var Frame
     */
    protected $frame;

    /**
     * @var Gearshift
     */
    protected $gearshift;

    /**
     * @var Wheel
     */
    protected $wheel;

    /**
     * @return Brake
     */
    public function getBrake(): Brake
    {
        return $this->brake;
    }

    /**
     * @param Brake $brake
     */
    public function setBrake(Brake $brake): void
    {
        $this->brake = $brake;
    }

    /**
     * @return Frame
     */
    public function getFrame(): Frame
    {
        return $this->frame;
    }

    /**
     * @param Frame $frame
     */
    public function setFrame(Frame $frame): void
    {
        $this->frame = $frame;
    }

    /**
     * @return Gearshift
     */
    public function getGearshift(): Gearshift
    {
        return $this->gearshift;
    }

    /**
     * @param Gearshift $gearshift
     */
    public function setGearshift(Gearshift $gearshift): void
    {
        $this->gearshift = $gearshift;
    }

    /**
     * @return Wheel
     */
    public function getWheel(): Wheel
    {
        return $this->wheel;
    }

    /**
     * @param Wheel $wheel
     */
    public function setWheel(Wheel $wheel): void
    {
        $this->wheel = $wheel;
    }
}
