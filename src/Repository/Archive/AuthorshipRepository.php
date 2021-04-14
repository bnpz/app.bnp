<?php
namespace App\Repository\Archive;

use App\Entity\Archive\Authorship;
use App\Repository\AbstractEntityRepository;

/**
 * Class AuthorshipRepository
 * @package App\Repository\Archive
 */
class AuthorshipRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Authorship::class;
    }
}