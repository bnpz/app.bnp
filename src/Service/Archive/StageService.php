<?php
namespace App\Service\Archive;

use App\Entity\Archive\Stage;
use App\Repository\Archive\StageRepository;
use App\Service\AbstractEntityService;


/**
 * Class StageService
 * @package App\Service\Archive
 * @property StageRepository $repository
 */
class StageService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Stage::class;
    }

}