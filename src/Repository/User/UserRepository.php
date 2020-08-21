<?php
namespace App\Repository\User;

use App\Entity\User\User;
use App\Repository\AbstractEntityRepository;

class UserRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return User::class;
    }
}