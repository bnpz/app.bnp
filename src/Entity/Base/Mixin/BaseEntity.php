<?php
namespace App\Entity\Base\Mixin;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Trait BaseEntity
 * @package App\Entity\Base\Mixin
 *
 */
trait BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"id_view"})
     * @SWG\Property(property="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User" )
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     * @Groups({"id_view"})
     * @SWG\Property(property="created_by", type="integer")
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User" )
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     * @Groups({"id_view"})
     * @SWG\Property(property="updated_by", type="integer")
     */
    protected $updatedBy;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param $user
     * @return BaseEntity
     */
    public function setCreatedBy($user)
    {
        $this->createdBy = $user;
        return $this;
    }


    /**
     * @return User|null
     */
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    /**
     * @param $user
     * @return BaseEntity
     */
    public function setUpdatedBy($user)
    {
        $this->updatedBy = $user;
        return $this;
    }


}