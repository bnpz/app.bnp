<?php

namespace App\Service\General;

use App\Entity\General\Reservation;
use App\Repository\General\ReservationRepository;
use App\Service\AbstractEntityService;

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
}