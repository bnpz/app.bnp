<?php


namespace App\Contract\Service\User;


use App\Entity\User\User;
use Ramsey\Uuid\UuidInterface;

interface UserServiceInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function save(User $user);

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

    /**
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user);
}