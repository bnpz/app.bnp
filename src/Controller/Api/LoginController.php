<?php

namespace App\Controller\Api;

use App\Contract\Service\User\UserServiceInterface;
use App\Controller\AbstractApiController;
use App\Entity\User\User;
use App\Security\LoginFormAuthenticator;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * Class LoginController
 * @package App\Controller\Api
 *
 * @Route("/api/login")
 */
class LoginController extends AbstractApiController
{
    /**
     * @Route("", methods={"POST"}, name="api_login")
     * @param Request $request
     * @param UserServiceInterface $userService
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return JsonResponse
     */
    public function index(
        Request $request,
        UserServiceInterface $userService,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    )
    {
        try{


            if($user = $this->_getAdminUser($request, $userService))
            {
                $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            }

            return $this->jsonResponse("Success");
        }
        catch (Exception $exception){
            return $this->error($exception->getMessage(), $exception->getCode());
        }

    }

    /**
     * @param Request $request
     * @param UserServiceInterface $userService
     * @return User
     * @throws Exception
     */
    private function _getAdminUser(Request $request, UserServiceInterface $userService)
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $user = $userService->findByEmail($email);

        if($user and $userService->isAdmin($user)){
            return $user;
        }
        else{
            throw new Exception("Wrong user or credentials", 401);
        }
    }
}