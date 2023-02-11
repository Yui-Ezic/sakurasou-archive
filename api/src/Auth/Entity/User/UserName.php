<?php

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;

class UserName
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::lessThan($value, 20);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}