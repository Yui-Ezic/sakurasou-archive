<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        /**
         * @var EntityRepository<User>
         */
        private readonly EntityRepository $repo
    ) {
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function hasByUserName(UserName $userName): bool
    {
        return $this->repo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.userName = :username')
            ->setParameter(':username', $userName->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }
}
