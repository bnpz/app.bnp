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
 * Class Contact
 * @package App\Entity\General
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="App\Repository\General\ContactRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Contact implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="company", type="string", nullable=true)
     * @Groups({"contact_listing", "contact_full"})
     */
    private $company;

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


}