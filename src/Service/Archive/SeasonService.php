<?php

namespace App\Service\Archive;

use App\Entity\Archive\Season;
use App\Repository\Archive\SeasonRepository;
use App\Service\AbstractEntityService;

/**
 * Class SeasonService
 * @package App\Service\Archive
 * @property SeasonRepository $repository
 */
class SeasonService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Season::class;
    }


}