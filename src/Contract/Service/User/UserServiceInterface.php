<?php


namespace App\Contract\Service\User;


use App\Entity\User\User;
use Ramsey\Uuid\UuidInterface;

interface UserServiceInterface
{
    /**
     * @param User $transferEntity
     * @param User|null $managedEntity
     * @return User
     */
    public function save(User $transferEntity, ?User $managedEntity);

    /**
     * @param User $transferEntity
     * @return User
     */
    public function create(User $transferEntity);

    /**
     * @param User $managedEntity
     * @param User $transferEntity
     * @return User
     */
    public function update(User $managedEntity, User $transferEntity);

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user);

    /**
     * @param UuidInterface | string $id
     * @return User
     */
    public function findById($id);


    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User;

    /**
     * @param User $user
     * @param string $password
     * @return User
     */
    public function saveNewPassword(User $user, string $password);
}