<?php
namespace App\Repository\General;

use App\Entity\General\Event;
use App\Repository\AbstractEntityRepository;

/**
 * Class EventRepository
 * @package App\Repository\General
 */
class EventRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return Event::class;
    }
}