<?php
namespace App\Entity\Base\Mixin;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}