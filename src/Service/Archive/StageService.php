<?php


namespace App\Service\Archive;


use App\Contract\Service\Archive\StageServiceInterface;
use App\Entity\Archive\Stage;
use App\Service\AbstractEntityService;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class StageService extends AbstractEntityService implements StageServiceInterface
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Stage::class;
    }

    /**
     * @param Stage $stage
     * @return Stage
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Stage $stage)
    {
        return $this->saveEntity($stage);
    }

    /**
     * @param Stage $stage
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Stage $stage)
    {
        return $this->deleteEntity($stage);
    }

    /**
     * @param int $id
     * @return Stage|null
     * @throws EntityNotFoundException
     */
    public function findOne(int $id): ?Stage
    {
        return $this->get($id);
    }


    /**
     * @return Stage[]|array|object[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}