<?php

namespace App\Controller\General;

use App\Controller\AbstractController;
use App\Entity\General\Contact;
use App\Form\General\ContactType;
use App\Repository\General\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/general/contact")
 *
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="general_contact_index", methods={"GET"})
     * @param ContactRepository $contactRepository
     * @return Response
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('general/contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
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
     * @Route("/{id}", name="general_contact_show", methods={"GET"})
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

            return $this->redirectToRoute('general_contact_index');
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
}
