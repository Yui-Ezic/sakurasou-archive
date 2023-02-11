<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use App\Auth\Service\PasswordHasher;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: 'auth_users')]
class User
{
    #[ORM\Column(type: 'auth_user_id')]
    #[ORM\Id]
    private Id $id;

    #[ORM\Column(type: 'auth_user_username', unique: true)]
    private UserName $userName;

    #[ORM\Column(type: 'string')]
    private string $passwordHash;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $joinedAt;

    public function __construct(Id $id, UserName $userName, string $passwordHash, DateTimeImmutable $joinedAt)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->joinedAt = $joinedAt;
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

    public function getJoinedAt(): DateTimeImmutable
    {
        return $this->joinedAt;
    }
}
