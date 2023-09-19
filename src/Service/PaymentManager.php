<?php
// src/Service/PaymentManager.php

namespace App\Service;

use App\Contract\PaymentInterface;

class PaymentManager {

    private PaymentInterface $paymentService;

    public function __construct(PaymentInterface $paymentService) {
        $this->paymentService = $paymentService;
    }


    public function initGateway(MerchantAccount $merchantAccount) {

        $gatewaySettings = $merchantAccount->getGatewaySettings();

        $gateway = $this->container->get($merchantAccount->getGatewayConnector()->getIntegrationService());

        $gateway->init($gatewaySettings);

        if (method_exists($gateway, 'setMerchantAccount')) {
            $gateway->setMerchantAccount($merchantAccount);
        }

        return $gateway;
    }


    public function processPayment(array $paymentData): array {
        return $this->paymentService->paymentProcess($paymentData);
    }

    public function processRefund(array $refundData): array {
        return $this->paymentService->refundProcess($refundData);
    }
}