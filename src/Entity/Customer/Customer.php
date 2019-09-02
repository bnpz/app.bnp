<?php


namespace App\Entity\Customer;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\UuidAbleEntity;
use App\Mixin\CanInitialise;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Customer
 * @package App\Entity\Customer
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerRepository")
 */
class Customer implements EntityInterface
{
    use UuidAbleEntity;
    use CanInitialise;
    use Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $phone;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName(string $name): Customer
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
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;
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
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }



}