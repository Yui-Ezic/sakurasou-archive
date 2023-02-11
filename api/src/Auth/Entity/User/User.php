<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use App\Auth\Service\PasswordHasher;
use DomainException;

class User
{
    private Id $id;

    private UserName $userName;

    private string $passwordHash;

    public function __construct(Id $id, UserName $userName, string $passwordHash)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
    }

    public function changePassword(string $current, string $new, PasswordHasher $hasher): void
    {
        if (!$hasher->validate($current, $this->passwordHash)) {
            throw new DomainException('Incorrect current password.');
        }
        $this->passwordHash = $hasher->hash($new);
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUserName(): UserName
    {
        return $this->userName;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
