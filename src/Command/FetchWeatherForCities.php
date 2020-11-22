<?php

namespace App\Command;

use App\Domain\Exception\ApplicationException;
use App\Handler\FetchWeatherForLocationsHandler;
use App\Response\WeatherForecastForLocationResponse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchWeatherForCities extends Command
{
    private const NUMBER_OF_DAYS_ARG = 'nDays';

    private $handler;

    protected static $defaultName = 'app:fetch-weather-for-cities';

    public function __construct(FetchWeatherForLocationsHandler $handler)
    {
        $this->handler = $handler;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetching weather forecast started.')
            ->addArgument(
                self::NUMBER_OF_DAYS_ARG,
                InputArgument::OPTIONAL,
                'n-day weather forecast',
                2
            )
            ->setHelp('This command allows you to fetch weather forecast for cities provided by Musement api.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfDays = $input->getArgument(self::NUMBER_OF_DAYS_ARG);

        if (!is_numeric($numberOfDays)) {
            $output->writeln('Arg ' . self::NUMBER_OF_DAYS_ARG . 'needs to be an integer.');
            return Command::FAILURE;
        }

        if ($numberOfDays === 0 || $numberOfDays > 3) {
            $output->writeln('Arg ' . self::NUMBER_OF_DAYS_ARG . 'needs to be within range 1-3.');
            return Command::FAILURE;
        }

        try {
            $weatherForecasts = $this->handler->__invoke($numberOfDays);
        } catch (ApplicationException $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        foreach ($weatherForecasts as $weatherForecast) {
            $output->writeln(new WeatherForecastForLocationResponse($weatherForecast));
        }

        return Command::SUCCESS;
    }
}
