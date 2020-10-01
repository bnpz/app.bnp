<?php
namespace App\Controller\AndroidApp;

use App\Controller\AbstractController;
use App\Service\AndroidApp\NotificationService;
use http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class NotificationController
 * @package App\Controller\AndroidApp
 *
 * @Route("/androidApp/notification")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/send/{token}", name="android_app_notification_send", methods={"GET","POST"})
     * @param Request $request
     * @param NotificationService $notificationService
     * @return Response
     */
    public function send(Request $request, NotificationService $notificationService)
    {
        $response = new Response();
        try{
            $token = $request->get('token', null);

            if(!$token or $token != $this->getParameter('android.app.controller.token')){
                die("Access denied.");
            }
            $websiteData = $notificationService->getDataFromWebsiteApi();
            print "OK";

        }
        catch (\Exception $exception){
            print $exception->getMessage();
        }

        return $response;

    }

    /**
     * @Route("/", name="android_app_notification_index", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render('android_app/notification/index.html.twig');
    }
}