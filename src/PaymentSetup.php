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

        $this->orbiPayRequest->setMethod('POST');

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/paymentsetups');

        $this->orbiPayRequest->setHeaderContentType (OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setPayload($payload);

        $response = $this->orbiPayRequest->callApi2();

        dd($response);
    }


    /**
     * @param $customerId
     * @param $paymentSetupId
     * @return mixed
     */
    public function getPaymentSetup($customerId, $paymentSetupId = '')
    {

        $this->orbiPayRequest->setMethod('GET');

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/paymentsetups/' . $paymentSetupId);

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $response = $this->orbiPayRequest->callApi2();

        return $response;

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