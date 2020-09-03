<?php
namespace App\Service\General;

use App\Entity\General\EventType;
use App\Repository\General\EventTypeRepository;
use App\Service\AbstractEntityService;

/**
 * Class EventTypeService
 * @package App\Service\General
 * @property EventTypeRepository $repository
 */
class EventTypeService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return EventType::class;
    }

    /**
     * @param $evetTypeName
     * @return EventType|object|null
     */
    public function findByName($evetTypeName)
    {
        return $this->repository->findOneBy(['name' => $evetTypeName]);
    }
}