<?php
namespace App\Repository\Archive;

use App\Entity\Archive\AuthorshipType;
use App\Repository\AbstractEntityRepository;

/**
 * Class AuthorshipTypeRepository
 * @package App\Repository\Archive
 */
class AuthorshipTypeRepository extends AbstractEntityRepository
{
    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return AuthorshipType::class;
    }
}