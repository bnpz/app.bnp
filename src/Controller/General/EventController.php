<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\Base\EntityInterface;
use App\Entity\General\Event;
use App\Form\General\EventType;
use App\Repository\General\EventRepository;
use App\Service\General\EventService;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/general/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="general_event_index", methods={"GET"}, defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET"}, name="general_event_index_paginated")
     * @param Request $request
     * @param EventService $eventService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(
        Request $request,
        EventService $eventService,
        int $page
    ): Response
    {

        $paginator = $eventService->getAllPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            $request->query->get('orderBy', 'createdAt'),
            $request->query->get('orderDirection', 'desc')

        );
        $paginator->setRouteName('general_event_index_paginated');

        return $this->render('general/event/index.html.twig', [
            'events' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/new", name="general_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('general_event_index');
        }

        return $this->render('general/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="general_event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('general/event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="general_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('general_event_index');
        }

        return $this->render('general/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="general_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('general_event_index');
    }
}
