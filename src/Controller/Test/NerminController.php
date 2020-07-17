<?php

namespace App\Controller\Test;

use App\Entity\Test\Nermin;
use App\Form\Test\NerminType;
use App\Repository\Test\NerminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test/nermin")
 */
class NerminController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="test_nermin_index")
     */
    public function index(NerminRepository $nerminRepository): Response
    {
        return $this->render('test/nermin/index.html.twig', [
            'nermins' => $nerminRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="test_nermin_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $nermin = new Nermin();
        $form = $this->createForm(NerminType::class, $nermin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nermin);
            $entityManager->flush();

            return $this->redirectToRoute('test_nermin_index');
        }

        return $this->render('test/nermin/new.html.twig', [
            'nermin' => $nermin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_nermin_show", methods={"GET"})
     */
    public function show(Nermin $nermin): Response
    {
        return $this->render('test/nermin/show.html.twig', [
            'nermin' => $nermin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_nermin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nermin $nermin): Response
    {
        $form = $this->createForm(NerminType::class, $nermin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_nermin_index');
        }

        return $this->render('test/nermin/edit.html.twig', [
            'nermin' => $nermin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_nermin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nermin $nermin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nermin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nermin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_nermin_index');
    }
}
