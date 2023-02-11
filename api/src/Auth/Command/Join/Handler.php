<?php

declare(strict_types=1);

namespace App\Auth\Command\Join;

use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserName;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\PasswordHasher;
use App\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
        private readonly Flusher $flusher,
    ) {
    }

    public function handle(Command $command): void
    {
        $userName = new UserName($command->userName);

        if ($this->users->hasByUserName($userName)) {
            throw new DomainException('User already exist.');
        }

        $joinedAt = new DateTimeImmutable();

        $user = new User(
            Id::generate(),
            $userName,
            $this->hasher->hash($command->password),
            $joinedAt
        );

        $this->users->add($user);

        $this->flusher->flush();
    }
}
