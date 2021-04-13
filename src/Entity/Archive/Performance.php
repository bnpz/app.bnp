<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Performance
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="performances")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\PerformanceRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Performance implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Season", inversedBy="performances")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id", nullable=false)
     * @Groups({
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="season", type="integer")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Stage", inversedBy="performances")
     * @ORM\JoinColumn(name="stage_id", referencedColumnName="id", nullable=false)
     * @Groups({
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="stage", type="integer")
     */
    private $stage;

    /**
     * @ORM\Column(name="stage_label", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="stageLabel", type="string")
     */
    private $stageLabel;

    /**
     * @ORM\Column(name="title", type="string")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({
     *     "archive_performance_listing",
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="title", type="string")
     */
    private $title;

    /**
     * @ORM\Column(name="premiere_date", type="date")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="premiereDate", type="date")
     */
    private $premiereDate;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default":false})
     * @Groups({
     *     "archive_performance_listing",
     *     "archive_performance_full"
     * })
     * @SWG\Property(property="active", type="boolean")
     */
    private $active;

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param mixed $season
     * @return Performance
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
     * @return Performance
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStageLabel()
    {
        return $this->stageLabel;
    }

    /**
     * @param mixed $stageLabel
     * @return Performance
     */
    public function setStageLabel($stageLabel)
    {
        $this->stageLabel = $stageLabel;
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
     * @return Performance
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
     * @return Performance
     */
    public function setPremiereDate($premiereDate)
    {
        $this->premiereDate = $premiereDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return Performance
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }


}