<?php

namespace App\Entity\General;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Contact
 * @package App\Entity\General
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="App\Repository\General\ContactRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 * @UniqueEntity(fields={"email"}, message="contact.email.exists")
 */
class Contact implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="company", type="string", nullable=true)
     * @Groups({"create", "update", "contact_listing", "contact_full"})
     * @SWG\Property(property="company", type="string")
     */
    private $company;

    /**
     * @ORM\Column(name="name", type="string", nullable=true)
     * @Groups({"create", "update", "contact_listing", "contact_full"})
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="email", type="string", unique=true, nullable=true)
     * @Groups({"create", "update", "contact_listing", "contact_full"})
     * @SWG\Property(property="email", type="string")
     */
    private $email;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @Groups({"create", "update", "contact_listing", "contact_full"})
     * @SWG\Property(property="phone", type="string")
     */
    private $phone;

    /**
     * @ORM\Column(name="mobile", type="string", nullable=true)
     * @Groups({"create", "update", "contact_listing", "contact_full"})
     * @SWG\Property(property="mobile", type="string")
     */
    private $mobile;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     * @Groups({"create", "update", "contact_full"})
     * @SWG\Property(property="address", type="string")
     */
    private $address;

    /**
     * @ORM\Column(name="postNumber", type="string", nullable=true)
     * @Groups({"create", "update", "contact_full"})
     * @SWG\Property(property="postNumber", type="string")
     */
    private $postNumber;

    /**
     * @ORM\Column(name="city", type="string", nullable=true)
     * @Groups({"create", "update", "contact_full"})
     * @SWG\Property(property="city", type="string")
     */
    private $city;

    /**
     * @ORM\Column(name="country", type="string", nullable=true)
     * @Groups({"create", "update", "contact_full"})
     * @SWG\Property(property="country", type="string")
     */
    private $country;

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return Contact
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     * @return Contact
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostNumber()
    {
        return $this->postNumber;
    }

    /**
     * @param mixed $postNumber
     * @return Contact
     */
    public function setPostNumber($postNumber)
    {
        $this->postNumber = $postNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Contact
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Contact
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }



}