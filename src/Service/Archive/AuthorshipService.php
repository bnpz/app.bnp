<?php
namespace App\Service\Archive;

use App\Entity\Archive\Authorship;
use App\Repository\Archive\AuthorshipRepository;
use App\Service\AbstractEntityService;

/**
 * Class AuthorshipService
 * @package App\Service\Archive
 * @property AuthorshipRepository $repository
 */
class AuthorshipService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Authorship::class;
    }
}