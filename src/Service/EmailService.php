<?php
namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;

/**
 * Class EmailService
 * @package App\Service
 */
class EmailService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EmailService constructor.
     * @param Swift_Mailer $mailer
     * @param LoggerInterface $logger
     */
    public function __construct(Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param Swift_Message $message
     */
    public function send(Swift_Message $message): void
    {
        try{
            if($this->mailer->send($message, $failedRecipients)){
                $this->logger->info("EMAIL SENT", ['message' => $message, 'failed' => $failedRecipients]);
            }
            else{
                $this->logger->error("EMAIL ERROR", ['message' => $message, 'failed' => $failedRecipients]);
            }
        }
        catch (Exception $exception){
            $this->logger->error("EMAIL EXCEPTION: ".$exception->getMessage(), ['message' => $message]);
        }
    }
}