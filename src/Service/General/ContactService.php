<?php
namespace App\Service\General;

use App\Contract\Service\General\ContactServiceInterface;
use App\Entity\General\Contact;
use App\Repository\General\ContactRepository;
use App\Service\AbstractEntityService;
use phpDocumentor\Reflection\Types\This;

/**
 * Class ContactService
 * @package App\Service\General
 * @property ContactRepository $repository
 */
class ContactService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Contact::class;
    }

    /**
     * @param string $email
     * @return Contact|null
     */
    public function findByEmail($email = ""): ?Contact
    {
        return $this->repository->findOneBy(['email' => trim($email)]);
    }
}