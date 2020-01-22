<?php


namespace App\Controller;

use Doctrine\Common\Annotations\AnnotationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController extends SymfonyAbstractController
{
    const FLASH_TYPE_SUCCESS    = "success";
    const FLASH_TYPE_ERROR      = "error";
    const FLASH_TYPE_NOTICE     = "notice";

    /**
     * @param string $message
     */
    protected function addFlashSuccess(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_SUCCESS, $message);
    }

    /**
     * @param string $message
     */
    protected function addFlashError(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_ERROR, $message);
    }

    /**
     * @param string $message
     */
    protected function addFlashNotice(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_NOTICE, $message);
    }

    /**
     * @return object|Serializer
     */
    public function getSerializer()
    {
        return $this->get('serializer');
    }

}