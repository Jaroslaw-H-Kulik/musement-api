<?php

namespace App\Domain\Ports;

use App\Domain\WeatherForecast;
use App\Domain\Exception\WeatherForecastProviderException;
use App\Domain\Location;

interface WeatherForecastProvider
{
    /** @throws WeatherForecastProviderException */
    public function getDailyWeatherForecastBy(Location $location, int $numOfDays): WeatherForecast;
}
