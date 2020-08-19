<?php

namespace App\Repository\General;

use App\Entity\General\Event;
use App\Entity\General\Reservation;
use App\Repository\AbstractEntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class EventContactsRepository
 * @package App\Repository\General
 */
class ReservationRepository extends AbstractEntityRepository
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
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getTotalReservedForEvent(Event $event)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('reservation')
            ->from(Reservation::class, 'reservation')
            ->andWhere('reservation.event = :event')
            ->setParameter('event', $event)
            ->select('SUM(reservation.reserved) as totalReserved');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Event $event
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getTotalConfirmedForEvent(Event $event)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('reservation')
            ->from(Reservation::class, 'reservation')
            ->andWhere('reservation.event = :event')
            ->setParameter('event', $event)
            ->select('SUM(reservation.confirmed) as totalConfirmed');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

}