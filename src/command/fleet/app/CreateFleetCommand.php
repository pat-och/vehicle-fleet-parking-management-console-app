<?php

declare(strict_types=1);


namespace App\command\fleet\app;


class CreateFleetCommand
{

    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}