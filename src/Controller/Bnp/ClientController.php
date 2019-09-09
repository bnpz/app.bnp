<?php

namespace App\Controller\Bnp;


use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller\Bnp
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/client/create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return $this->render("frontend/bnp/client/create.html.twig");
    }
}