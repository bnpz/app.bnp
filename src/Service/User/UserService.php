<?php


namespace App\Service\User;

use App\Contract\Service\User\UserServiceInterface;
use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Service\Base\AbstractEntityService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserService
 * @package App\Service\User
 */
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
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        ManagerRegistry $managerRegistry,
        UserRepository $userRepository,
        Security $security,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct($managerRegistry);
        $this->repository = $userRepository;
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
     * @param User $transferEntity
     * @param User|null $managedEntity
     * @return User
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $transferEntity, ?User $managedEntity = null)
    {
        if($transferEntity->getId() !== "") {
            $managedEntity = isset($managedEntity) ? $managedEntity : $this->get($transferEntity->getId());
        }

        if (isset($managedEntity)){
            return $this->update($managedEntity, $transferEntity);
        }

        return $this->create($transferEntity);
    }

    /**
     * @param User $transferEntity
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(User $transferEntity)
    {
        $managedEntity = User::init();
        $user = $this->setFields($managedEntity, $transferEntity);
        $this->saveEntity($user);
        return $user;
    }

    /**
     * @param User $managedEntity
     * @param User $transferEntity
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(User $managedEntity, User $transferEntity)
    {
        $user = $this->setFields($managedEntity, $transferEntity);
        $this->saveEntity($user);
        return $user;
    }

    /**
     * @param User $user
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(User $user)
    {
        $this->deleteEntity($user);
    }

    /**
     * @param UuidInterface | string $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function findById($id)
    {
        return $this->get($id);
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

    private function setFields(User $managedEntity, User $transferEntity): User
    {
        $this->transcribe($transferEntity, $managedEntity, [
            'name',
            'email',
            'roles',
            'password'
        ]);
        return $managedEntity;
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
        $this->saveEntity($user);
        return $user;
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