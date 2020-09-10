<?php
namespace App\Entity\AndroidApp;

use App\Entity\Base\EntityInterface;
use App\Entity\Base\Mixin\BaseEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class Notification
 * @package App\Entity\AndroidApp
 *
 * @ORM\Table(name="android_app_notifications")
 * @ORM\Entity(repositoryClass="App\Repository\AndroidApp\NotificationRepository")
 * @ORM\EntityListeners({"App\EventListener\BaseEntityListener"})
 */
class Notification implements EntityInterface
{
    use BaseEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id_on_bnp_website", type="integer", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="idOnBnpWebsite", type="integer")
     */
    private $idOnBnpWebsite;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="title", type="string")
     */
    private $title;

    /**
     * @ORM\Column(name="body", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="body", type="string")
     */
    private $body;

    /**
     * @ORM\Column(name="topic", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="topic", type="string")
     */
    private $topic;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="url", type="string")
     */
    private $url;

    /**
     * @ORM\Column(name="production", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="production", type="string")
     */
    private $production;

    /**
     * @ORM\Column(name="execution_time", type="datetime", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="executionTime", type="datetime")
     */
    private $executionTime;

    /**
     * @ORM\Column(name="is_sent", type="boolean", nullable=false, options={"default":false})
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="isSent", type="boolean")
     */
    private $isSent;

    /**
     * @ORM\Column(name="firebase_id", type="string", nullable=true)
     * @Groups({"create", "update", "android_app_notification_listing", "android_app_notification_full"})
     * @SWG\Property(property="firebaseId", type="string")
     */
    private $firebaseId;

    /**
     * @return mixed
     */
    public function getIdOnBnpWebsite()
    {
        return $this->idOnBnpWebsite;
    }

    /**
     * @param mixed $idOnBnpWebsite
     * @return Notification
     */
    public function setIdOnBnpWebsite($idOnBnpWebsite)
    {
        $this->idOnBnpWebsite = $idOnBnpWebsite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Notification
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     * @return Notification
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Notification
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @param mixed $production
     * @return Notification
     */
    public function setProduction($production)
    {
        $this->production = $production;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    /**
     * @param mixed $executionTime
     * @return Notification
     */
    public function setExecutionTime($executionTime)
    {
        $this->executionTime = $executionTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsSent()
    {
        return $this->isSent;
    }

    /**
     * @param mixed $isSent
     * @return Notification
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirebaseId()
    {
        return $this->firebaseId;
    }

    /**
     * @param mixed $firebaseId
     * @return Notification
     */
    public function setFirebaseId($firebaseId)
    {
        $this->firebaseId = $firebaseId;
        return $this;
    }

}