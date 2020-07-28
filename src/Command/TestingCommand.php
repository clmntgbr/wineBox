<?php

namespace App\Command;

use App\Entity\User\User;
use App\Util\Generator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestingCommand extends Command
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var Generator */
    private $generator;

    protected static $defaultName = 'app:testing';

    public function __construct(EntityManagerInterface $em, Generator $generator)
    {
        parent::__construct(self::$defaultName);
        $this->em = $em;
        $this->generator = $generator;
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generator->load(28, 25);

        return 1;
    }
}
