<?php
namespace App\Entity\Archive;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Season
 * @package App\Entity\Archive
 *
 * @ORM\Table(name="seasons")
 * @ORM\Entity(repositoryClass="App\Repository\Archive\SeasonRepository")
 */
class Season implements EntityInterface
{
    use BaseEntity;

    /**
     * @ORM\Column(name="number", type="integer")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({
     *     "create",
     *     "update",
     *     "archive_season_listing",
     *     "archive_season_full"
     * })
     * @SWG\Property(property="number", type="integer")
     */
    private $number;

    /**
     * @ORM\Column(name="label", type="string")
     * @Assert\NotNull(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     * @Groups({
     *     "create",
     *     "update",
     *     "archive_season_listing",
     *     "archive_season_full"
     * })
     * @SWG\Property(property="label", type="string")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Archive\Play", mappedBy="season")
     * @Groups({"archive_season_full"})
     */
    private $plays;

    /**
     * Season constructor.
     */
    public function __construct()
    {
        $this->plays = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return Season
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return Season
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlays()
    {
        return $this->plays;
    }


}