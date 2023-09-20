<?php

namespace App\Contract;

use App\Service\PaymentResponse;

interface PaymentInterface {
    public function processPayment($order): PaymentResponse;
    public function processRefund($order): PaymentResponse;
}
