<?php

namespace App\Infrastructure;


use App\Domain\Coordinates;
use App\Domain\Exception\LocationProviderException;
use App\Domain\Location;
use App\Domain\Ports\LocationProvider;
use GuzzleHttp\ClientInterface;

class MusementCitiesApiClient implements LocationProvider
{
    private const ENDPOINT = 'https://api.musement.com/api/v3/cities';

    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAll(): array
    {
        try {
            $response = $this->httpClient->request('GET', self::ENDPOINT, ['verify' => false]);

            return $this->prepareLocations(json_decode($response->getBody()->getContents()));
        } catch (\Throwable $exception) {
            throw new LocationProviderException("Musement API failed - {$exception->getMessage()}");
        }
    }

    private function prepareLocations(array $citiesData): array
    {
        $locations = [];

        foreach ($citiesData as $cityData) {
            $locations[] = new Location(
                $cityData->name,
                'city',
                new Coordinates(
                    $cityData->longitude,
                    $cityData->latitude
                )
            );
        }

        return $locations;
    }
}
