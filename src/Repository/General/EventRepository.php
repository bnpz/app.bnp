<?php
namespace App\Repository\General;

use App\Entity\General\Event;
use App\Repository\AbstractEntityRepository;
use App\Util\Paginator;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EventRepository
 * @package App\Repository\General
 */
class EventRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Event::class;
    }

    /**
     * @param string $orderBy
     * @param string $orderDirection
     * @param bool $newOnly
     * @param bool $oldOnly
     * @return QueryBuilder
     * @throws QueryException
     */
    public function getAllEventsQueryBuilder($orderBy = "time", $orderDirection = "DESC", $newOnly = false, $oldOnly = false)
    {
        $criteria = Criteria::create();
        if($newOnly){
            $criteria->andWhere($criteria::expr()->gte('time', new DateTime('now')));
        }
        elseif ($oldOnly){
            $criteria->andWhere($criteria::expr()->lt('time', new DateTime('now')));
        }

        $criteria->orderBy([$orderBy => $orderDirection]);

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        $queryBuilder->addCriteria($criteria);

        return $queryBuilder;
    }
    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     */
    public function getNewPaginator($limit = 10, $orderBy = "time", $orderDirection = "DESC"): Paginator
    {
        return new Paginator($this->getAllEventsQueryBuilder($orderBy, $orderDirection, true), $limit);
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     */
    public function getOldPaginator($limit = 10, $orderBy = "time", $orderDirection = "DESC"): Paginator
    {
        return new Paginator($this->getAllEventsQueryBuilder($orderBy, $orderDirection, false, true), $limit);
    }

    public function getFilterPaginator($filters = [], $page = 1, $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC")
    {
        if(is_array($filters) and !empty($filters)){
            $criteria = Criteria::create();

            $metadata = $this->_em->getClassMetadata($this->_entityName);
            $fieldNames = array_merge($metadata->getFieldNames(), $metadata->getAssociationNames());


            foreach ($filters as $filterName => $filterValue) {
                if(in_array($filterName, $fieldNames)){
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

            $criteria->orderBy([$orderBy => $orderDirection]);

            if(isset($filters['fromDate'])){
                $fromDate = new DateTime($filters['fromDate']);
                $fromDate->setTime(0,0);
                $criteria->andWhere($criteria::expr()->gte('time', $fromDate));
                $criteria->orderBy(['time' => 'ASC']);
            }
            if(isset($filters['toDate'])){
                $toDate = new DateTime($filters['toDate']);
                $toDate->setTime(23, 59);
                $criteria->andWhere($criteria::expr()->lte('time', $toDate));
            }

            $queryBuilder = $this->_em->createQueryBuilder();
            $queryBuilder->select('entity')->from($this->_entityName, 'entity');



            $queryBuilder->addCriteria($criteria);

            $paginator = new Paginator($queryBuilder, $limit);
            return $paginator->paginate($page);
        }
        else{
            return $this->getAllPaginator($page, $limit, $orderBy, $orderDirection);
        }
    }
}