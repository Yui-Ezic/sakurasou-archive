<?php

declare(strict_types=1);

namespace App\Console\Auth;

use App\Auth\Command\Join\Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        parent::__construct();
        $this->handler = $handler;
    }

    protected function configure(): void
    {
        $this
            ->setName('auth:create-user')
            ->setDescription('Creating new user')
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new \App\Auth\Command\Join\Command(
            (string)$input->getArgument('username'),
            (string)$input->getArgument('password'),
        );

        $this->handler->handle($command);

        return 0;
    }
}
