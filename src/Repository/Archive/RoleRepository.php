<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Role;
use App\Repository\AbstractEntityRepository;

/**
 * Class RoleRepository
 * @package App\Repository\Archive
 */
class RoleRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Role::class;
    }
}