<?php


namespace App\Controller\Customer;

use App\Contract\Service\Customer\CustomerServiceInterface;
use App\Controller\AbstractController;
use App\Entity\Customer\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CustomerController
 * @package App\Controller\Customer
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", methods={"GET"}, name="customers_index")
     * @param CustomerServiceInterface $customerService
     * @return Response
     */
    public function index(CustomerServiceInterface $customerService)
    {
        return $this->render("customers/index.html.twig", ['customers' => $customerService->findAll()]);

    }

    /**
     * @Route("customers/{id}", methods={"GET"})
     * @param string $id
     * @param CustomerServiceInterface $customerService
     * @return Response
     */
    public function show(string $id, CustomerServiceInterface $customerService)
    {
        return $this->render("customers/show.html.twig", ['customer' => $customerService->findById($id)]);
    }

}