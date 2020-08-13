<?php

namespace App\Repository\General;

use App\Entity\General\Reservation;
use App\Repository\AbstractEntityRepository;

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
}