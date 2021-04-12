<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Performance;
use App\Repository\AbstractEntityRepository;

/**
 * Class PerformanceRepository
 * @package App\Repository\Archive
 */
class PerformanceRepository extends AbstractEntityRepository
{
    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Performance::class;
    }
}