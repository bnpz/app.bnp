<?php

namespace App\Contract\Service\Archive;

use App\Entity\Archive\Stage;

/**
 * Interface StageServiceInterface
 * @package App\Contract\Service\Archive
 */
interface StageServiceInterface
{
    /**
     * @param Stage $stage
     * @return Stage
     */
    public function save(Stage $stage);

    /**
     * @param Stage $stage
     * @return bool
     */
    public function delete(Stage $stage);


    /**
     * @param int $id
     * @return Stage|null
     */
    public function findOne(int $id): ?Stage;

    /**
     * @return Stage[]
     */
    public function findAll();
}