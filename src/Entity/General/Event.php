<?php
namespace App\Entity\General;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Event
 * @package App\Entity\General
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="App\Repository\General\EventRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Event implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="production", type="string", nullable=true)
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="production", type="string")
     */
    private $production;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="description", type="string")
     */
    private $description;

    /**
     * @ORM\Column(name="time", type="datetime", nullable=false)
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="time", type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(name="premiere", type="boolean", nullable=false, options={"default":false})
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="premiere", type="boolean")
     */
    private $premiere;

    /**
     * @ORM\Column(name="externalProduction", type="boolean", nullable=false, options={"default":false})
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="externalProduction", type="boolean")
     */
    private $externalProduction;

    /**
     * @ORM\Column(name="note", type="text", nullable=true)
     * @Groups({"create", "update", "event_listing", "event_full"})
     * @SWG\Property(property="note", type="string")
     */
    private $note;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\Reservation", mappedBy="event", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $reservations;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param mixed $production
     * @return Event
     */
    public function setProduction($production)
    {
        $this->production = $production;
        return $this;
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
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     * @return Event
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPremiere()
    {
        return $this->premiere;
    }

    /**
     * @param mixed $premiere
     * @return Event
     */
    public function setPremiere($premiere)
    {
        $this->premiere = $premiere;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalProduction()
    {
        return $this->externalProduction;
    }

    /**
     * @param mixed $externalProduction
     * @return Event
     */
    public function setExternalProduction($externalProduction)
    {
        $this->externalProduction = $externalProduction;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     * @return Event
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $eventTime = "";
        if($this->time instanceof DateTime){
            $eventTime = " (".$this->time->format('d.m.Y. H:m').")";
        }
        return $this->name. $eventTime;
    }

    /**
     * @return string
     */
    public function getNameWithDate()
    {
        return $this->__toString();
    }
}