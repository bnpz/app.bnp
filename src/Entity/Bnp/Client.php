<?php

namespace App\Entity\Bnp;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\UuidAbleEntity;
use App\Mixin\CanInitialise;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SaradnjaPrijava
 * @package App\Entity\Bnp
 * @ORM\Table("clients")
 * @ORM\Entity(repositoryClass="App\Repository\Bnp\ClientRepository")
 */
class Client implements EntityInterface
{
    use UuidAbleEntity;
    use CanInitialise;
    use Timestampable;

    /**
     * @var string
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @var string
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $highschool;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $university;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $languages;

    /**
     * @var integer
     * @ORM\Column(
     *     type="smallint",
     *     options={"default":0, "comment":"Porodica bez prihoda"},
     *     nullable=true
     *)
     */
    private $pbp;

    /**
     * @var integer
     * @ORM\Column(
     *     type="smallint",
     *     options={"default":0, "comment":"Clan porodice poginulog borca"},
     *     nullable=true
     *)
     */
    private $cppb;

    /**
     * @var integer
     * @ORM\Column(
     *     type="smallint",
     *     options={"default":0, "comment":"Ratni vojni invalid"},
     *     nullable=true
     *)
     */
    private $rvi;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Client
     */
    public function setName(string $name): Client
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Client
     */
    public function setPhone(string $phone): Client
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Client
     */
    public function setAddress(string $address): Client
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Client
     */
    public function setEmail(string $email): Client
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getHighschool(): ?string
    {
        return $this->highschool;
    }

    /**
     * @param string $highschool
     * @return Client
     */
    public function setHighschool(string $highschool): Client
    {
        $this->highschool = $highschool;
        return $this;
    }

    /**
     * @return string
     */
    public function getUniversity(): ?string
    {
        return $this->university;
    }

    /**
     * @param string $university
     * @return Client
     */
    public function setUniversity(string $university): Client
    {
        $this->university = $university;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Client
     */
    public function setTitle(string $title): Client
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguages(): ?string
    {
        return $this->languages;
    }

    /**
     * @param string $languages
     * @return Client
     */
    public function setLanguages(string $languages): Client
    {
        $this->languages = $languages;
        return $this;
    }

    /**
     * @return int
     */
    public function getPbp(): int
    {
        return $this->pbp;
    }

    /**
     * @param int $pbp
     * @return Client
     */
    public function setPbp(int $pbp): Client
    {
        $this->pbp = $pbp;
        return $this;
    }

    /**
     * @return int
     */
    public function getCppb(): int
    {
        return $this->cppb;
    }

    /**
     * @param int $cppb
     * @return Client
     */
    public function setCppb(int $cppb): Client
    {
        $this->cppb = $cppb;
        return $this;
    }

    /**
     * @return int
     */
    public function getRvi(): int
    {
        return $this->rvi;
    }

    /**
     * @param int $rvi
     * @return Client
     */
    public function setRvi(int $rvi): Client
    {
        $this->rvi = $rvi;
        return $this;
    }

}