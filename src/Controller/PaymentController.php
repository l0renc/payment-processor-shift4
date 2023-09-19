<?php

namespace App\Controller;

use http\Client;
use Shift4\Exception\Shift4Exception;
use Shift4\Shift4Gateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
//use App\Service\PaymentManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaymentController extends AbstractController {

    private $paymentManager;

//    public function __construct(PaymentManager $paymentManager) {
//        $this->paymentManager = $paymentManager;
//    }

    public function __construct(
        private HttpClientInterface $client,
    ) {

    }

    #[Route('/test', name: 'test')]
    public function testEndpoint()
    {

//        $client = HttpClient::create([
//            'base_uri' => 'https://dev.shift4.com',
//            'auth_basic' => ['pk_test_z7bbbHGPMp8XLGWbTHI9UAuO', '']
//        ]);
//
//        $response = $client->request('POST', '/charges', [
//            'body' => [
//                'amount' => '499',
//                'currency' => 'USD',
//                'card' => 'tok_NGsyDoJQXop5Pqqi6HizbJTe',
//                'description' => 'Example charge'
//            ]
//        ]);
//
//// To get the response content
//        $content = $response->getContent();
//        dump($content);exit;




        $gateway = new Shift4Gateway('sk_test_z7bbbOSuhGV22hUzCoBdfviT');

        $request = [
            'amount' => 499,
            'currency' => 'EUR',
            'card' => [
                'number' => '4242424242424242',
                'expMonth' => 11,
                'expYear' => 2024
            ]
        ];

        try {
            $charge = $gateway->createCharge($request);

            // do something with charge object - see https://dev.shift4.com/docs/api#charge-object
            $chargeId = $charge->getId();

            dump($chargeId);exit;

        } catch (Shift4Exception $e) {
            // handle error response - see https://dev.shift4.com/docs/api#error-object
            $errorType = $e->getType();
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            dump($errorMessage);exit;
        }

    }


    public function processPayment() {
        $paymentData = [];  // Get this data from your form or request.
        $response = $this->paymentManager->processPayment($paymentData);

        // Handle and return the response.
    }

    public function processRefund() {
        $refundData = [];  // Get this data from your form or request.
        $response = $this->paymentManager->processRefund($refundData);

        // Handle and return the response.
    }
}