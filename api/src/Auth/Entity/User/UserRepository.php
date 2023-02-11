<?php

namespace App\Auth\Entity\User;

interface UserRepository
{
    public function add(User $user): void;
    public function hasByUserName(UserName $userName): bool;
}