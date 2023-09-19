<?php
//
//namespace App\Service\PaymentGateway;
//
//class Shift4Manager
//{
//
//    use ContainerAwareTrait;
//
//    private $domain = 'https://api.shift4.com';
//
//    /**
//     * @var Shift4Gateway
//     */
//    private $shift4Gateway;
//
//    private $publicKey;
//
//    private $secretKey;
//
//    public $securePayment;
//
//    public $iFrame;
//
//    private $router;
//
//    private $logAll = false;
//
//    public function init($settings)
//    {
//
//        $this->publicKey = $settings['publicKey'];
//
//        $this->secretKey = $settings['secretKey'];
//
//        $this->securePayment = $settings['securePayment'];
//        $this->iFrame = $settings['iFrame'];
//
//        $this->router = $this->container->get('router');
//
//        $this->shift4Gateway = new Shift4Gateway($this->secretKey);
//    }
//}