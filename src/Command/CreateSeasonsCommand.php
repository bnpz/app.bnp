<?php

namespace App\Command;

use App\Entity\General\EventType;
use App\Service\General\EventTypeService;
use App\Service\User\UserService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CreateDemoContactsCommand
 * @package App\Command
 */
class CreateSeasonsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:seson:create';



    public function __construct()
    {
        parent::__construct();

    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates All seasons')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Season label')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');


        $io->success('DONE');

        return 0;
    }
}
