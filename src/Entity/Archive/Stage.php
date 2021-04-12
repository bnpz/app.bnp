<?php

namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Stage
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="stages")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\StageRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Stage implements EntityInterface
{
    use BaseEntity;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({
     *     "create",
     *     "update",
     *     "archive_stage_listing",
     *     "archive_stage_full"
     * })
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Archive\Performance", mappedBy="stage")
     */
    private $performances;

    /**
     * Stage constructor.
     */
    public function __construct()
    {
        $this->performances = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Stage
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPerformances(): ArrayCollection
    {
        return $this->performances;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}