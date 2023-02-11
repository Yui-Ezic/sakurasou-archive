<?php

declare(strict_types=1);

namespace App\Auth\Command\Join;

class Command
{
    public function __construct(
        public readonly string $userName,
        public readonly string $password
    ) {
    }
}
