<?php

namespace App\Service\General;

use App\Entity\General\Event;
use App\Repository\General\EventRepository;
use App\Service\AbstractEntityService;

/**
 * Class EventService
 * @package App\Service\General
 * @property EventRepository $repository
 */
class EventService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Event::class;
    }
}