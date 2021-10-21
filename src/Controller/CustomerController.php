<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
      $this->customerRepository = $customerRepository;  
    }
    /**
     * @Route("/customer/{id}", name="get_one_customer", methods={"GET"})
     */
    public function getOneCustomer($id): JsonResponse
    {
        $customer = $this->customerRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $customer->getId(),
            'firsName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'email' => $customer->getEmail(),
            'phoneNumber' => $customer->getPhoneNumber()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/customer/{id}", name="update_customer", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $customer = $this->customerRepository->findOneBy(['id' => $id]);

        $updateCustomer = $this->customerRepository->updateCustomer($customer,$request);

        return new JsonResponse($updateCustomer->toArray() , Response::HTTP_OK);
    }
    /**
     * @Route("/add_customer", name="add_customer", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $email = $request->request->get('email');
        $phoneNumber = $request->request->get('phoneNumber');

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber)){
            throw new NotFoundHttpException('Mandatory values please !');
        }

        $this->customerRepository->saveCustomer($firstName,$lastName,$email,$phoneNumber);

        return new JsonResponse(['status'=> 'Add Customer OK!'],Response::HTTP_CREATED);
    }

    /**
     * @Route("/customers", name="customers")
     */
    public function index(): JsonResponse
    {
        $customers = $this->customerRepository->findAll();
        $data = [];

        foreach($customers as $customer){
            $data[] = [
                'id' => $customer->getId(),
                'firsName' => $customer->getFirstName(),
                'lastName' => $customer->getLastName(),
                'email' => $customer->getEmail(),
                'phoneNumber' => $customer->getPhoneNumber()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
