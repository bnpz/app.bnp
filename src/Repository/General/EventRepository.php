<?php
namespace App\Repository\General;

use App\Entity\General\Event;
use App\Repository\AbstractEntityRepository;
use App\Util\Paginator;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;

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
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     */
    public function getNewPaginator($limit = 10, $orderBy = "time", $orderDirection = "DESC"): Paginator
    {

        $criteria = Criteria::create();
        $criteria->andWhere($criteria::expr()->gt('time', new DateTime('now')));
        $criteria->orderBy([$orderBy => $orderDirection]);

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        $queryBuilder->addCriteria($criteria);

        return new Paginator($queryBuilder, $limit);
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
        $criteria = Criteria::create();
        $criteria->andWhere($criteria::expr()->lt('time', new DateTime('now')));
        $criteria->orderBy([$orderBy => $orderDirection]);

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('entity')->from($this->_entityName, 'entity');
        $queryBuilder->addCriteria($criteria);

        return new Paginator($queryBuilder, $limit);
    }
}