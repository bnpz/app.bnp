<?php
namespace App\Repository\General;

use App\Entity\General\EventType;
use App\Repository\AbstractEntityRepository;

/**
 * Class EventTypeRepository
 * @package App\Repository\General
 */
class EventTypeRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return EventType::class;
    }
}