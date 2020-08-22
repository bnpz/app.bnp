<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Base\EntityInterface;
use App\Entity\User\User;
use App\Form\Security\RegistrationFormType;
use App\Form\Security\UserEditType;
use App\Form\Security\UserNewPasswordType;
use App\Service\User\UserService;
use Doctrine\ORM\Query\QueryException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminUserController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("", methods={"GET","POST"}, name="admin_user_index", defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET","POST"}, name="admin_user_index_paginated")
     * @param Request $request
     * @param UserService $userService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(Request $request, UserService $userService, int $page)
    {
        $paginator = $userService->getAllPaginator(
            $page,
            EntityInterface::PAGE_LIMIT,
            'name',
            'ASC'
        );
        $paginator->setRouteName('admin_user_index_paginated');

        return $this->render('admin/user/index.html.twig', [
            'users' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            # todo: send email to user


            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/{id<[1-9]\d*>}", name="admin_user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            try{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
            catch (Exception $exception){
                $this->addFlashError('error.user.delete');
                return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
            }
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/{id}/password", name="admin_user_password", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function password(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder) : Response
    {

        $form = $this->createForm(UserNewPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlashSuccess('message.password.changedByAdmin');

            return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/password.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}