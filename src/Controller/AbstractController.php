<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;

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
}