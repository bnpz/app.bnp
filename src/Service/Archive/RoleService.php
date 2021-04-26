<?php
namespace App\Service\Archive;

use App\Entity\Archive\Author;
use App\Entity\Archive\Role;
use App\Repository\Archive\RoleRepository;
use App\Service\AbstractEntityService;
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

    /**
     * RoleService constructor.
     * @param ManagerRegistry $managerRegistry
     * @param ValidatorInterface $validator
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     * @param AuthorService $authorService
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        ValidatorInterface $validator,
        SessionInterface $session,
        TranslatorInterface $translator,
        AuthorService $authorService
    )
    {
        parent::__construct($managerRegistry, $validator, $session);
        $this->translator = $translator;
        $this->authorService = $authorService;
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
            $author = $this->authorService->getOrCreateFromLabel($authorLabel);
            $role->setAuthor($author);
        }

        return $this->save($role);
    }
}