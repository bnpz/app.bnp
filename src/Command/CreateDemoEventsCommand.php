<?php

namespace App\Command;

use App\Entity\General\Contact;
use App\Entity\General\Event;
use App\Service\General\EventService;
use App\Service\User\UserService;
use Faker\Factory;
use Faker\Generator;
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
class CreateDemoEventsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:create-demo-events';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var EventService
     */
    private $eventService;

    /** @var Generator */
    protected $faker;

    public function __construct(UserService $userService, EventService $eventService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->eventService = $eventService;
        $this->faker = Factory::create();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }
        else{
            $arg1 = 5;
        }

        $user = $this->userService->findByEmail("nermingk@gmail.com");

        for ($i = 0; $i < $arg1; $i++){

            $event = new Event();
            $event->setCreatedBy($user)
                ->setUpdatedBy($user)
                ->setProduction($this->faker->company)
                ->setName(ucwords($this->faker->words(3, true)))
                ->setDescription($this->faker->words(2, true))
                ->setTime($this->faker->dateTimeThisYear("2020-12-31"))
                ->setPremiere(false)
                ->setExternalProduction($this->faker->boolean)
                ->setNote($this->faker->sentence(8, true));

            $this->eventService->save($event);

            $output->writeln($i);
        }

        $io->success('Done.');

        return 0;
    }
}
