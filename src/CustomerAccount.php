<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/22/18
 * Time: 9:07 PM
 */

namespace thegoodbyte\orbipay;



class CustomerAccount implements OrbiPayCustomerAccountInterface
{

    private $orbiPayRequest = null;

    public function __construct(OrbiPayRequestInterface $opri)
    {
        $this->orbiPayRequest = $opri;
    }

    public function createCustomerAccount($payload)
    {
        try {


        } catch (Exception $e) {

            $response = ['status' => 'error', 'message' => $e->getMessage()];

        }

        return $response;

    }

    public function getCustomerAccount($customerId)
    {

    }

    public function listCustomerAccounts($customerId)
    {
        //$customerId = '16614027';

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/customeraccounts/lists');

        $this->orbiPayRequest->setMethod('POST');

        $this->orbiPayRequest->setPayload([]);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_FORM_URL_ENCODED);

        $response = $this->orbiPayRequest->callApi2();

        return ($response);
    }








}