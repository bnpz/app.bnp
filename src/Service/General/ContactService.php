<?php
namespace App\Service\General;

use App\Contract\Service\Base\EntityServiceInterface;
use App\Contract\Service\General\ContactServiceInterface;
use App\Entity\Base\EntityInterface;
use App\Entity\General\Contact;
use App\Service\AbstractEntityService;

class ContactService extends AbstractEntityService implements ContactServiceInterface
{

    protected function getEntityClassName()
    {
        return Contact::class;
    }


}