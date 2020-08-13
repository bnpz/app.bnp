<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\General\Reservation;
use App\Form\General\ReservationType;
use App\Repository\General\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/general/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="general_reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('general/reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
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
