<?php


namespace App\Service\User;


use App\Contract\Service\User\UserServiceInterface;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->security->getUser();
    }
}