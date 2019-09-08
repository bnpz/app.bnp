<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_USER")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
    /**
     * @Route("/admin/account")
     */
    public function account()
    {
        return $this->render('admin/account.html.twig');
    }

    /**
     * @Route("/admin/docs")
     * @IsGranted("ROLE_ADMIN")
     */
    public function docs()
    {
        return $this->render("admin/docs.html.twig");
    }
}