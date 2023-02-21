<?php

namespace App\Auth\Query\FindIdentityById;

class Identity
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}