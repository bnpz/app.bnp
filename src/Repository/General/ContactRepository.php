<?php

namespace App\Repository\General;

use App\Entity\General\Contact;
use App\Repository\AbstractEntityRepository;

/**
 * Class ContactRepository
 * @package App\Repository\General
 */
class ContactRepository extends AbstractEntityRepository
{

    protected function getEntityClassName()
    {
        return Contact::class;
    }

    public function testContactRepo()
    {

    }
}