<?php

namespace App\Controller\Api\Archive;

use App\Controller\AbstractApiController;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class DebugController
 * @package App\Controller\Api\Archive
 *
 * @Route("/api/archive/debug")
 */
class DebugController extends AbstractApiController
{
    /**
     * @Route("", methods={"GET"}, name="api_archive_debug_index")
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try{

            return $this->jsonResponse(__METHOD__);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}