<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/28/18
 * Time: 11:09 PM
 */

namespace thegoodbyte\orbipay;


class PaymentSetup implements OrbiPayPaymentSetupInterface
{

    public function __construct(OrbiPayRequestInterface $opri)
    {
        $this->orbiPayRequest = $opri;
    }

    public function createPaymentSetup($customerId, $fundingAccountNumberId, $customerAccountId, $payload)
    {

    }

    public function getPaymentSetup($customerId, $paymentSetupId)
    {

    }

    public function deletePaymentSetup( $customerId, $paymentSetupId)
    {

    }

    /**
     *
     * NOT WORKING !!!
     * @param $customerId
     * @return mixed
     */
    public function listPaymentSetups($customerId)
    {

        $this->orbiPayRequest->setMethod('GET');

        $this->orbiPayRequest->setUri('/payments/v1/customers/paymentsetups');

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $response = $this->orbiPayRequest->callApi2();

        return $response;

    }
}