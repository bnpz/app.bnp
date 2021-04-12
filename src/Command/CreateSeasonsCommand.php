<?php

namespace App\Command;

use App\Entity\Archive\Season;
use App\Entity\General\EventType;
use App\Service\Archive\SeasonService;
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
    protected static $defaultName = 'app:season:create';

    /**
     * @var SeasonService
     */
    private $seasonService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * CreateSeasonsCommand constructor.
     * @param UserService $userService
     * @param SeasonService $seasonService
     */
    public function __construct(UserService $userService, SeasonService $seasonService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->seasonService = $seasonService;
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
        $user = $this->userService->findByEmail("info@bnp.ba");

        $year = 1950;
        $seasons[] = $year;
        for ($year = 1950; $year <= 2020; $year++) {
            $nextYear = $year + 1;
            if($nextYear != 2000){
                $shortNextYear = substr($nextYear, -2);
            }
            else{
                $shortNextYear = $nextYear;
            }

            $label = $year."/".$shortNextYear.".";
            $seasons[] = $label;
        }

        foreach ($seasons as $key => $label) {
            $existingSeason = $this->seasonService->getByLabel($label);
            if($existingSeason instanceof Season){
                $output->writeln($key + 1 ." - $label - exists");
            }
            else{
                $output->writeln($key + 1 ." - $label");
                $season = new Season();
                $season->setNumber($key + 1);
                $season->setLabel($label);
                $season->setCreatedBy($user);
                $this->seasonService->save($season);
            }
        }

        $io->success('DONE');

        return 0;
    }
}
