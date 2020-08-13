<?php

namespace App\Entity\General;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class EventContacts
 * @package App\Entity\General
 *
 * @ORM\Table(
 *     name="reservations",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(name="reservation_unique", columns={"event_id", "contact_id"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\General\ReservationRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Reservation implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\Event", inversedBy="reservations")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({"create", "update", "reservation_full"})
     * @SWG\Property(property="event", type="integer")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\Contact", inversedBy="reservations")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({"create", "update", "reservation_full"})
     * @SWG\Property(property="contact", type="integer")
     */
    private $contact;

    /**
     * @ORM\Column(name="reserved", type="integer", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"create", "update", "reservation_listing", "reservation_full"})
     * @SWG\Property(property="reserved", type="integer")
     */
    private $reserved;

    /**
     * @ORM\Column(name="confirmed", type="integer", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"create", "update", "reservation_listing", "reservation_full"})
     * @SWG\Property(property="confirmed", type="integer")
     */
    private $confirmed;

    /**
     * @ORM\Column(name="note", type="text", nullable=true)
     * @Groups({"create", "update", "reservation_listing", "reservation_full"})
     * @SWG\Property(property="note", type="string")
     */
    private $note;

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return Reservation
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     * @return Reservation
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReserved()
    {
        return $this->reserved;
    }

    /**
     * @param mixed $reserved
     * @return Reservation
     */
    public function setReserved($reserved)
    {
        $this->reserved = $reserved;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param mixed $confirmed
     * @return Reservation
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
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
     * @return Reservation
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

}