<?php
namespace App\Service\Archive;

use App\Entity\Archive\Author;
use App\Repository\Archive\AuthorRepository;
use App\Service\AbstractEntityService;
use Doctrine\ORM\NonUniqueResultException;

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

    /**
     * @param null $firstName
     * @param null $lastName
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getByFirstAndLastName($firstName = null, $lastName = null)
    {
        return $this->repository->getByFirstAndLastName($firstName, $lastName);
    }
}