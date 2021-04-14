<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AuthorshipType
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="authorship_types")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\AuthorshipTypeRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 * @UniqueEntity(fields={"abbreviation"}, errorPath="abbreviation", message="authorship.typeExists")
 */
class AuthorshipType implements EntityInterface
{
    use BaseEntity;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({
     *     "archive_authorship_type_listing",
     *     "archive_authorship_type_full"
     * })
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="abbreviation", type="string", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({
     *     "archive_authorship_type_listing",
     *     "archive_authorship_type_full"
     * })
     * @SWG\Property(property="abbreviation", type="string")
     */
    private $abbreviation;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AuthorshipType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param mixed $abbreviation
     * @return AuthorshipType
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}