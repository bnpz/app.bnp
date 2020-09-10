<?php
namespace App\Service\AndroidApp;

use App\Entity\AndroidApp\Notification;
use App\Service\AbstractEntityService;

/**
 * Class NotificationService
 * @package App\Service\AndroidApp
 */
class NotificationService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Notification::class;
    }
}