<?php

namespace App\Contract;

use App\Service\PaymentResponse;
use Symfony\Component\HttpFoundation\Response;

interface PaymentInterface {
    public function processPayment($order): PaymentResponse;
    public function processRefund($order): PaymentResponse;
    public function webhookResponse($midReference, $content, $statusCode): Response;
}
