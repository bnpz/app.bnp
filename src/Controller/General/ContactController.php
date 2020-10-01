<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\Base\EntityInterface;
use App\Entity\General\Contact;
use App\Entity\General\Reservation;
use App\Form\General\ContactReservationType;
use App\Form\General\ContactType;
use App\Service\General\ContactService;
use App\Service\General\ReservationService;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("/general/contact")
 *
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="general_contact_index", methods={"GET","POST"}, defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET","POST"}, name="general_contact_index_paginated")
     * @param Request $request
     * @param ContactService $contactService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(Request $request, ContactService $contactService, int $page): Response
    {

        $query = "";
        $searchForm = $request->request->all('form');
        if(isset($searchForm['query'])) {
            $query = $searchForm['query'];

        }
        /*elseif ($request->get('query')){
            $query = str_replace("?","", $request->get('query'));
        }*/


        if(trim($query)){
            $paginator = $contactService->search(
                $query,
                1,
                2000,
                $request->query->get('orderBy', 'lastName'),
                $request->query->get('orderDirection', 'ASC')

            );
        }
        else{
            $paginator = $contactService->getAllPaginator(
                $page,
                EntityInterface::PAGE_LIMIT,
                $request->query->get('orderBy', 'lastName'),
                $request->query->get('orderDirection', 'ASC')

            );
        }

        $paginator->setRouteName('general_contact_index_paginated');

        return $this->render('general/contact/index.html.twig', [
            'contacts' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/new", name="general_contact_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('general_contact_index');
        }

        return $this->render('general/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[1-9]\d*>}", name="general_contact_show", methods={"GET"})
     * @param Contact $contact
     * @return Response
     */
    public function show(Contact $contact): Response
    {
        return $this->render('general/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="general_contact_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Contact $contact
     * @return Response
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('general_contact_show', ['id' => $contact->getId()]);
        }

        return $this->render('general/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="general_contact_delete", methods={"DELETE"})
     * @param Request $request
     * @param Contact $contact
     * @return Response
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('general_contact_index');
    }

    /**
     * @Route("/{id}/reservation", name="general_contact_reseravtion", methods={"GET","POST"})
     * @param Request $request
     * @param Contact $contact
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationAdd(Request $request, Contact $contact, ReservationService $reservationService): Response
    {

        $reservation = new Reservation();
        $reservation->setContact($contact);

        $form = $this->createForm(ContactReservationType::class, $reservation);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();

                $reservationService->save($reservation);
                $this->addFlashSuccess('message.reservation.success');

                return $this->redirectToRoute('general_contact_show', ['id' => $contact->getId()]);
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
     * @Route("/{id}/reservation/{reservationId}", name="general_contact_reseravtion_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Contact $contact
     * @param int reservationId
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationEdit(Request $request, Contact $contact, $reservationId, ReservationService $reservationService): Response
    {

        try {
            $reservation = $reservationService->get($reservationId);
            $form = $this->createForm(ContactReservationType::class, $reservation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();

                $reservationService->save($reservation);
                $this->addFlashSuccess('message.reservation.success');

                return $this->redirectToRoute('general_contact_show', ['id' => $contact->getId()]);

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
     * @Route("/{id}/reservation/{reservationId}", name="general_contact_reseravtion_delete", methods={"DELETE"})
     * @param Request $request
     * @param Contact $contact
     * @param int reservationId
     * @param ReservationService $reservationService
     * @return Response
     */
    public function reservationDelete(Request $request, Contact $contact, $reservationId, ReservationService $reservationService): Response
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
        return $this->redirectToRoute('general_contact_show', ['id' => $contact->getId()]);
    }

    /**
     * @Route("/search", name="general_contact_search", methods={"GET"}, defaults={"page": "1"})
     * @Route("/search/page/{page<[1-9]\d*>}", methods={"GET"}, name="general_contact_search_paginated")
     * @param Request $request
     * @param ContactService $contactService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function search(
        Request $request,
        ContactService $contactService,
        int $page
    ): Response
    {

        $paginator = $contactService->getAllPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            $request->query->get('orderBy', 'createdAt'),
            $request->query->get('orderDirection', 'desc')

        );
        $paginator->setRouteName('general_contact_index_paginated');

        return $this->render('general/contact/index.html.twig', [
            'contacts' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }
}
