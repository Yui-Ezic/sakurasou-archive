<?php

namespace App\Auth\Command\Join;

class Command
{
    public function __construct(
        public readonly string $userName,
        public readonly string $password
    ) {
    }
}