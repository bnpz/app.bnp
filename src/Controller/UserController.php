<?php


namespace App\Controller;

use App\Form\Security\UserNewPasswordType;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}/password", name="user_password", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param UserService $userService
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function password(Request $request, User $user, UserService $userService, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $this->_checkUser($user, $userService);

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

            $this->addFlashSuccess('message.password.changed');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/password.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @param UserService $userService
     */
    public function _checkUser(User $user, UserService $userService)
    {
        $currentUser = $userService->getCurrentUser();
        if($user->getId() != $currentUser->getId()){
            die('Access denied.');
        }
    }
}