<?php

namespace App\Controller\Admin;

use App\Contract\Service\User\UserServiceInterface;
use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminUserController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("", methods={"GET"}, name="admin_user_index")
     * @return Response
     */
    public function index(UserServiceInterface $userService)
    {
        //$users = $userService->getRepository()->
        return $this->render('admin/user/index.html.twig');
    }

    /**
     * @Route("/create", methods={"GET"}, name="admin_user_create")
     * @return Response
     */
    public function create()
    {
        return $this->render('admin/user/create.html.twig');
    }

    /**
     * @Route("/update", methods={"GET"}, name="admin_user_update")
     * @return Response
     */
    public function update()
    {
        return $this->render('admin/user/update.html.twig');
    }

    /**
     * @Route("/delete", methods={"GET"}, name="admin_user_delete")
     * @return Response
     */
    public function delete()
    {
        return $this->render('admin/user/delete.html.twig');
    }
}