<?php

namespace App\Util\Generator;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidV5Generator extends AbstractIdGenerator
{
    /**
     * Generate an identifier
     *
     * @param EntityManager $em
     * @param Entity $entity
     * @return UuidInterface
     * @throws Exception
     */
    public function generate(EntityManager $em, $entity)
    {
        return Uuid::uuid5(Uuid::NAMESPACE_DNS, get_class($entity) .
            'FN-3' .
            ':SALTY:4365DFBG GDFnjDFgfdgF54bjh5=)GFDF$§VB6hj56jn56:_' .
            microtime(true));
    }
}