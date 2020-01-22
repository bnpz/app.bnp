<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractApiController extends SymfonyAbstractController
{
    /**
     * @return object|Serializer
     */
    public function getSerializer()
    {
        return $this->get('serializer');
    }

    /**
     * @param $payload
     * @param array $groups
     * @param bool $isError
     * @param array $errors
     * @param int $code
     * @return JsonResponse
     */
    protected function jsonResponse($payload, $groups = [], $isError = false, $errors = [], $code = 200)
    {
        # always show 'id_view' group
        if(!in_array('id_view', $groups)) $groups[] = 'id_view';

        return new JsonResponse($this->getSerializer()->serialize(
            [
                "errors" => $errors,
                "payload" => $payload,
                "code" => $code,
                "isError" => $isError
            ],
            'json',
            ["groups" => $groups]),
            $code,
            [],
            true
        );
    }

    /**
     * @param string $errorMessage
     * @param int $code
     * @return JsonResponse
     */
    protected function error($errorMessage = "", $code = 0)
    {
        if(!$code) $code = 500;
        return $this->jsonResponse(null,[],true,[$errorMessage], $code);
    }
}