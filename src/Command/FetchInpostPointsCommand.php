<?php

namespace App\Command;


use App\Api\InpostApiService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'shipx-api:fetch-inpost-points')]
class FetchInpostPointsCommand extends Command
{
    private InpostApiService $inpostApiService;

    public function __construct(InpostApiService $inpostApiService)
    {
        parent::__construct();
        $this->inpostApiService = $inpostApiService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Pobiera punkty odbioru InPost dla podanego miasta.')
            ->addArgument('resource', InputArgument::REQUIRED, 'Nazwa zasobu (np. points)')
            ->addArgument('city', InputArgument::REQUIRED, 'Nazwa miasta');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resource = $input->getArgument('resource');
        $city = $input->getArgument('city');

        try {
            $fetchResult = $this->inpostApiService->fetchResource($resource, ['city' => $city]);

            $output->writeln('<info>Dane pobrane pomyślnie!</info>');
            $output->writeln(print_r($fetchResult, true));
        } catch (\Exception $e) {
            $output->writeln('<error>Błąd podczas deserializacji: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
