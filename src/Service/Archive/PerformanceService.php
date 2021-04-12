<?php
namespace App\Service\Archive;

use App\Entity\Archive\Performance;
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
        return Performance::class;
    }
}