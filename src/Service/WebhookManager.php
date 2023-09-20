<?php

namespace App\Service;

use App\Contract\PaymentInterface;
use App\Response\APIResponse;
use App\Service\PaymentGateway\Shift4Manager;
use Symfony\Component\HttpFoundation\Response;

class WebhookManager
{

    protected ResponseBuilder $responseBuilder;

    public function __construct(ResponseBuilder $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param string $message
     * @return APIResponse | Response
     */
    protected function createOKAPIResponse($message = null)
    {
        $response = new APIResponse();
        $response->setStatus(200);
        $response->setMessage($message);

        /** @var SerializerInterface $serializer */
        $serializer = $this->get('jms_serializer');

        return new Response($serializer->serialize($response, 'json'), 200, array('Content-Type' => 'application/json'));
    }


    public function getWebhookResponse($merchantAccount, $content, $statusCode): Response
    {
        $gateway = $merchantAccount->getGateway();

        /** @var PaymentInterface $gatewayManager */
        $gatewayManager = match($gateway) {
            'shift4' => new Shift4Manager(),
            default => null
        };

        if (is_null($gatewayManager)) {
            throw new \InvalidArgumentException("No gateway associated with marchant:". $merchantAccount->getName);
        }

        /** @var Response $response */
        $webhookResponse = $gatewayManager->webhookResponse($merchantAccount->getId(), $content, $statusCode);

        return $webhookResponse;
    }
}