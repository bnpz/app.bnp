<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Author;
use App\Entity\Archive\Performance;
use App\Repository\AbstractEntityRepository;
use Doctrine\ORM\NonUniqueResultException;

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

    /**
     * @param null $firstName
     * @param null $lastName
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getByFirstAndLastName($firstName = null, $lastName = null)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('author')
            ->from(Author::class, 'author')
            ->where('lower(author.firstName) = lower(:firstName)')
            ->andWhere('lower(author.lastName) = lower(:lastName)')
            ->setParameter('firstName', trim($firstName))
            ->setParameter('lastName', trim($lastName));

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Author $author
     * @return Performance[]|mixed
     */
    public function getPerformances(Author $author)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('performance')
            ->from(Performance::class, 'performance')
            ->leftJoin('performance.authorships', 'authorships')
            ->leftJoin('performance.roles', 'roles')
            ->where('authorships.author = :authorId')
            ->orWhere('roles.author = :authorId')
            ->setParameter('authorId', $author->getId())
            ->orderBy('performance.premiereDate', 'DESC')
        ;
        return $queryBuilder->getQuery()->getResult();
    }
}