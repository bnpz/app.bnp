<?php

namespace App\Controller\Api\Archive;

use App\Contract\Service\Archive\StageServiceInterface;
use App\Controller\AbstractApiController;
use App\Entity\Archive\Stage;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

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
     * @param StageServiceInterface $stageService
     * @return JsonResponse
     */
    public function index(Request $request, StageServiceInterface $stageService)
    {
        try{

            return $this->jsonResponse($stageService->findAll(),["archive_stage_full"]);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @Route("", methods={"POST"}, name="api_archive_stages_create")
     * @param Request $request
     * @param StageServiceInterface $stageService
     * @return JsonResponse
     */
    public function create(Request $request, StageServiceInterface $stageService)
    {
        try{
            /**
             * @var Stage $stage
             */
            $stage = $this->getSerializer()->deserialize(
                 $request->getContent(),
                 Stage::class,
                 'json'
             );

            return $this->jsonResponse($stageService->save($stage),["archive_stage_full"]);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}