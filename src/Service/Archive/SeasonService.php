<?php

namespace App\Service\Archive;

use App\Contract\Service\Archive\SeasonServiceInterface;
use App\Entity\Archive\Season;
use App\Service\AbstractEntityService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;

class SeasonService extends AbstractEntityService implements SeasonServiceInterface
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Season::class;
    }

    /**
     * @param Season $season
     * @return Season|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Season $season): ?Season
    {
        return $this->saveEntity($season);
    }

    /**
     * @param Season $season
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Season $season): bool
    {
        return $this->deleteEntity($season);
    }

    /**
     * @param int $id
     * @return Season|null
     * @throws Exception
     */
    public function findOne(int $id): ?Season
    {
        return $this->get($id);
    }

    /**
     * @return Season[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}