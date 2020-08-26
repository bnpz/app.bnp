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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class CreateDemoContactsCommand
 * @package App\Command
 */
class ImportContactsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:contacts:import';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ContactService
     */
    private $contactService;



    public function __construct(UserService $userService, ContactService $contactService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->contactService = $contactService;
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

        $finder = new Finder();
        $finder->files()->in(__DIR__);

        $pathToFile = "";
        foreach ($finder as $file) {
            $extension = $file->getExtension();
            if($extension == 'csv'){
                $pathToFile = $file->getRealPath();
                $output->writeln("Found: ".$pathToFile);
                break;
            }
        }

        $array = $this->csvToArray($pathToFile);

        foreach ($array as $item) {

            $email = trim($item['email']);
            if(!$email) continue;

            $existingContact = $this->contactService->findByEmail($email);

            if($existingContact instanceof Contact){
                $output->writeln("EMAIL EXISTS: ".$email);
                continue;
            }
            else{
                $output->writeln("ADD: ".$email);
                $country = strtoupper($item['country']);
                if($country == "BIH"){
                    $country = "Bosna i Hercegovina";
                }
                elseif ($country == "MNE"){
                    $country = "Crna Gora";
                }
                elseif ($country == "SI"){
                    $country = "Slovenija";
                }
                elseif ($country == "SRB"){
                    $country = "Srbija";
                }
                elseif ($country == "HUN"){
                    $country = "Mađarska";
                }

                $contact = new Contact;

                $contact->setCompany($item['company'])
                    ->setFirstName($item['firstName'])
                    ->setLastName($item['lastName'])
                    ->setPhone($item['phone'])
                    ->setMobile($item['mobile'])
                    ->setAddress($item['address'])
                    ->setPostNumber($item['postNumber'])
                    ->setCity($item['city'])
                    ->setCountry($country)
                    ->setEmail($email)
                    ->setCreatedBy($user)
                    ->setUpdatedBy($user);

                $this->contactService->save($contact);
            }


        }

        $io->success('Done.');

        return 0;
    }

    private function csvToArray($file, $delimiter = ',')
    {
        $data = array();

        if(!file_exists($file) || !is_readable($file)){
            return $data;
        }


        $header = NULL;

        if (($handle = fopen($file, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 9000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
