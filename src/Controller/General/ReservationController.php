<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\Base\EntityInterface;
use App\Entity\General\Reservation;
use App\Form\General\ReservationType;
use App\Repository\General\ReservationRepository;
use App\Service\General\ReservationService;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/general/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="general_reservation_index", methods={"GET"}, defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET"}, name="general_reservation_index_paginated")
     * @param Request $request
     * @param ReservationService $reservationService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(
        Request $request,
        ReservationService $reservationService,
        int $page
    ): Response
    {

        $paginator = $reservationService->getAllPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            $request->query->get('orderBy', 'event'),
            $request->query->get('orderDirection', 'desc')

        );
        $paginator->setRouteName('general_reservation_index_paginated');

        return $this->render('general/reservation/index.html.twig', [
            'reservations' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/new", name="general_reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('general_reservation_index');
        }

        return $this->render('general/reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="general_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('general/reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="general_reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('general_reservation_index');
        }

        return $this->render('general/reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="general_reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('general_reservation_index');
    }
}
