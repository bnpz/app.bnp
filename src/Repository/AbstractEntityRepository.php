<?php

namespace App\Repository;

use App\Util\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AbstractEntityRepository
 * @package App\Repository
 */
abstract class AbstractEntityRepository extends ServiceEntityRepository
{
    /**
     * AbstractEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
      {
          parent::__construct($registry, $this->getEntityClassName());
      }

    abstract protected function getEntityClassName();

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     */
    public function getAllPaginator($limit = 10, $orderBy = "createdAt", $orderDirection = "DESC"): Paginator
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        $queryBuilder->addCriteria(Criteria::create()->orderBy([$orderBy => $orderDirection]));

        return new Paginator($queryBuilder, $limit);

    }



    /**
     * @param string $query
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     */
    public function getSearchPaginator($query = "", $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC"): Paginator
    {
        $criteria = Criteria::create();

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        if(trim($query)){
            $metadata = $this->_em->getClassMetadata($this->_entityName);
            foreach ($metadata->getFieldNames() as $field) {
                if($metadata->getTypeOfField($field) == "string"){
                    $queryBuilder->orWhere('lower(entity.' . $field . ') LIKE lower(:value)')
                        ->setParameters(array(':value' => '%' . $query . '%'));
                }
            }
        }
        $queryBuilder->addCriteria($criteria->orderBy([$orderBy => $orderDirection]));

        return new Paginator($queryBuilder, $limit);
    }
}