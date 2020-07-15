<?php

namespace App\Repository\Archive;

use App\Entity\Archive\Play;
use App\Repository\AbstractEntityRepository;

/**
 * Class PlayRepository
 * @package App\Repository\Archive
 */
class PlayRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return Play::class;
    }
}