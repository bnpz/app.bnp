<?php

namespace App\Repository;

use App\Util\Paginator;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

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
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     * @throws Exception
     */
    public function getAllPaginator($page = 1, $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC"): Paginator
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        $queryBuilder->addCriteria(Criteria::create()->orderBy([$orderBy => $orderDirection]));

        $paginator = new Paginator($queryBuilder, $limit);
        return $paginator->paginate($page);
    }


    /**
     * @param int $page
     * @param string $query
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     * @throws Exception
     */
    public function getSearchPaginator($page = 1, $query = "", $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC"): Paginator
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

        $paginator = new Paginator($queryBuilder, $limit);
        return $paginator->paginate($page);
    }

    /**
     * @param array $filters
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     * @throws Exception
     */
    public function getFilterPaginator($filters = [], $page = 1, $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC")
    {
        if(is_array($filters) and !empty($filters)){
            $metadata = $this->_em->getClassMetadata($this->_entityName);
            $fieldNames = $metadata->getFieldNames();
            $assocFieldNames = $metadata->getAssociationNames();
            $allFieldNames = array_merge($fieldNames, $assocFieldNames);

            $criteria = Criteria::create();

            foreach ($filters as $filterName => $filterValue) {
                if(in_array($filterName, $allFieldNames)){
                    if($metadata->getTypeOfField($filterName) == "datetime"){
                        $fromDate = new DateTime($filterValue);
                        $fromDate->setTime(0,0);
                        $toDate = new DateTime($filterValue);
                        $toDate->setTime(23, 59);

                        $criteria->andWhere($criteria::expr()->gte($filterName, $fromDate));
                        $criteria->andWhere($criteria::expr()->lte($filterName, $toDate));
                    }
                    else{
                        $criteria->andWhere($criteria::expr()->eq($filterName, $filterValue));
                    }
                }
            }

            $queryBuilder = $this->_em->createQueryBuilder();
            $queryBuilder->select('entity')->from($this->_entityName, 'entity');

            $criteria->orderBy([$orderBy => $orderDirection]);

            $queryBuilder->addCriteria($criteria);

            $paginator = new Paginator($queryBuilder, $limit);
            return $paginator->paginate($page);
        }
        else{
            return $this->getAllPaginator($page, $limit, $orderBy, $orderDirection);
        }
    }
}