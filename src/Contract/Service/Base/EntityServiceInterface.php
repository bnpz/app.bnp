<?php

namespace App\Contract\Service\Base;

use App\Entity\Base\EntityInterface;

interface EntityServiceInterface
{
    public function save(EntityInterface $entity);
    public function findOne($id);
    public function findAll();
}