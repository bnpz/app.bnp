<?php
namespace App\Contract\Service\Archive;

use App\Entity\Archive\Season;

/**
 * Interface SeasonServiceInterface
 * @package App\Contract\Service\Archive
 */
interface SeasonServiceInterface
{
    /**
     * @param Season $season
     * @return Season|null
     */
    public function save(Season $season): ?Season;

    /**
     * @param Season $season
     * @return bool
     */
    public function delete(Season $season): bool;

    /**
     * @param int $id
     * @return Season|null
     */
    public function findOne(int $id): ?Season;

    /**
     * @return Season[]
     */
    public function findAll();
}