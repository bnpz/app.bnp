<?php

namespace App\Entity\Base;

/**
 * Interface EntityInterface
 * @package App\Entity\Base
 */
interface EntityInterface
{
    const PAGE_LIMIT = 20;

    public function getId();

    public function getCreatedBy();

    public function setCreatedBy($user);

    public function getUpdatedBy();

    public function setUpdatedBy($user);
}