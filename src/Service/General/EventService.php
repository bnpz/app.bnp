<?php

namespace App\Service\General;

use App\Entity\General\Event;
use App\Repository\General\EventRepository;
use App\Service\AbstractEntityService;
use App\Util\Paginator;
use Doctrine\ORM\Query\QueryException;
use Exception;

/**
 * Class EventService
 * @package App\Service\General
 * @property EventRepository $repository
 */
class EventService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Event::class;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     * @throws Exception
     */
    public function getNewPaginator($page = 1, $limit = 10, $orderBy = "time", $orderDirection = "DESC")
    {
        $paginator = $this->repository->getNewPaginator($limit, $orderBy, $orderDirection);

        return $paginator->paginate($page);
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDirection
     * @return Paginator
     * @throws QueryException
     * @throws Exception
     */
    public function getOldPaginator($page = 1, $limit = 10, $orderBy = "time", $orderDirection = "DESC")
    {
        $paginator = $this->repository->getOldPaginator($limit, $orderBy, $orderDirection);

        return $paginator->paginate($page);
    }
}