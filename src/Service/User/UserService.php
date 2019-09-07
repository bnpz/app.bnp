<?php


namespace App\Service\User;


use App\Contract\Service\User\UserServiceInterface;
use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Service\Base\AbstractEntityService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class UserService extends AbstractEntityService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    protected $repository;
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        ManagerRegistry $managerRegistry,
        UserRepository $userRepository,
        Security $security
    )
    {
        parent::__construct($managerRegistry);
        $this->repository = $userRepository;
        $this->security = $security;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return User::class;
    }
    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->security->getUser();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }


}