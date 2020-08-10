<?php

namespace App\console;

use App\command\fleet\infra\FleetRepositoryInterface;
use App\query\app\FleetQueryHandlerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\acceptance\query\FleetQueryHandlerTest;

class CreateFleetConsoleCommand extends Command
{
    protected static $defaultName = 'fleet:create';

    private FleetRepositoryInterface $fleetRepository;
    private FleetQueryHandlerInterface $fleetQueryHandler;

    public function __construct(FleetRepositoryInterface $fleetRepository,
                                FleetQueryHandlerInterface $fleetQueryHandler)
    {
        $this->fleetRepository = $fleetRepository;
        $this->fleetQueryHandler = $fleetQueryHandler;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a fleet for a given user with his ID')
            ->addArgument('userId', InputArgument::REQUIRED, 'enter user ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userId = $input->getArgument('userId');

        if (!isset($userId)) {
            $io->error('invalid user ID');
            return 0;
        }

        if (array_key_exists($userId, $this->fleetQueryHandler->getAll())) {

            $io->error('this user already has a fleet ID ' . $userId);
            return 0;
        }

        $this->fleetRepository->addFleet($userId); // @todo refactor with CreateFleetCommandHandler & TDD here

        $io->success(
            sprintf(
                'created successfully fleet ID %s !',
                $userId
            )
        );

        return $userId;
    }
}
