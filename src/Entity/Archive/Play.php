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
     * @Groups({"archive_play_listing", "archive_play_full"})
     */
    private $premiereDate;

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