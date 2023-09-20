<?php

namespace App\Controller;

use App\Response\APIResponse;
use App\Service\WebhookManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookController
{

    public function postOrderEventAction(Request $request, $midUniqueIdReference, WebhookManager $webhookManager) : Response
    {
        // InboundWebhook Creation
        $inbound = $this->createInboundWebhook($request);
        // MerchantAccount
        $merchantAccount = $this->getRepo(MerchantAccount::class)->findOneBy(['uniqueIdToken' => $midUniqueIdReference]);

        // Return the right webhookResponse
        /** @var Response $webhookResponse */
        $webhookResponse = $webhookManager->getWebhookResponse(
            $merchantAccount,
            $inbound->getResponseContent(),
            $inbound->getResponseHttpCode()
        );

        return $webhookResponse;
    }

}