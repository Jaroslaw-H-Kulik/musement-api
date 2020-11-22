<?php

namespace App\Domain;

class WeatherForecast
{
    private $location;

    private $dailyWeatherForecasts;

    public function __construct(Location $location, array $dailyWeatherForecasts)
    {
        $this->location = $location;
        $this->dailyWeatherForecasts = $dailyWeatherForecasts;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getDailyWeatherForecasts(): array
    {
        return $this->dailyWeatherForecasts;
    }
}
