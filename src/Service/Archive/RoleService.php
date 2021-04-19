<?php
namespace App\Service\Archive;

use App\Entity\Archive\Author;
use App\Entity\Archive\Role;
use App\Repository\Archive\RoleRepository;
use App\Service\AbstractEntityService;
use App\Service\User\UserService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class RoleService
 * @package App\Service\Archive
 * @property RoleRepository $repository
 */
class RoleService extends AbstractEntityService
{
    private $translator;
    private $authorService;
    private $userService;

    /**
     * RoleService constructor.
     * @param ManagerRegistry $managerRegistry
     * @param ValidatorInterface $validator
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     * @param AuthorService $authorService
     * @param UserService $userService
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        ValidatorInterface $validator,
        SessionInterface $session,
        TranslatorInterface $translator,
        AuthorService $authorService,
        UserService $userService
    )
    {
        parent::__construct($managerRegistry, $validator, $session);
        $this->translator = $translator;
        $this->authorService = $authorService;
        $this->userService = $userService;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Role::class;
    }

    /**
     * @param $entity
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity)
    {
        /**
         * @var Role $entity
         */
        if(!$entity->getAuthorLabel()){
            $entity->setAuthorLabel($entity->getAuthor()->getFullName());
        }

        return parent::save($entity);
    }

    /**
     * @param Role $role
     * @return mixed
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function create(Role $role)
    {
        $author = $role->getAuthor();
        $authorLabel = $role->getAuthorLabel();
        if(!$author and !trim($authorLabel)){
            throw new Exception($this->translator->trans('error.authorship.author'), 400);
        }
        elseif(!$author instanceof Author){
            # get first and last name from author label
            $authorLabel = str_replace("  ", " ", $authorLabel);
            $array = explode(' ', trim($authorLabel));
            $firstName = trim($array[0]);
            $lastName = trim(str_replace($firstName, "", $authorLabel));

            # get existing or create new author
            $author = $this->authorService->getByFirstAndLastName($firstName, $lastName);
            if(!$author instanceof Author){
                $user = $this->userService->getCurrentUser();
                $author = new Author();
                $author->setFirstName($firstName)->setLastName($lastName);
                $author->setCreatedBy($user)->setUpdatedBy($user);
                $author->setCollectiveMember(false);
                $author = $this->authorService->save($author);
            }
            $role->setAuthor($author);
        }

        return $this->save($role);
    }
}