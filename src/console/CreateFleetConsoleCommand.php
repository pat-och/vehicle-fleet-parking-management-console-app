<?php

namespace App\console;

use App\command\fleet\infra\FleetRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateFleetConsoleCommand extends Command
{
    protected static $defaultName = 'fleet:create';
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository, string $name = null)
    {
        $this->fleetRepository = $fleetRepository;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a fleet for a user')
            ->addArgument('userId', InputArgument::REQUIRED, 'enter user ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userId = $input->getArgument('userId');

        if ($userId) {
            $fleets = $this->fleetRepository->all();

            if (!array_key_exists($userId, $fleets)) {
                $this->fleetRepository->addFleet($userId);
                $io->success(
                    sprintf(
                        'created successfully fleet ID %s !',
                        $userId
                    )
                );
                return $userId;
            }
            $io->error('this user already has a fleet ID ' . $userId);
        }

        $io->error('invalid user ID');

        return 0;
    }
}
