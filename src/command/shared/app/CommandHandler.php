<?php

declare(strict_types=1);


namespace App\command\shared\app;


class CommandHandler
{
    private CommandResponse $commandResponse;

    public function __construct(CommandResponse $commandResponse)
    {
        $this->commandResponse = $commandResponse;
    }

    public function getCommandResponse(): CommandResponse
    {
        return $this->commandResponse;
    }
}