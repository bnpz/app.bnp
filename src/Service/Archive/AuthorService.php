<?php
namespace App\Service\Archive;

use App\Entity\Archive\Author;
use App\Repository\Archive\AuthorRepository;
use App\Service\AbstractEntityService;

/**
 * Class AuthorService
 * @package App\Service\Archive
 * @property AuthorRepository $repository
 */
class AuthorService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Author::class;
    }
}