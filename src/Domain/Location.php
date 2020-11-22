<?php

namespace App\Domain;

class Location
{
    private $name;
    private $locationType;
    private $coordinates;

    public function __construct(string $name, string $locationType, Coordinates $coordinates)
    {
        $this->name = $name;
        $this->locationType = $locationType;
        $this->coordinates = $coordinates;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLocationType(): string
    {
        return $this->locationType;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }
}
