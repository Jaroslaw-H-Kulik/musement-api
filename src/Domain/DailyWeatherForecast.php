<?php

namespace App\Domain;

class DailyWeatherForecast
{
    private $condition;

    private $date;

    public function __construct(string $condition, \DateTime $date)
    {
        $this->condition = $condition;
        $this->date = $date;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }
}
