<?php

namespace App\Entity\Archive;

use App\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Stage
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="stages")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\StageRepository")
 */
class Stage extends AbstractEntity
{

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({"archive_stage_listing", "archive_stage_full"})
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Stage
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}