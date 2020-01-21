<?php

namespace App\Entity\Base\Mixin;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

trait UuidAbleEntity
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Util\Generator\UuidV4Generator")
     * @Groups({"id_view"})
     */
    private $id;


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id."";
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}