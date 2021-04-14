<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Authorship
 * @package App\Entity\Archive
 *
 * @ORM\Table(
 *     name="authorships",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(name="authorship_unique", columns={"performance_id", "authorship_type_id", "author_id"})
 *    }
 * )
 * @UniqueEntity(
 *     fields={"performance", "authorshipType", "author"},
 *     errorPath="author",
 *     message="authorship.typeExists"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Archive\AuthorshipRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Authorship implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Performance", inversedBy="authorships")
     * @ORM\JoinColumn(name="performance_id", referencedColumnName="id")
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="performance", type="integer")
     */
    private $performance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\AuthorshipType")
     * @ORM\JoinColumn(name="authorship_type_id", referencedColumnName="id")
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="authorshipType", type="integer")
     */
    private $authorshipType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Author", inversedBy="authorships")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="author", type="integer")
     */
    private $author;

    /**
     * @ORM\Column(name="authorship_type_label", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="authorshipTypeLabel", type="string")
     */
    private $authorshipTypeLabel;

    /**
     * @ORM\Column(name="author_label", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="authorLabel", type="string")
     */
    private $authorLabel;

    /**
     * @ORM\Column(name="index", type="integer", nullable=true, options={"default":1})
     * @Groups({
     *     "archive_authorship_listing"
     * })
     * @SWG\Property(property="index", type="integer")
     */
    private $index;

    /**
     * @return mixed
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * @param mixed $performance
     * @return Authorship
     */
    public function setPerformance($performance)
    {
        $this->performance = $performance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorshipType()
    {
        return $this->authorshipType;
    }

    /**
     * @param mixed $authorshipType
     * @return Authorship
     */
    public function setAuthorshipType($authorshipType)
    {
        $this->authorshipType = $authorshipType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Authorship
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorshipTypeLabel()
    {
        return $this->authorshipTypeLabel;
    }

    /**
     * @param mixed $authorshipTypeLabel
     * @return Authorship
     */
    public function setAuthorshipTypeLabel($authorshipTypeLabel)
    {
        $this->authorshipTypeLabel = $authorshipTypeLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorLabel()
    {
        return $this->authorLabel;
    }

    /**
     * @param mixed $authorLabel
     * @return Authorship
     */
    public function setAuthorLabel($authorLabel)
    {
        $this->authorLabel = $authorLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     * @return Authorship
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }


}