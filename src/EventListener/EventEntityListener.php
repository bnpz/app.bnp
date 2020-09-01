<?php
namespace App\EventListener;

use App\Entity\General\Event;
use App\Service\General\EventService;
use App\Service\User\UserService;
use DateTime;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

/**
 * Class EventEntityListener
 * @package App\EventListener
 */
class EventEntityListener
{
    const DATE_FORMAT = 'd. m. Y.  H.i';
    private $ignoreFields = ['createdBy', 'updatedBy','createdAt', 'updatedAt'];

    /**
     * @var EventService
     */
    private $eventService;
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $templating;
    /**
     * @var UserService
     */
    private $userService;

    private $adminEmail;
    private $sendToEmails;

    /**
     * EventEntityListener constructor.
     * @param EventService $eventService
     * @param Swift_Mailer $mailer
     * @param Environment $environment
     * @param UserService $userService
     * @param $adminEmail
     */
    public function __construct(
        EventService $eventService,
        Swift_Mailer $mailer,
        Environment $environment,
        UserService $userService,
        $adminEmail
    )
    {
        $this->eventService = $eventService;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
        $this->templating = $environment;
        $this->userService = $userService;
        $this->sendToEmails = $this->userService->getEmailsToNotify();
    }

    /**
     * @param Event $eventEntity
     */
    public function prePersist(Event $eventEntity)
    {
        try{
            $message = (new Swift_Message($eventEntity->getNameWithDate()))
                ->setFrom($this->adminEmail)
                ->setReplyTo($this->adminEmail)
                ->setTo($this->sendToEmails)
                ->setBody(
                    $this->templating->render(
                        'general/event/email/new.html.twig',
                        [
                            'event' => $eventEntity
                        ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
        }
        catch(Exception $exception){

        }
    }

    /**
     * @param Event $eventEntity
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(Event $eventEntity, PreUpdateEventArgs $event)
    {
        $changeSet = $event->getEntityChangeSet();
        $originalTime = $eventEntity->getTime()->format(self::DATE_FORMAT);
        $originalName = $eventEntity->getName();


        $changedFields = [];
        foreach ($changeSet as $fieldName => $values) {
            if(in_array($fieldName, $this->ignoreFields)) continue;

            $oldValue = $values[0];
            $newValue = $values[1];

            if($values[0] instanceof DateTime){
                $oldValue = $values[0]->format(self::DATE_FORMAT);
            }
            if($values[1] instanceof DateTime){
                $newValue = $values[1]->format(self::DATE_FORMAT);
            }

            if($fieldName == 'time'){
                $originalTime = $oldValue;
            }
            if($fieldName == 'name'){
                $originalName = $oldValue;
                $fieldName = 'eventName';
            }
            $data['oldValue'] = $oldValue;
            $data['newValue'] = $newValue;



            $changedFields[$fieldName] = $data;
        }
        $results = [
            'title' => $originalName ." - ". $originalTime,
            'data' => $changedFields,
            'user' => $eventEntity->getUpdatedBy()->getName()
        ];


        try{
            $message = (new Swift_Message($results['title']))
                ->setFrom($this->adminEmail)
                ->setReplyTo($this->adminEmail)
                ->setTo($this->sendToEmails)
                ->setBody(
                    $this->templating->render(
                        'general/event/email/changes.html.twig',
                        [
                            'title' => $results['title'],
                            'data' => $results['data'],
                            'user' => $results['user']
                        ]
                    ),
                    'text/html'
                );

            $mailSent = $this->mailer->send($message);
            if($mailSent){
                dump('success');
            }
            else{
                dump('error');
            }
        }
        catch(Exception $exception){

        }

    }

    /**
     * @param Event $eventEntity
     */
    public function preRemove(Event $eventEntity)
    {
        try{
            $message = (new Swift_Message($eventEntity->getNameWithDate()))
                ->setFrom($this->adminEmail)
                ->setReplyTo($this->adminEmail)
                ->setTo($this->sendToEmails)
                ->setBody(
                    $this->templating->render(
                        'general/event/email/deleted.html.twig',
                        [
                            'event' => $eventEntity
                        ]
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
        }
        catch(Exception $exception){

        }
    }
}