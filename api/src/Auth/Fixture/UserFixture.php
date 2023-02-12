<?php

declare(strict_types=1);

namespace App\Auth\Fixture;

use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserName;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
    // 'password'
    private const PASSWORD_HASH = '$2y$12$qwnND33o8DGWvFoepotSju7eTAQ6gzLD/zy6W8NCVtiHPbkybz.w6';

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            new Id('00000000-0000-0000-0000-000000000001'),
            new UserName('YuiEzic'),
            self::PASSWORD_HASH,
            new DateTimeImmutable('-30 days'),
        );

        $manager->persist($user);

        $manager->flush();
    }
}
