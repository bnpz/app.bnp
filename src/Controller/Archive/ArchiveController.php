<?php

namespace App\Controller\Archive;

use App\Controller\AbstractController;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArchiveController
 * @package App\Controller\Archive
 *
 * @Route("/archive")
 */
class ArchiveController extends AbstractController
{
    /**
     * @Route("", methods={"GET"}, name="archive_index")
     * @return Response
     */
    public function index()
    {
        return $this->render("archive/index.html.twig");
    }
}