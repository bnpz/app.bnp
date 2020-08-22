<?php


namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Service\AbstractEntityService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserService
 * @package App\Service\User
 * @property UserRepository $repository
 */
class UserService extends AbstractEntityService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserService constructor.
     * @param ManagerRegistry $managerRegistry
     * @param ValidatorInterface $validator
     * @param Security $security
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SessionInterface $session
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        ValidatorInterface $validator,
        Security $security,
        UserPasswordEncoderInterface $passwordEncoder,
        SessionInterface $session
    )
    {
        parent::__construct($managerRegistry, $validator, $session);

        $this->security = $security;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return User::class;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return $this->security->getUser();
    }
    /**
     * @param User $user
     * @param string $password
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveNewPassword(User $user, string $password)
    {
        $newPasword = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($newPasword);
        return $this->save($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user)
    {
        if(in_array("ROLE_ADMIN", $user->getRoles())){
            return true;
        }
        else{
            return false;
        }
    }

}