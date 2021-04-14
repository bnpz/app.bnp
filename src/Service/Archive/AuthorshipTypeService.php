<?php
namespace App\Service\Archive;

use App\Entity\Archive\AuthorshipType;
use App\Repository\Archive\AuthorshipTypeRepository;
use App\Service\AbstractEntityService;

/**
 * Class AuthorshipTypeService
 * @package App\Service\Archive
 * @property AuthorshipTypeRepository $repository
 */
class AuthorshipTypeService extends AbstractEntityService
{
    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return AuthorshipType::class;
    }
}