<?php
namespace App\Service\Archive;

use App\Entity\Archive\Role;
use App\Repository\Archive\RoleRepository;
use App\Service\AbstractEntityService;

/**
 * Class RoleService
 * @package App\Service\Archive
 * @property RoleRepository $repository
 */
class RoleService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Role::class;
    }
}