<?php

declare(strict_types=1);


namespace App\command\shared\app;


class CommandResponse
{
    private ?string $error;

    public function __construct()
    {
        $this->error = null;
    }

    public function setError(string $errorMessage): void
    {
        $this->error = $errorMessage;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function hasError()
    {
        return null !== $this->error;
    }
}