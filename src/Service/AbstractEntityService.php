<?php

namespace App\Service;

use App\Contract\Service\Base\IDecoratable;
use App\Mixin\CanTranscribe;
use App\Mixin\Decoratable;
use App\Repository\AbstractEntityRepository;
use App\Util\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\QueryException;
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
     * @var AbstractEntityRepository $repository
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
     * @return ServiceEntityRepository
     */
    public function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }

    /**
     * @param $entity
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function save($entity)
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
     * @param $entity
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return true;
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
    public function getAllPaginator($page = 1, $limit = 10, $orderBy = "createdAt", $orderDirection = "DESC")
    {
        $paginator = $this->repository->getAllPaginator($limit, $orderBy, $orderDirection);

        return $paginator->paginate($page);
    }
}