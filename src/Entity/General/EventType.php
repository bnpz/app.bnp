<?php
namespace App\Entity\General;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class EventType
 * @package App\Entity\General
 *
 * @ORM\Table(name="event_types")
 * @ORM\Entity(repositoryClass="App\Repository\General\EventTypeRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class EventType implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Groups({"create", "update", "event_type_listing", "event_type_full"})
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\Event", mappedBy="eventType")
     * @ORM\OrderBy({"time" = "DESC"})
     */
    private $events;

    /**
     * EventType constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * @return EventType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }


}