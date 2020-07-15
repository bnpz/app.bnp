<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}