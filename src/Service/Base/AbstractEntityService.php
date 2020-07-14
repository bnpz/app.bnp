<?php


namespace App\Service\Base;

use App\Contract\Service\Base\IDecoratable;
use App\Entity\Base\EntityInterface;
use App\Mixin\CanTranscribe;
use App\Mixin\Decoratable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractEntityService implements IDecoratable
{
    use Decoratable;
    use CanTranscribe;

    /**
     * @var ServiceEntityRepository $repository
     */
    protected $repository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * EntityService constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        $this->repository = $this->managerRegistry->getRepository($this->getEntityClassName());
        $this->entityManager = $this->managerRegistry->getManagerForClass($this->getEntityClassName());
    }

    /**
     * @param $id
     * @return object
     * @throws EntityNotFoundException
     */
    public function get($id)
    {
        $entity = $this->repository->find($id);
        if($entity == null){
            throw new EntityNotFoundException("Entity not found for id: $id");
        }
        else{
            return $entity;
        }
    }

    /**
     * @param EntityInterface $entity
     * @param bool $flush
     * @return EntityInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function saveEntity(EntityInterface $entity, bool $flush = true)
    {
        $this->entityManager->persist($entity);
        if($flush){
            $this->entityManager->flush($entity);
            $this->entityManager->refresh($entity);
        }
        return $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function saveEntityFlushAll(EntityInterface $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->entityManager->refresh($entity);
        return $entity;
    }

    /**
     * @param EntityInterface $entity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function deleteEntity(EntityInterface $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);
        $this->entityManager->detach($entity);
    }

    /**
     * @return string
     */
    abstract protected function getEntityClassName();
}