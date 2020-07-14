<?php

namespace App\Controller\Api\Archive;

use App\Contract\Service\Archive\SeasonServiceInterface;
use App\Controller\AbstractApiController;
use App\Entity\Archive\Season;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class SeasonController
 * @package App\Controller\Api\Archive
 *
 * @Route("/api/archive/seasons")
 */
class SeasonController extends AbstractApiController
{
    /**
     * Get all Seasons
     *
     * @Route("", methods={"GET"}, name="api_archive_seasons_index")
     * @SWG\Tag(name="Archive/Season")
     * @SWG\Response(
     *     response=200,
     *     description="Get all Seasons",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Season::class, groups={"archive_season_listing"}))
     *      )
     * )
     * @param Request $request
     * @param SeasonServiceInterface $seasonService
     * @return JsonResponse
     */
    public function index(Request $request, SeasonServiceInterface $seasonService)
    {
        try{

            return $this->jsonResponse($seasonService->findAll(),["archive_season_listing"]);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Create Season
     *
     * @Route("", methods={"POST"}, name="api_archive_seasons_create")
     * @SWG\Tag(name="Archive/Season")
     * @SWG\Response(
     *     response=200,
     *     description="Create Season",
     *     @SWG\Schema(ref=@Model(type=Season::class, groups={"id_view","archive_season_full"}))
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(ref=@Model(type=Season::class, groups={"create"}))
     *)
     * @param Request $request
     * @param SeasonServiceInterface $seasonService
     * @return JsonResponse
     */
    public function create(Request $request, SeasonServiceInterface $seasonService)
    {
        try{
            /**
             * @var Season $season
             */
            $season = $this->getSerializer()->deserialize(
                $request->getContent(),
                Season::class,
                'json'
            );

            return $this->jsonResponse($seasonService->save($season),["archive_season_listing"]);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}