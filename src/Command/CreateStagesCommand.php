<?php


namespace App\Command;


use App\Entity\Archive\Season;
use App\Entity\Archive\Stage;
use App\Service\Archive\StageService;
use App\Service\User\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CreateStagesCommand
 * @package App\Command
 */
class CreateStagesCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:stages:create';

    /**
     * @var StageService
     */
    private $stageService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * CreateStagesCommand constructor.
     * @param UserService $userService
     * @param StageService $stageService
     */
    public function __construct(UserService $userService, StageService $stageService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->stageService = $stageService;
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates All stages')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Stage label')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $user = $this->userService->findByEmail("info@bnp.ba");

        $stages = [
            'Velika scena',
            'Mala scena "Žarko Mijatović"',
            'Dječija, omladinska i lutkarska scena',
            'Scena "Studio"'
        ];
        foreach ($stages as $stageName) {
            $existingStage = $this->stageService->getRepository()->findOneBy(['name' => $stageName]);
            if(!$existingStage instanceof Stage){
                $stage = new Stage();
                $stage->setName($stageName)->setCreatedBy($user);
                $this->stageService->save($stage);
            }
        }
        $io->success('DONE');

        return 0;
    }
}