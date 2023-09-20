<?php

namespace App\Controller;

use App\Service\PaymentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController {

    #[Route('/payments/{orderId}', methods: ['POST'])]
    public function processPayment(PaymentManager $paymentManager, $orderId) {

        try {
            $response = $paymentManager->processPayment($orderId);
        } catch (Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response($response->getData(), $response->getStatus());
    }

    #[Route('/payments/{orderId}/refund', methods: ['POST'])]
    public function processRefund(PaymentManager $paymentManager, $orderId) {

        try {
            $response = $paymentManager->processRefund($orderId);
        } catch (Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response($response->getData(), $response->getStatus());
    }
}