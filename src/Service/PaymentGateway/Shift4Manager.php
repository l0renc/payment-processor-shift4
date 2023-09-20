<?php

namespace App\Service\PaymentGateway;

use App\Contract\PaymentInterface;
use App\Service\PaymentManager;
use App\Service\PaymentResponse;
use Shift4\Request\ChargeRequest;
use Shift4\Request\RefundRequest;
use Shift4\Response\Charge;
use Shift4\Response\Refund;

class Shift4Manager implements PaymentInterface
{

    private $domain = 'https://api.shift4.com';

    /**
     * @var Shift4Gateway
     */
    private $shift4Gateway;

    private $publicKey;

    private $secretKey;

    public $securePayment;

    public $iFrame;

    private $router;

    private $logAll = false;

    public function init($settings)
    {

        $this->publicKey = $settings['publicKey'];

        $this->secretKey = $settings['secretKey'];

        $this->securePayment = $settings['securePayment'];
        $this->iFrame = $settings['iFrame'];

        $this->router = $this->container->get('router');

        $this->shift4Gateway = new Shift4Gateway($this->secretKey);
    }

    public function processPayment($order) : PaymentResponse
    {

        $chargeRequest = new ChargeRequest();
        //Set all required info from Order object to ChargeRequest
        //Example : $chargeRequest->card = ....

        /** @var Charge $charge */
        $charge = $this->shift4Gateway->createCharge($chargeRequest);

        $paymentResponse = PaymentManager::buildPaymentResponse(
            $charge->getId(),
            $charge->getStatus(),
            $charge->getObject(),
            'Shift4'
        );

        return $paymentResponse;

    }


    public function processRefund($order) : PaymentResponse
    {

        $refundRequest = new RefundRequest();
        //Set all required info from Order object to RefundRequest
        //Example: $refundRequest->chargeId = ....

        /** @var Refund $refund */
        $refund = $this->shift4Gateway->createCharge($refundRequest);

        $paymentResponse = PaymentManager::buildPaymentResponse(
            $refund->getId(),
            $refund->getStatus(),
            $refund->getObject(),
            'Shift4'
        );

        return $paymentResponse;

    }
}