<?php

namespace App\Controller;

use App\Service\PaymentManager;
use App\Service\PaymentResponse;
use App\Service\ResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController {

    protected ResponseBuilder $responseBuilder;

    public function __construct(ResponseBuilder $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    #[Route('/payments/{orderId}', methods: ['POST'])]
    public function processPayment(PaymentManager $paymentManager, $orderId) {

        try {
            /** @var PaymentResponse $response */
            $response = $paymentManager->processPayment($orderId);
        } catch (Exception $exception){
            return $this->responseBuilder->createErrorAPIResponse(
                Response::HTTP_BAD_REQUEST,
                $exception->getMessage(),
                $response->getData() ?? null

            );
        }

        return $this->responseBuilder->createDataAPIResponse(
            $response->getData(),
            $response->getStatus()
        );
    }

    #[Route('/payments/{orderId}/refund', methods: ['POST'])]
    public function processRefund(PaymentManager $paymentManager, $orderId) {

        try {
            /** @var PaymentResponse $response */
            $response = $paymentManager->processRefund($orderId);
        } catch (Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response($response->getData(), $response->getStatus());
    }
}