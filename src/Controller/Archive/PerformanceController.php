<?php
namespace App\Controller\Archive;

use App\Controller\AbstractController;
use App\Entity\Archive\Performance;
use App\Entity\Base\EntityInterface;
use App\Form\Archive\PerformanceType;
use App\Service\Archive\PerformanceService;
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
     * @Route("/", name="archive_performance_index", methods={"GET","POST"}, defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET","POST"}, name="archive_performance_index_paginated")
     * @param Request $request
     * @param PerformanceService $performanceService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(Request $request, PerformanceService $performanceService, int $page): Response
    {


        $paginator = $performanceService->getAllPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            $request->query->get('orderBy', 'premiereDate'),
            $request->query->get('orderDirection', 'DESC')

        );

        $paginator->setRouteName('archive_performance_index_paginated');

        return $this->render('archive/performance/index.html.twig', [
            'performances' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

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