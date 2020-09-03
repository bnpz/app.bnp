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
class EventTypeCreateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:event-type:create';

    /**
     * @var EventTypeService
     */
    private $eventTypeService;
    /**
     * @var UserService
     */
    private $userService;

    private $defaultTypes = [
        "predstava",
        "koncert",
        "promocija",
        "tribina",
        "svečanost",
        "izložba",
        "balet",
        "opera",
        "ples",
        "ostalo"
    ];

    public function __construct(EventTypeService $eventTypeService, UserService $userService)
    {
        parent::__construct();
        $this->eventTypeService = $eventTypeService;
        $this->userService = $userService;
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates EventType item')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'EventType name')
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

        $newTypes = [];
        $user = $this->userService->findByEmail("nermingk@gmail.com");

        if ($eventTypeName = $arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
            $newTypes[] = $eventTypeName;
        }
        else{
            $newTypes = $this->defaultTypes;
        }


        foreach ($newTypes as $eventTypeName) {

            $existingType = $this->eventTypeService->findByName($eventTypeName);

            if($existingType instanceof EventType){
                $io->note(sprintf('Event type (%s) exists.', $eventTypeName));
            }
            else{
                $eventType = new EventType();
                $eventType->setName($eventTypeName)
                    ->setCreatedBy($user)
                    ->setUpdatedBy($user);

                $newType = $this->eventTypeService->save($eventType);

                $io->success('Success. ID: '.$newType->getId());
            }

        }


        $io->success('DONE');

        return 0;
    }
}
