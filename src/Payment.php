<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/23/18
 * Time: 3:47 PM
 */

namespace thegoodbyte\orbipay;


class Payment implements OrbiPayPaymentInterface
{


    private $orbiPayRequest = null;

    public function __construct(OrbiPayRequestInterface $opri)
    {
        $this->orbiPayRequest = $opri;
    }


    /**
     * @param $customerId
     * @param array $payload
     * @return mixed
     */
    public function chargeAccount($customerId, $payload)
    {
        $customerId = '16614027';

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/payments');

        $this->orbiPayRequest->setMethod('POST');

        $this->orbiPayRequest->setPayload($payload);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }

    /**
     *
     *
     * GET /customers/{ID_CUSTOMER}/payments/{ID_PAYMENT}
     */
    public function getPayment($customerId, $paymentId)
    {

        $this->orbiPayRequest->setHeaderRequestor = $customerId;

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/payments/' . $paymentId);

        $this->orbiPayRequest->setMethod('GET');

        $this->orbiPayRequest->setPayload([]);

        $this->orbiPayRequest->setQueryString('');

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_FORM_URL_ENCODED);//'application/json';

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }

    /**
     * /payments/update
     *
     * PUT /customers/{ID_CUSTOMER}/payments/{ID_PAYMENT}
     *
     * Working : Yes
     */
    public function updatePayment($customerId, $paymentId, $payload)
    {

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/payments/' . $paymentId);

        $this->orbiPayRequest->setMethod('PUT');

        $this->orbiPayRequest->setPayload($payload);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }

    /**
     *
     * /payments/delete
     *
     * DELETE /customers/{ID_CUSTOMER}/payments/{ID_PAYMENT}
     *
     * Working : Yes
     */
    public function deletePayment($customerId, $paymentId)
    {
        $customerId = '16614027';

        $paymentId = '7868145';

        $this->orbiPayRequest->set_uri = '/payments/v1/customers/' . $customerId . '/payments/' . $paymentId;

        $this->orbiPayRequest->set_method = 'DELETE';

        $this->orbiPayRequest->set_headerConntentType = OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON;

        $this->_payload = [
            'comments' => 'some comments'
        ];
        $this->orbiPayRequest->set_headerRequetor = $customerId;

        $response = $this->orbiPayRequest->callApi();

        return $response;
    }

    /**
     * /payments/list
     *
     * Working: no-403
     */
    public function listPayments($customerId, $fundingAccountId)
    {

        $this->orbiPayRequest->setQueryString('?id_customer=' . $customerId . '&id_funding_account=' . $fundingAccountId . '&customer');

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/payments');

        $this->orbiPayRequest->setMethod('GET');

        $this->orbiPayRequest->setPayload = ([]);

        $this->orbiPayRequest->setHeaderContentType (OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }


}