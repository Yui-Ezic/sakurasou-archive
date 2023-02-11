<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

interface UserRepository
{
    public function add(User $user): void;

    public function hasByUserName(UserName $userName): bool;
}
