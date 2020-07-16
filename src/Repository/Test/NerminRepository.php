<?php

namespace App\Repository\Test;


use App\Entity\Test\Nermin;
use App\Repository\AbstractEntityRepository;

/**
 * Class NerminRepository
 * @package App\Repository\Test
 */
class NerminRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return Nermin::class;
    }
}