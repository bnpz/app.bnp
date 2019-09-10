<?php

namespace App\Controller\Bnp;

use App\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SaradnjaController extends AbstractController
{
    /**
     * @Route("/saradnja", name="app_bnp_saradnja_index")
     */
    public function index()
    {
        return $this->render('frontend/saradnja/index.html.twig');
    }
}
