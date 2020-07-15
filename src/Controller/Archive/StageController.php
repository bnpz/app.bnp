<?php


namespace App\Controller\Archive;


use App\Controller\AbstractController;
use App\Service\Archive\StageService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StageController
 * @package App\Controller\Archive
 *
 * @Route("/archive/stages")
 */
class StageController extends AbstractController
{

    /**
     * @Route("", methods={"GET"}, name="archive_stages_index")
     * @param StageService $stageService
     * @return Response
     */
    public function index(StageService $stageService)
    {
        try{
            //$stageService->findOne(1);

            return $this->render("archive/stages/index.html.twig");

        }
        catch (Exception $exception){
            $this->addFlashError($exception->getMessage());
            return $this->redirectToRoute('archive_index');
        }

    }
}