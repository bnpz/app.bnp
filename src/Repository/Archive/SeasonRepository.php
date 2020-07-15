<?php

namespace App\Repository\Archive;

use App\Entity\Archive\Season;
use App\Repository\AbstractEntityRepository;

/**
 * Class SeasonRepository
 * @package App\Repository\Archive
 */
class SeasonRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return Season::class;
    }
}