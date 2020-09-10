<?php
namespace App\Repository\AndroidApp;

use App\Entity\AndroidApp\Notification;
use App\Repository\AbstractEntityRepository;

/**
 * Class NotificationRepository
 * @package App\Repository\AndroidApp
 */
class NotificationRepository extends AbstractEntityRepository
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Notification::class;
    }
}