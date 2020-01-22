<?php

namespace App\Controller\Api\Archive;

use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StageController
 * @package App\Controller\Api
 *
 * @Route("/api/archive/stages")
 */
class StageController extends AbstractApiController
{
    /**
     * @Route("", methods={"GET"}, name="api_archive_stages_index")
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->jsonResponse(__METHOD__);
    }
}