<?php

namespace App\Response;

use App\Domain\WeatherForecast;

class WeatherForecastForLocationResponse
{
    private $weatherForecast;

    public function __construct(WeatherForecast $weatherForecast)
    {
        $this->weatherForecast = $weatherForecast;
    }

    public function __toString()
    {
        $cityName = $this->weatherForecast->getLocation()->getName();
        $locationType = $this->weatherForecast->getLocation()->getLocationType();

        $response = "Processed $locationType $cityName |";

        $isElementFirst = true;

        foreach ($this->weatherForecast->getDailyWeatherForecasts() as $dailyWeatherForecast) {
            $response .= ($isElementFirst ? ' ' : ' - ') . $dailyWeatherForecast->getCondition();
            $isElementFirst = false;
        }

        return $response;
    }
}
