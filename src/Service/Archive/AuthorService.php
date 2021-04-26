<?php
namespace App\Service\Archive;

use App\Entity\Archive\Author;
use App\Repository\Archive\AuthorRepository;
use App\Service\AbstractEntityService;
use App\Service\User\UserService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AuthorService
 * @package App\Service\Archive
 * @property AuthorRepository $repository
 */
class AuthorService extends AbstractEntityService
{

    private $userService;

    /**
     * AuthorService constructor.
     * @param ManagerRegistry $managerRegistry
     * @param ValidatorInterface $validator
     * @param SessionInterface $session
     * @param UserService $userService
     */
    public function __construct(ManagerRegistry $managerRegistry, ValidatorInterface $validator, SessionInterface $session, UserService $userService)
    {
        parent::__construct($managerRegistry, $validator, $session);
        $this->userService = $userService;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Author::class;
    }

    /**
     * @param null $firstName
     * @param null $lastName
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getByFirstAndLastName($firstName = null, $lastName = null)
    {
        return $this->repository->getByFirstAndLastName($firstName, $lastName);
    }

    /**
     * @param string $authorLabel
     * @return Author
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getOrCreateFromLabel($authorLabel = "")
    {
        # get first and last name from author label
        $authorLabel = str_replace("  ", " ", $authorLabel);
        $array = explode(' ', trim($authorLabel));
        $firstName = trim($array[0]);
        $lastName = trim(str_replace($firstName, "", $authorLabel));

        # get existing or create new author
        $author = $this->getByFirstAndLastName($firstName, $lastName);
        if(!$author instanceof Author) {
            $user = $this->userService->getCurrentUser();
            $author = new Author();
            $author->setFirstName($firstName)->setLastName($lastName);
            $author->setCreatedBy($user)->setUpdatedBy($user);
            $author->setCollectiveMember(false);
            $author = $this->save($author);
        }
        return $author;
    }
}