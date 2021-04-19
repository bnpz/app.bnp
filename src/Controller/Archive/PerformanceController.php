<?php
namespace App\Controller\Archive;

use App\Controller\AbstractController;
use App\Entity\Archive\Authorship;
use App\Entity\Archive\Performance;
use App\Entity\Base\EntityInterface;
use App\Form\Archive\PerformanceAuthorshipType;
use App\Form\Archive\PerformanceType;
use App\Service\Archive\AuthorshipService;
use App\Service\Archive\PerformanceService;
use Doctrine\ORM\Query\QueryException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @IsGranted("ROLE_EDITOR", message="Access denied.")
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
     * @IsGranted("ROLE_EDITOR", message="Access denied.")
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

    /**
     * @Route("/{id}/authorships", name="archive_performance_authorship_add", methods={"GET","POST"})
     * @param Request $request
     * @param Performance $performance
     * @param AuthorshipService $authorshipService
     * @return Response
     * @IsGranted("ROLE_EDITOR", message="Access denied.")
     *
     */
    public function authorshipAdd(Request $request, Performance $performance, AuthorshipService $authorshipService): Response
    {
        $authorship = new Authorship();
        $authorship->setPerformance($performance);

        $form = $this->createForm(PerformanceAuthorshipType::class, $authorship);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $authorship = $form->getData();

                $authorshipService->create($authorship);
                # $this->addFlashSuccess('message.success');

                return $this->redirectToRoute('archive_performance_show', ['id' => $performance->getId()]);
            }
        }
        catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }
        return $this->render('archive/authorship/new.html.twig', [
            'authorship' => $authorship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/authorships/{authorshipId}", name="archive_performance_authorship_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Performance $performance
     * @param $authorshipId
     * @param AuthorshipService $authorshipService
     * @return Response
     * @IsGranted("ROLE_EDITOR", message="Access denied.")
     */
    public function authorshipEdit(Request $request, Performance $performance, $authorshipId, AuthorshipService $authorshipService): Response
    {

        try {
            $authorship = $authorshipService->get($authorshipId);
            $form = $this->createForm(PerformanceAuthorshipType::class, $authorship);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $authorship = $form->getData();

                $authorshipService->save($authorship);
                //$this->addFlashSuccess('message.success');

                return $this->redirectToRoute('archive_performance_show', ['id' => $performance->getId()]);

            }

            return $this->render('archive/authorship/edit.html.twig', [
                'authorship' => $authorship,
                'form' => $form->createView(),
            ]);

        }
        catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }
    }

    /**
     * @Route("/{id}/authorships/{authorshipId}", name="archive_performance_authorship_delete", methods={"DELETE"})
     * @param Request $request
     * @param Performance $performance
     * @param $authorshipId
     * @param AuthorshipService $authorshipService
     * @return Response
     * @IsGranted("ROLE_EDITOR", message="Access denied.")
     */
    public function authorshipDelete(Request $request, Performance $performance, $authorshipId, AuthorshipService $authorshipService): Response
    {
        try {
            $authorship = $authorshipService->get($authorshipId);
            if ($this->isCsrfTokenValid('delete'.$authorship->getId(), $request->request->get('_token'))) {
                $authorshipService->delete($authorship);
                //$this->addFlashSuccess('message.success);
            }
        } catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }
        return $this->redirectToRoute('archive_performance_show', ['id' => $performance->getId()]);
    }
}