<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Author;
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
}