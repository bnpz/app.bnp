<?php

namespace App\Service\General;

use App\Entity\General\Event;
use App\Entity\General\Reservation;
use App\Repository\General\ReservationRepository;
use App\Service\AbstractEntityService;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class EventContactsService
 * @package App\Service\General
 * @property ReservationRepository $repository
 */
class ReservationService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Reservation::class;
    }


    /**
     * @param Event $event
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getTotalReservedForEvent(Event $event)
    {
        $result = $this->repository->getTotalReservedForEvent($event);
        return intval($result['totalReserved']);
    }

    /**
     * @param Event $event
     * @return int
     * @throws NonUniqueResultException
     */
    public function getTotalConfirmedForEvent(Event $event)
    {
        $result = $this->repository->getTotalConfirmedForEvent($event);
        return intval($result['totalConfirmed']);
    }
}