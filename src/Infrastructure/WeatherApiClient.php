<?php

namespace App\Infrastructure;

use App\Domain\DailyWeatherForecast;
use App\Domain\WeatherForecast;
use App\Domain\Exception\WeatherForecastProviderException;
use App\Domain\Location;
use App\Domain\Ports\WeatherForecastProvider;
use DateTime;
use GuzzleHttp\ClientInterface;

class WeatherApiClient implements WeatherForecastProvider
{
    private const ENDPOINT = 'http://api.weatherapi.com/v1/forecast.json?';

    private const API_KEY = 'cf12e4ef48574d68a67185659202011';

    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getDailyWeatherForecastBy(Location $location, int $numOfDays): WeatherForecast
    {
        $uri = self::ENDPOINT . $this->prepareQueryString($location, $numOfDays);

        try {
            $response = $this->httpClient->request('GET', $uri);

            return $this->prepareWeatherForecast(
                $location,
                (json_decode($response->getBody()->getContents()))->forecast->forecastday
            );
        } catch (\Throwable $exception) {
            throw new WeatherForecastProviderException("WeatherAPI failed - {$exception->getMessage()}");
        }
    }

    private function prepareQueryString(Location $location, int $numOfDays): string
    {
        $query = [
            'q' => $location->getCoordinates()->getLatitude() . ',' . $location->getCoordinates()->getLongitude(),
            'key' => self::API_KEY,
            'days' => $numOfDays
        ];

        return http_build_query($query);
    }

    private function prepareWeatherForecast(Location $location, array $weatherForecastData): WeatherForecast
    {
        $dailyForecasts = [];

        foreach ($weatherForecastData as $dailyWeatherForecastData) {
            $dailyForecasts[] = new DailyWeatherForecast(
                $dailyWeatherForecastData->day->condition->text,
                new DateTime($dailyWeatherForecastData->date)
            );
        }

        return new WeatherForecast(
            $location,
            $dailyForecasts
        );
    }
}
