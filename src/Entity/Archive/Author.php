<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Author
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="authors")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\AuthorRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Author implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="first_name", type="string", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({
     *     "archive_author_listing",
     *     "archive_author_full"
     * })
     * @SWG\Property(property="firstName", type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_author_listing",
     *     "archive_author_full"
     * })
     * @SWG\Property(property="lastName", type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(name="collective_member", type="boolean", nullable=false, options={"default":false})
     * @Groups({
     *     "archive_author_listing",
     *     "archive_author_full"
     * })
     * @SWG\Property(property="collectiveMember", type="boolean")
     */
    private $collectiveMember;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Archive\Authorship", mappedBy="author", orphanRemoval=true)
     * @ORM\OrderBy({"index" = "ASC"})
     */
    private ArrayCollection $authorships;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->authorships = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Author
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Author
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollectiveMember()
    {
        return $this->collectiveMember;
    }

    /**
     * @param mixed $collectiveMember
     * @return Author
     */
    public function setCollectiveMember($collectiveMember)
    {
        $this->collectiveMember = $collectiveMember;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAuthorships(): ArrayCollection
    {
        return $this->authorships;
    }

}