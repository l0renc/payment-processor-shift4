<?php

namespace App\Contract;

interface PaymentInterface {
    public function paymentProcess(array $paymentData): array;
    public function refundProcess(array $refundData): array;
}
