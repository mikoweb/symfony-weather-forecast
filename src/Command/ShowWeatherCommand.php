<?php

namespace App\Command;

use App\Query\FindWeatherForecastQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:show-weather',
    description: 'Add a short description for your command',
)]
class ShowWeatherCommand extends Command
{
    private FindWeatherForecastQuery $query;

    public function __construct(FindWeatherForecastQuery $query)
    {
        parent::__construct();
        $this->query = $query;
    }

    protected function configure(): void
    {
        $this
            ->addOption('country', null,InputOption::VALUE_REQUIRED, 'Country')
            ->addOption('city', null,InputOption::VALUE_REQUIRED, 'City')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $forecast = $this->query->find($input->getOption('country'), $input->getOption('city'));

        $io = new SymfonyStyle($input, $output);
        $io->note("Lat: {$forecast->getCoord()->getLat()}");
        $io->note("Lon: {$forecast->getCoord()->getLon()}");

        $table = new Table($output);
        $table
            ->setHeaders(['temperature', 'pressure', 'humidity', 'cloudiness', 'wind_speed', 'wind_deg'])
            ->setRows([[
                $forecast->getTemperature(),
                $forecast->getPressure(),
                $forecast->getHumidity(),
                $forecast->getCloudiness(),
                $forecast->getWind()->getSpeed(),
                $forecast->getWind()->getDeg(),
            ]])
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
