<?php


namespace App\Contract\Service\User;


use App\Entity\User\User;

interface UserServiceInterface
{
    /**
     * @return User|null
     */
    public function getCurrentUser(): ?User;
}