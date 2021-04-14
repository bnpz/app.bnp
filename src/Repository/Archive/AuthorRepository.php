<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Author;
use App\Repository\AbstractEntityRepository;

/**
 * Class AuthorRepository
 * @package App\Repository\Archive
 */
class AuthorRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Author::class;
    }
}