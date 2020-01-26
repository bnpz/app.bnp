<?php

namespace App\Entity\Archive;

use App\Entity\AbstractEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Class Play
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="plays")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\PlayRepository")
 */
class Play extends AbstractEntity
{
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Season", inversedBy="plays")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id", nullable=false)
     * @Groups({"archive_play_full"})
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Stage")
     * @ORM\JoinColumn(name="stage_id", referencedColumnName="id", nullable=false)
     * @Groups({"archive_play_full"})
     */
    private $stage;

    /**
     * @ORM\Column(name="title", type="string")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({"archive_play_listing", "archive_play_full"})
     */
    private $title;

    /**
     * @ORM\Column(name="premiere_date", type="date")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({"archive_play_full"})
     */
    private $premiereDate;

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param mixed $season
     * @return Play
     */
    public function setSeason($season)
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param mixed $stage
     * @return Play
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Play
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPremiereDate()
    {
        return $this->premiereDate;
    }

    /**
     * @param mixed $premiereDate
     * @return Play
     */
    public function setPremiereDate($premiereDate)
    {
        $this->premiereDate = $premiereDate;
        return $this;
    }


}