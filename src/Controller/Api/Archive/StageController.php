<?php

namespace App\Controller\Api\Archive;

use App\Contract\Service\Archive\StageServiceInterface;
use App\Controller\AbstractApiController;
use App\Entity\Archive\Stage;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class StageController
 * @package App\Controller\Api
 *
 * @Route("/api/archive/stages")
 */
class StageController extends AbstractApiController
{
    /**
     * Get all Stages
     *
     * @Route("", methods={"GET"}, name="api_archive_stages_index")
     * @SWG\Tag(name="Archive/Stage")
     * @SWG\Response(
     *     response=200,
     *     description="Get all Stages",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Stage::class, groups={"id_view","archive_stage_full"}))
     *      )
     * )
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
     * Create Stage
     *
     * @Route("", methods={"POST"}, name="api_archive_stages_create")
     * @SWG\Tag(name="Archive/Stage")
     * @SWG\Response(
     *     response=200,
     *     description="Create Stage",
     *     @SWG\Schema(ref=@Model(type=Stage::class, groups={"id_view","archive_stage_full"}))
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(ref=@Model(type=Stage::class, groups={"create"}))
     *)
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

    /**
     * Get single Stage
     *
     * @Route("/{id}", methods={"GET"}, name="api_archive_stages_show")
     * @SWG\Tag(name="Archive/Stage")
     * @SWG\Response(
     *     response=200,
     *     description="Get single Stage",
     *     @SWG\Schema(ref=@Model(type=Stage::class, groups={"id_view","archive_stage_full"}))
     * )
     * @param Request $request
     * @param $id
     * @param StageServiceInterface $stageService
     * @return JsonResponse
     */
    public function show(Request $request, $id, StageServiceInterface $stageService)
    {
        try{
            return $this->jsonResponse($stageService->findOne($id),["archive_stage_full"]);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
    /**
     * Update Stage
     *
     * @Route("/{id}", methods={"PUT"}, name="api_archive_stages_update")
     * @SWG\Tag(name="Archive/Stage")
     * @SWG\Response(
     *     response=200,
     *     description="Update Stage",
     *     @SWG\Schema(ref=@Model(type=Stage::class, groups={"id_view","archive_stage_full"}))
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=false,
     *     @SWG\Schema(ref=@Model(type=Stage::class, groups={"update"}))
     *)
     * @param Request $request
     * @param $id
     * @param StageServiceInterface $stageService
     * @return JsonResponse
     */
    public function update(Request $request, $id, StageServiceInterface $stageService)
    {
        try{
            $stage = $stageService->findOne($id);

            $this->getSerializer()->deserialize(
                $request->getContent(),
                Stage::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE  => $stage]
            );

            return $this->jsonResponse(
                $stageService->save($stage),
                ['archive_stage_full']
            );
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}