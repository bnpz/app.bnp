<?php

namespace App\EventListener;


use App\Contract\Service\User\UserServiceInterface;
use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use App\Entity\User\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * Class BaseEntityListener
 * @package App\EventListener
 */
class BaseEntityListener
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * BaseEntityListener constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param EntityInterface $entity
     * @param LifecycleEventArgs $args
     */
    public function postPersist(EntityInterface $entity, LifecycleEventArgs $args)
    {
        $currentUser = $this->userService->getCurrentUser();
        if(!$entity->getCreatedBy() instanceof User and $currentUser instanceof User){
            $entity->setCreatedBy($currentUser);
        }
    }

    /**
     * @param EntityInterface $entity
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(EntityInterface $entity, LifecycleEventArgs $args)
    {
        $currentUser = $this->userService->getCurrentUser();
        if($currentUser instanceof User){
            $entity->setUpdatedBy($currentUser);
        }
    }
}