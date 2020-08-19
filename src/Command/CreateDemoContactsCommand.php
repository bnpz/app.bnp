<?php

namespace App\Command;

use App\Entity\General\Contact;
use App\Service\General\ContactService;
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
class CreateDemoContactsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:create-demo-contacts';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ContactService
     */
    private $contactService;

    /** @var Generator */
    protected $faker;

    public function __construct(UserService $userService, ContactService $contactService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->contactService = $contactService;
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
            $contact = new Contact;

            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $domain = $this->faker->freeEmailDomain;

            $email = strtolower($firstName).".".strtolower($lastName)."@".$domain;
            $email = str_replace(" ", ".", $email);
            $email = str_replace("'", ".", $email);


            $contact->setCompany($this->faker->company)
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setPhone($this->faker->phoneNumber)
                ->setMobile($this->faker->phoneNumber)
                ->setAddress($this->faker->streetAddress)
                ->setPostNumber($this->faker->postcode)
                ->setCity($this->faker->city)
                ->setCountry($this->faker->country)
                ->setEmail($email)
                ->setCreatedBy($user)
                ->setUpdatedBy($user);


            $this->contactService->save($contact);

            $output->writeln($i);
        }

        $io->success('Done.');

        return 0;
    }
}
