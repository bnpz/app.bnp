<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
    /**
     * @Route("/account")
     */
    public function account(Swift_Mailer $mailer)
    {
        //dump(urlencode('NijeTajPasvord(7)'));
        $message = (new Swift_Message('Hello Email'))
            ->setFrom('bnp.zenica.web@gmail.com')
            ->setReplyTo('info@bnp.zenica')
            ->setTo('nermingk@gmail.com')
            ->setBody("Test msg");
        dump($mailer);

        if($mailer->send($message, $failedRecipients)){
            dump('success');
        }
        else{
            dump('error');
            dump($failedRecipients);
        }

        return $this->render('admin/account.html.twig');
    }

    /**
     * @Route("/docs")
     */
    public function docs()
    {
        return $this->render("admin/docs.html.twig");
    }
}