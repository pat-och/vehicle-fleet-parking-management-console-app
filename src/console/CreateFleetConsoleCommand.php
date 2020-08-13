<?php

declare(strict_types=1);

namespace App\console;

use App\command\fleet\app\CreateFleetCommand;
use App\command\fleet\app\CreateFleetCommandHandler;
use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\shared\app\CommandResponse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateFleetConsoleCommand extends Command
{
    protected static $defaultName = 'fleet:create';

    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a fleet for a given user with his ID')
            ->addArgument('userId', InputArgument::REQUIRED, 'user ID')
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


        $commandResponse = new CommandResponse();
        $createFleetCommandHandler = new CreateFleetCommandHandler($this->fleetRepository, $commandResponse);
        $createFleetCommandHandler->handle(new CreateFleetCommand($userId));

        if ($commandResponse->hasError()) {
            $io->error(
                sprintf(
                    $commandResponse->getError() . ' %s',
                    $userId
                )
            );
            return 0;
        }


        $io->success(
            sprintf(
                'created successfully fleet ID %s !',
                $userId
            )
        );

        return 0;
    }
}
