<?php
namespace App\Controller\Archive;

use App\Controller\AbstractController;
use App\Entity\Archive\Performance;
use App\Form\Archive\PerformanceType;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * Class PerformanceController
 * @package App\Controller\Archive
 *
 * @Route("/archive/performances")
 */
class PerformanceController extends AbstractController
{
    /**
     * @Route("/new", name="archive_performance_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $performance = new Performance();
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($performance);
            $entityManager->flush();

            return $this->redirectToRoute('general_event_index');
        }

        return $this->render("archive/performance/new.html.twig", [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }
}