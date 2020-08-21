<?php
namespace App\Controller;

use App\Service\General\EventService;
use Doctrine\ORM\Query\QueryException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     * @param Request $request
     * @param EventService $eventService
     * @return Response
     * @throws QueryException
     */
    public function index(Request $request, EventService $eventService): Response
    {
        return $this->render('frontend/homepage/index.html.twig', [
            'events' => $eventService->getNewEvents("time", "ASC")
        ]);
    }
}