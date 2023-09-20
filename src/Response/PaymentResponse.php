<?php

namespace App\Service;

class PaymentResponse
{
    public $id;
    public $status;
    public $data;
    public $paymentGateway;

    public function getId() :string
    {
        return $this->id;
    }

    public function setId(string $id) : void
    {
        $this->id = $id;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function setStatus(string $status) : void
    {
        $this->status = $status;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data) : void
    {
        $this->data = $data;
    }

    public function getPaymentGateway() : string
    {
        return $this->paymentGateway;
    }


    public function setPaymentGateway(string $gateway) : void
    {
        $this->paymentGateway = $gateway;
    }

}
