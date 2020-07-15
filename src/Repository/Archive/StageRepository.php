<?php

namespace App\Repository\Archive;

use App\Entity\Archive\Stage;
use App\Repository\AbstractEntityRepository;

/**
 * Class StageRepository
 * @package App\Repository\Archive
 */
class StageRepository extends AbstractEntityRepository
{
    public function test()
    {

    }

    protected function getEntityClassName()
    {
        return Stage::class;
    }
}