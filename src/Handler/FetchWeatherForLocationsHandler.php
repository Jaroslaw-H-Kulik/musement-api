<?php

namespace App\Handler;

use App\Domain\Ports\LocationProvider;
use App\Domain\Ports\WeatherForecastProvider;

class FetchWeatherForLocationsHandler
{
    private $locationProvider;
    private $weatherForecastProvider;

    public function __construct(LocationProvider $locationProvider, WeatherForecastProvider $weatherForecastProvider)
    {
        $this->locationProvider = $locationProvider;
        $this->weatherForecastProvider = $weatherForecastProvider;
    }

    public function __invoke(int $numberOfDays): array
    {
        $locations = $this->locationProvider->getAll();

        $weatherForecasts = [];

        foreach ($locations as $location) {
            $weatherForecasts[] = $this->weatherForecastProvider->getDailyWeatherForecastBy($location, $numberOfDays);
        }

        return $weatherForecasts;
    }
}
