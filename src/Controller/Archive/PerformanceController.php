<?php
namespace App\Controller\Archive;

use App\Controller\AbstractController;
use App\Entity\Archive\Performance;
use App\Entity\Base\EntityInterface;
use App\Form\Archive\PerformanceType;
use App\Service\Archive\PerformanceService;
use Doctrine\ORM\NonUniqueResultException;
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
        $query = "";
        $searchForm = $request->request->all('form');
        if(isset($searchForm['query'])) {
            $query = $searchForm['query'];

        }
        if(trim($query)){
            $paginator = $performanceService->search(
                $query,
                1,
                100,
                $request->query->get('orderBy', 'title'),
                $request->query->get('orderDirection', 'ASC')
            );
        }
        else{
            $paginator = $performanceService->getAllPaginator(
                $page,
                EntityInterface::PAGE_LIMIT,
                $request->query->get('orderBy', 'premiereDate'),
                $request->query->get('orderDirection', 'DESC')

            );
        }

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

            return $this->redirectToRoute('archive_performance_index');
        }

        return $this->render("archive/performance/new.html.twig", [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[1-9]\d*>}", name="archive_performance_show", methods={"GET"})
     * @param Performance $performance
     * @return Response
     */
    public function show(Performance $performance): Response
    {
        return $this->render('archive/performance/show.html.twig', [
            'performance' => $performance
        ]);

    }
    /**
     * @Route("/{id}/edit", name="archive_performance_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Performance $performance
     * @return Response
     */
    public function edit(Request $request, Performance $performance): Response
    {
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('archive_performance_show', ['id' => $performance->getId()]);
        }

        return $this->render('archive/performance/edit.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

}