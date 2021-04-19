<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Role
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\RoleRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Role implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Performance", inversedBy="roles")
     * @ORM\JoinColumn(name="performance_id", referencedColumnName="id")
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="performance", type="integer")
     */
    private $performance;

    /**
     * @ORM\Column(name="name", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="name", type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive\Author", inversedBy="roles")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="author", type="integer")
     */
    private $author;

    /**
     * @ORM\Column(name="author_label", type="string", nullable=true, options={"default":null})
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="authorLabel", type="string")
     */
    private $authorLabel;

    /**
     * @ORM\Column(name="change_in_casting", type="boolean", nullable=true, options={"default":false})
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="active", type="boolean")
     */
    private $changeInCasting;

    /**
     * @ORM\Column(name="position_in_list", type="integer", nullable=true, options={"default":1})
     * @Groups({
     *     "archive_role_listing"
     * })
     * @SWG\Property(property="positionInList", type="integer")
     */
    private $positionInList;

    /**
     * @return Performance|null
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * @param mixed $performance
     * @return Role
     */
    public function setPerformance($performance)
    {
        $this->performance = $performance;
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
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Author|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Role
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
     * @return Role
     */
    public function setAuthorLabel($authorLabel)
    {
        $this->authorLabel = $authorLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChangeInCasting()
    {
        return $this->changeInCasting;
    }

    /**
     * @param mixed $changeInCasting
     * @return Role
     */
    public function setChangeInCasting($changeInCasting)
    {
        $this->changeInCasting = $changeInCasting;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPositionInList()
    {
        return $this->positionInList;
    }

    /**
     * @param mixed $positionInList
     * @return Role
     */
    public function setPositionInList($positionInList)
    {
        $this->positionInList = $positionInList;
        return $this;
    }

}