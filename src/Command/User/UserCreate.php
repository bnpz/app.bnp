<?php


namespace App\Command\User;

use App\Entity\User\User;
use App\Service\User\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserCreate
 * @package App\Command\User
 */
class UserCreate extends Command
{
    # the name of the command
    protected static $defaultName = "app:user:create";
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserCreate constructor.
     * @param UserService $userService
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserService $userService,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct();
        $this->userService = $userService;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this->setDescription('Create new user.')
            ->setHelp('Create new user.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');


        $output->writeln(['Create new user', '======================', '']);

        $questionFullName   = new Question('Full name: ', '');
        $questionEmail      = new Question('Email: ', '');
        $questionPassword   = new Question('Password: ', '');
        $questionRole       = new Question('User role (1 = ROLE_USER; 2 = ROLE_ADMIN; 3 = ROLE_EDITOR): ', '');


        $fullName = $helper->ask($input, $output, $questionFullName);
        if(!trim($fullName)) {
            $output->writeln(['Detected empty value.','Nothing is saved.']);
            return;
        }
        $email = $helper->ask($input, $output, $questionEmail);
        if(!trim($email)) {
            $output->writeln(['Detected empty value.','Nothing is saved.']);
            return;
        }
        $password = $helper->ask($input, $output, $questionPassword);
        if(!trim($password)) {
            $output->writeln(['Detected empty value.','Nothing is saved.']);
            return;
        }

        $role = $helper->ask($input, $output, $questionRole);
        if($role != 1 and $role != 2 ){
            $output->writeln(['Wrong role value.','Nothing is saved.']);
            return;
        }

        $user = $this->userService->findByEmail($email);

        # new user
        if(!$user) {
            $newUser = new User();

            $newUser->setName($fullName);
            $newUser->setEmail($email);
            $newUser->setPassword($this->passwordEncoder->encodePassword($newUser, $password));
            $roles = [];
            if($role == 1){
                $roles = ['ROLE_USER'];
            }
            elseif ($role == 2){
                $roles = ['ROLE_ADMIN'];
            }
            elseif ($role == 3){
                $roles = ['ROLE_EDITOR'];
            }
            $newUser->setRoles($roles);

            $this->userService->save($newUser);

            $output->writeln("User created.");
        }
        else{
            $output->writeln("User with email $email already exists!");
        }

        return;
    }
}