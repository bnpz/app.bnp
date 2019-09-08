<?php


namespace App\Command\User;


use App\Contract\Service\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class UserPassword
 * @package App\Command\User
 */
class UserPassword extends Command
{
# the name of the command
    protected static $defaultName = "app:user:password";
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * UserPassword constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(
        UserServiceInterface $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Set new user password.')
            ->setHelp('Create new password for existing user.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');


        $output->writeln(['Set new password for user', '======================', '']);

        $questionEmail      = new Question('User email: ', '');
        $email              = $helper->ask($input, $output, $questionEmail);
        if(!trim($email)) {
            $output->writeln(['Detected empty value.','Nothing is saved.']);
            return;
        };

        $user = $this->userService->findByEmail($email);
        if($user){
            $output->writeln(['User name: '.$user->getName()]);
            $questionPassword   = new Question('Enter new password: ', '');
            $password = $helper->ask($input, $output, $questionPassword);
            if(!trim($password)) {
                $output->writeln(['Detected empty value.','Nothing is saved.']);
                return;
            };

            $this->userService->saveNewPassword($user, $password);

            $output->writeln(['New pasword is saved.','DONE.']);
        }
        else{
            $output->writeln("User with email $email not exists!");
        }
    }
}