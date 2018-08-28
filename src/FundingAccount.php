<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/23/18
 * Time: 3:47 PM
 */

namespace thegoodbyte\orbipay;

use thegoodbyte\orbipay\OrbiPayFundingAccountInterface;
use thegoodbyte\orbipay\OrbiPayRequestInterface;


class FundingAccount implements OrbiPayFundingAccountInterface
{

    CONST ACCOUNT_TYPE_BANK = 'bank';
    CONST ACCOUNT_TYPE_CARD_DEBIT = 'debit_card';
    CONST ACCOUNT_TYPE_CARD_CREDIT = 'credit_card';

    private $orbiPayRequest = null;

    public function __construct(OrbiPayRequestInterface $opri)
    {
        $this->orbiPayRequest = $opri;
    }

    /**
     * @param \thegoodbyte\orbipay\OrbiPayRequestInterface $or
     * @param $customerId
     *
     * //POST /customers/{ID_CUSTOMER}/fundingaccounts/lists
     */
    public function listCustomerAccounts($customerId)
    {


        $input['uri'] = '/payments/v1/customers/' . $customerId . '/fundingaccounts/lists';

        $input['method'] = 'POST';

        $input['headerRequestor'] = $customerId;

        $input['headerContentType'] = OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_FORM_URL_ENCODED;

        $input['payload'] = '';

        $input['isMultiPartRequest'] = true;

        $input['queryString'] = '';



        //$response = $this->orbiPayReqeust->callApi($input);
        $response = OrbiPayRequest::staticMakeRequest($input);

        return $response;

    }

    public function getCustomerAccount($customerId, $fundingAccountNumberId)
    {

        $this->orbiPayRequest->setUri ('/payments/v1/customers/' . $customerId . '/fundingaccounts/' . $fundingAccountNumberId);

        $this->orbiPayRequest->setMethod ('GET');

        $this->orbiPayRequest->setHeaderRequestor ($customerId);

        $this->orbiPayRequest->setHeaderContentType (OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setPayload([]);

        $this->orbiPayRequest->setQueryString ('');

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }


    /**
     * @param $customerId
     * @param $payload
     * @return mixed
     *
     * Creates the funding account for the customer
     *
     * Sample payload:
     *
     * $payload = [

                    "account_holder_name" => "Martin Halla",
                    "nickname" => "my CC",
                    "address" => [
                        'address_line1' => '123 Main street',
                        'address_city' => 'Warren',
                        'address_state' => 'NJ',
                        'address_country' => 'USA',
                        'address_zip1' => '07059',
                    ],
                    'account_type' => self::ACCOUNT_TYPE_CARD_CREDIT,
                    "account_number" => "4159282222222221",
                    "expiry_date" => "02/20",
                    "card_cvv_number" => "123",
                    "comments" => "string"

                    ];
     */
    public function createCreditCardAccount($customerId, $payload)
    {

        $this->checkCreateAccountPayload($payload);

        $payload['account_type'] = self::ACCOUNT_TYPE_CARD_CREDIT;

        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/fundingaccounts');

        $this->orbiPayRequest->setMethod('POST');

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setPayload ($payload);

        $response  = $this->orbiPayRequest->callApi2();

        return $response;

    }


    /**
     * @param $payload
     *
     * Sampe Pyalod:
     *  $payload = [
                    "account_holder_name" => "Martin Halla",
                    "nickname" => "my CC",
                    "address" => [
                        'address_line1' => '123 Main street',
                        //  'address_line2' => '',
                        'address_city' => 'Warren',
                        'address_state' => 'NJ',
                        'address_country' => 'USA',
                        'address_zip1' => '07059',
                        //'address_zip2' => '',
                    ],
                    'account_type' => self::ACCOUNT_TYPE_CARD_CREDIT,
                    "account_number" => "4159282222222221",
                    // "aba_routing_number"    =>  "123456789",
                    "expiry_date" => "02/20",
                    // "account_holder_type"   =>  "personal",
                    // "custom_fields"         =>  [],
                    // "account_subtype"       =>  "savings",
                    "card_cvv_number" => "123",
                    "comments" => "string"
                    ];
     */
    private function checkCreateAccountPayload($payload)
    {

        $requiredFields = [
            'account_holder_name', 'nickname', 'address', 'account_number',
            'expiry_date', 'card_cvv_number', 'comments'
        ];

        $requiredFieldsAddress = [
            'address_line1', 'address_city', 'address_state', 'address_country',
            'address_zip1'
        ];


        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                throw new \Exception("Payload field '$field' is empty or missing");
            }
        }

        foreach ($requiredFieldsAddress as $field) {
            if (empty($payload['address'])) {
                throw new \Exception("Payload field 'address.$field' is empty or missing");
            }
        }


    }


    /**
     * Creates checking account
     *
     * @param $customerId
     * @param $payload
     * @return mixed
     */
    public function createCheckingAccount($customerId, $payload)
    {

        $this->checkCreateCheckingAccountPayload($payload);

        $uri = '/payments/v1/customers/' . $customerId . '/fundingaccounts';

        $this->orbiPayRequest->setUri($uri);

        $this->orbiPayRequest->setMethod('POST');

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType (OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setPayload($payload);

        return $this->orbiPayRequest->callApi2();

    }


    /**
     *
     * Checks the neccessary paylod field for Checking account creation
     *
     * @param $payload
     * @throws \Exception
     */
    private function checkCreateCheckingAccountPayload($payload)
    {

        $requiredFields = [
            'account_holder_name', 'nickname', 'address', 'account_number',
            'comments'
        ];

        $requiredFieldsAddress = [
            'address_line1', 'address_city', 'address_state', 'address_country',
            'address_zip1'
        ];


        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                throw new \Exception("Payload field '$field' is empty or missing");
            }
        }

        foreach ($requiredFieldsAddress as $field) {
            if (empty($payload['address'])) {
                throw new \Exception("Payload field 'address.$field' is empty or missing");
            }
        }


    }


    /**
     * @param $customerId
     * @param $fundingAccountId
     * @return mixed
     */
    public function deleteCustomerAccount($customerId, $fundingAccountId){



        $this->orbiPayRequest->setUri('/payments/v1/customers/' . $customerId . '/fundingaccounts/' . $fundingAccountId);

        $this->orbiPayRequest->setMethod('DELETE');

        $this->orbiPayRequest->setHeaderRequestor($customerId);

        $this->orbiPayRequest->setHeaderContentType (OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

        $this->orbiPayRequest->setPayload ([

            "comments" => "No more needed"

        ]);


        return $this->orbiPayRequest->callApi2();
    }

}