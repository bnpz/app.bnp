<?php

namespace App\Controller\Admin;


use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/admin/account", name="app_admin_account_index")
     */
    public function index()
    {


        return $this->render('admin/account/index.html.twig');
    }
}