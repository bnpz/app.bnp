<?php

namespace App\Controller\Api\Archive;

use App\Contract\Service\Archive\StageServiceInterface;
use App\Contract\Service\General\ContactServiceInterface;
use App\Controller\AbstractApiController;
use App\Entity\Archive\Stage;
use App\Entity\General\Contact;
use App\Service\Archive\StageService;
use App\Service\General\ContactService;
use App\Service\User\UserService;
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
     * @param UserService $userService
     * @param ContactService $contactService
     * @return JsonResponse
     */
    public function index(Request $request, UserService $userService, ContactService $contactService)
    {
        try{

            $user = $userService->getCurrentUser();

            $contact = new Contact();
            $contact->setCompany("ABC");

            $newContact = $contactService->save($contact);

            return $this->jsonResponse($newContact);
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}