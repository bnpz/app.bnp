<?php
namespace App\Service\Archive;

use App\Entity\Archive\Season;
use App\Repository\Archive\PerformanceRepository;
use App\Service\AbstractEntityService;

/**
 * Class PerformanceService
 * @package App\Service\Archive
 * @property PerformanceRepository $repository
 */
class PerformanceService extends AbstractEntityService
{
    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Season::class;
    }
}