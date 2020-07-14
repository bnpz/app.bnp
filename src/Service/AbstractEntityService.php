<?php

namespace App\Service;

use App\Contract\Service\Base\IDecoratable;
use App\Entity\Base\EntityInterface;
use App\Mixin\CanTranscribe;
use App\Mixin\Decoratable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractEntityService
 * @package App\Service
 */
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

    private $validator;

    /**
     * EntityService constructor.
     * @param ManagerRegistry $managerRegistry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $managerRegistry, ValidatorInterface $validator)
    {
        $this->managerRegistry  = $managerRegistry;
        $this->repository       = $this->managerRegistry->getRepository($this->getEntityClassName());
        $this->entityManager    = $this->managerRegistry->getManagerForClass($this->getEntityClassName());
        $this->validator        = $validator;
    }
    /**
     * @return string
     */
    abstract protected function getEntityClassName();

    /**
     * @param $id
     * @return object|null
     * @throws Exception
     */
    public function get($id)
    {
        $entity = $this->repository->find($id);
        if(!$entity){
            $msg = $this->getEntityClassName()." not found for id = ".$id;
            throw new Exception($msg, 404);
        }
        else{
            return $entity;
        }
    }

    /**
     * @param EntityInterface $entity
     * @return object
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function saveEntity(EntityInterface $entity)
    {

        $errors = $this->validator->validate($entity);

        if(count($errors) > 0){
            $errorsString = (string) $errors;
            throw new Exception($errorsString);
        }
        else{
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);
            $this->entityManager->refresh($entity);

            return $entity;
        }

    }

    /**
     * @param EntityInterface $entity
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteEntity(EntityInterface $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface|object
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(EntityInterface $entity)
    {
        return $this->saveEntity($entity);
    }

    public function findOne($id)
    {
        return $this->get($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}