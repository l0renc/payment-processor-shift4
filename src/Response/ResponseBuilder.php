<?php

namespace App\Service;

use App\Response\APIResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseBuilder
{
    /**
     * @param mixed $data
     * @param int $status
     * @param string $message
     * @return Response
     */
    public function createDataAPIResponse($data, $status = 200, $message = null)
    {
        $response = new APIResponse();
        $response->setData($data);
        $response->setStatus($status);
        $response->setMessage($message);

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('jms_serializer');

        return new Response($serializer->serialize($response, 'json'), $status, array('Content-Type' => 'application/json'));
    }


    public function createErrorAPIResponse($status, $message, $data = null)
    {
        $response = new APIResponse();
        $response->setSuccess(false);
        $response->setStatus($status);
        $response->setMessage($message);
        $response->setData($data);

        /** @var SerializerInterface $serializer */
        $serializer = $this->get('jms_serializer');

        return new Response($serializer->serialize($response, 'json'), $status, array('Content-Type' => 'application/json'));
    }
}