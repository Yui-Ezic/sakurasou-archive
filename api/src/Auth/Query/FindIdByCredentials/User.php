<?php

namespace App\Auth\Query\FindIdByCredentials;

final class User
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}