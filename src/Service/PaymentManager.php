<?php
// src/Service/PaymentManager.php

namespace App\Service;

use App\Contract\PaymentInterface;
use App\PaymentBundle\Entity\Order;

class PaymentManager {

    public function initGateway($merchantAccount)
    {

        $gatewaySettings = $merchantAccount->getGatewaySettings();

        $gateway = $this->container->get($merchantAccount->getGatewayConnector()->getIntegrationService());

        $gateway->init($gatewaySettings);

        if (method_exists($gateway, 'setMerchantAccount')) {
            $gateway->setMerchantAccount($merchantAccount);
        }

        return $gateway;
    }


    /**
     * @param string $orderId
     * @return PaymentResponse
     */
    public function processPayment(string $orderId): PaymentResponse
    {
        $orderRepository = $this->getDoctrine()->getRepository(Order::class);
        $order = $orderRepository->findOneBy(['uniqueIdentifier' => $orderId]);
        $merchantAccount = $order->getMerchantAccount();

        $gateway = $this->initGateway($merchantAccount);
        /** @var PaymentResponse $response */
        $response = $gateway->paymentProcess($order);

        return $response;
    }

    /**
     * @param string $orderId
     * @return PaymentResponse
     */
    public function processRefund(string $orderId): PaymentResponse
    {
        $orderRepository = $this->getDoctrine()->getRepository(Order::class);
        $order = $orderRepository->findOneBy(['uniqueIdentifier' => $orderId]);
        $merchantAccount = $order->getMerchantAccount();

        $gateway = $this->initGateway($merchantAccount);
        /** @var PaymentResponse $response */
        $response = $gateway->processRefund($order);

        return $response;
    }

    public static function buildPaymentResponse($id, $status, $data, $gateway)
    {
        $paymentResponse = new PaymentResponse();
        $paymentResponse->setId($id);
        $paymentResponse->setStatus($status);
        $paymentResponse->setData($data);
        $paymentResponse->setPaymentGateway($gateway);

        return $paymentResponse;
    }
}