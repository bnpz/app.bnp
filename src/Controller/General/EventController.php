<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\Base\EntityInterface;
use App\Entity\General\Event;
use App\Entity\General\Reservation;
use App\Form\General\EventReservationType;
use App\Form\General\EventType;
use App\Form\General\ReservationType;
use App\Repository\General\EventRepository;
use App\Service\General\EventService;
use App\Service\General\ReservationService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\QueryException;
use Exception;
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

            $paginator = $eventService->getNewPaginator(
                $page,
                1,
                $request->query->get('orderBy', 'time'),
                $request->query->get('orderDirection', 'ASC')
            );

        $paginator->setRouteName('general_event_index_paginated');

        return $this->render('general/event/index.html.twig', [
            'events' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/old", name="general_event_index_old", methods={"GET"}, defaults={"page": "1"})
     * @Route("/old/page/{page<[1-9]\d*>}", methods={"GET"}, name="general_event_index_old_paginated")
     * @param Request $request
     * @param EventService $eventService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function indexOld(
        Request $request,
        EventService $eventService,
        int $page
    ): Response
    {

        $paginator = $eventService->getOldPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            $request->query->get('orderBy', 'time'),
            $request->query->get('orderDirection', 'DESC')
        );

        $paginator->setRouteName('general_event_index_old_paginated');

        return $this->render('general/event/index.html.twig', [
            'events' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }
    /**
     * @Route("/new", name="general_event_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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
     * @param Event $event
     * @return Response
     */
    public function show(Event $event): Response
    {
        return $this->render('general/event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="general_event_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Event $event
     * @return Response
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
     * @param Request $request
     * @param Event $event
     * @return Response
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

    /**
     * @Route("/{id}/reservation", name="general_event_reseravtion", methods={"GET","POST"})
     * @param Request $request
     * @param Event $event
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationAdd(Request $request, Event $event, ReservationService $reservationService): Response
    {

        $reservation = new Reservation();
        $reservation->setEvent($event);

        $form = $this->createForm(EventReservationType::class, $reservation);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();

                $reservationService->save($reservation);
                $this->addFlashSuccess('message.reservation.success');

                return $this->redirectToRoute('general_event_show', ['id' => $event->getId()]);
            }
        }
        catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }
        return $this->render('general/reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/reservation/{reservationId}", name="general_event_reseravtion_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Event $event
     * @param int reservationId
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationEdit(Request $request, Event $event, $reservationId, ReservationService $reservationService): Response
    {

        try {
            $reservation = $reservationService->get($reservationId);
            $form = $this->createForm(EventReservationType::class, $reservation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();

                $reservationService->save($reservation);
                $this->addFlashSuccess('message.reservation.success');

                return $this->redirectToRoute('general_event_show', ['id' => $event->getId()]);

            }

            return $this->render('general/reservation/edit.html.twig', [
                'reservation' => $reservation,
                'form' => $form->createView(),
            ]);

        }
        catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }

    }
    /**
     * @Route("/{id}/reservation/{reservationId}", name="general_event_reseravtion_delete", methods={"DELETE"})
     * @param Request $request
     * @param Event $event
     * @param int reservationId
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationDelete(Request $request, Event $event, $reservationId, ReservationService $reservationService): Response
    {
        try {
            $reservation = $reservationService->get($reservationId);
            if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
                $reservationService->delete($reservation);
                $this->addFlashSuccess('message.reservation.deleted');
            }
        } catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }
        return $this->redirectToRoute('general_event_show', ['id' => $event->getId()]);
    }
}
