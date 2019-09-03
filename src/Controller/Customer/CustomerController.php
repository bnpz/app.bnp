<?php


namespace App\Controller\Customer;

use App\Contract\Service\Customer\CustomerServiceInterface;
use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CustomerController
 * @package App\Controller\Customer
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", methods={"GET"})
     * @param CustomerServiceInterface $customerService
     * @return Response
     */
    public function index(CustomerServiceInterface $customerService)
    {
        return $this->render("frontend/customers/index.html.twig", ['customers' => $customerService->findAll()]);

    }

    /**
     * @Route("customers/{id}", methods={"GET"})
     * @param string $id
     * @param CustomerServiceInterface $customerService
     * @return Response
     */
    public function show(string $id, CustomerServiceInterface $customerService)
    {
        return $this->render("frontend/customers/show.html.twig", ['customer' => $customerService->findById($id)]);
    }

}