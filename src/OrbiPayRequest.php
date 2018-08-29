<?php

namespace thegoodbyte\orbipay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;




class OrbiPayRequest implements  OrbiPayRequestInterface
{
    //

    const ACCOUNT_SUBTYPE_SAVING = 'savings';
    const ACCOUNT_SUBTYPE_CHECKING = 'checking';
    const ACCOUNT_SUBTYPE_MONEY_MARKET = 'money_market';
    const ACCOUNT_SUBTYPE_CREDIT_VISA = 'visa_credit';
    const ACCOUNT_SUBTYPE_CREDIT_MC = 'mastercard_credit';
    const ACCOUNT_SUBTYPE_CREDIT_AMEX = 'american_express_credit';
    const ACCOUNT_SUBTYPE_CREDIT_DISCOVER = 'discover_credit';
    const ACCOUNT_SUBTYPE_DEBIT_VISA = 'visa_debit';
    const ACCOUNT_SUBTYPE_DEBIT_MC = 'mastercard_debit';
    const ACCOUNT_SUBTYPE_DEBIT_DISCOVER_ = 'discover_debit';


    CONST ACCOUNT_TYPE_BANK = 'bank';
    CONST ACCOUNT_TYPE_CARD_DEBIT = 'debit_card';
    CONST ACCOUNT_TYPE_CARD_CREDIT = 'credit_card';

    const PAYMENT_SETUP_VAR_RECURR = 'variable_recurring_enrollment';
    const PAYMENT_SETUP_AUTO_ENROLL = 'autopay_enrollment';
    const PAYMENT_SETUP_PAYMENT_PLAN = 'payment_plan';


    const PAYMENT_SETUP_PAY_METHOD_ACH                  = 'ach';
    const PAYMENT_SETUP_PAY_METHOD_CHECK                = 'check';
    const PAYMENT_SETUP_PAY_METHOD_DEBIT_VISA           = 'visa_debit';
    const PAYMENT_SETUP_PAY_METHOD_DEBIT_PINLESS        = 'pinless_debit';
    const PAYMENT_SETUP_PAY_METHOD_DEBIT_MC_            = 'master_debit';
    const PAYMENT_SETUP_PAY_METHOD_CREDIT_AMEX_         = 'amex_credit';
    const PAYMENT_SETUP_PAY_METHOD_CREDIT_DISCOVER_     = 'discover_credit';
    const PAYMENT_SETUP_PAY_METHOD_CREDIT_VISA_         = 'visa_credit' ;
    const PAYMENT_SETUP_PAY_METHOD_CREDIT_MASTER        = 'master_credit';
    const PAYMENT_SETUP_PAY_METHOD_CASH                 = 'cash';
    const PAYMENT_SETUP_PAY_METHOD_DEBIT_DISCOVER       = 'discover_debit';


    const PAYMENT_SETUP_SCHEDULE_DAILY          = 'daily';
    const PAYMENT_SETUP_SCHEDULE_WEEKLY         = 'weekly';
    const PAYMENT_SETUP_SCHEDULE_MONTHLY        = 'monthly';
    const PAYMENT_SETUP_SCHEDULE_BIMONTHLY      = 'bi_monthly';
    const PAYMENT_SETUP_SCHEDULE_BIWEEKLY       = 'bi_weekly';
    const PAYMENT_SETUP_SCHEDULE_QUARTERLY      = 'quarterly';
    const PAYMENT_SETUP_SCHEDULE_HALF_YEARLY    = 'half_yearly';
    const PAYMENT_SETUP_SCHEDULE_ANNUAL         = 'annual';


    const ORBIPAY_PRODUCT_PAYMENTS          = 'orbipay_payments';
    const ORBIPAY_REQUESTOR_TYPE_CUSTOMER   = 'customer';
    const ORBIPAY_CHANNEL                   = 'Web Portal';

    const HEADER_CONTENT_TYPE_APPLICATION_FORM_URL_ENCODED = 'application/x-www-form-urlencoded';
    const HEADER_CONTENT_TYPE_APPLICATION_JSON = 'application/json';

    // const URL = 'https://sbapico.billerpayments.com:443/app/opco/v1/service';
    const URL = 'https://sbapi.orbipay.com';
    //  const URL = 'https://sbapi.orbipay.com';

    private $_method = 'GET';
    private $_uri = '/paymnents/v1/payments';
    private $_payload = '';
    private $_headers = [];
    private $_queryString = '';
    private $_input = '';
    private $_signature = '';
    private $_url = '';
    private $_authHeader = '';
    private $_clientKey = '';
    private $_headerConntentType = self::HEADER_CONTENT_TYPE_APPLICATION_JSON;

    public $isMultiPartRequest = false;

    /**
     * @var string
     *
     * header requestor is 'guest' when creating the customer
     * for any other calls that you know the customer ID, use the customer ID as the requestor
     */
    private $_headerRequetor = 'customer';

    private $_debugRequest = [];


    public function __construct($signatureKey = null, $partnerId = null)
    {

        $this->setCredentials($signatureKey, $partnerId);

        //$this->checkCredentials();

        // this header is good for the signature
        // when submitting, do not send accept, content-type and authentication
        // TODO redo this as signature headers
        $this->_headers = [
            'channel'                   => self::ORBIPAY_CHANNEL,
            'product'                   => self::ORBIPAY_PRODUCT_PAYMENTS,
            'timestamp'                 => date('Y-m-d H:i:s') . '.000 -0400',//'03/27/2018 13:16:30:111',
            'idempotent_request_key'    => md5(rand()), // must be different every time
            'requestor'                 => $this->_headerRequetor, //'guest', // hardcoded to guest
            'requestor_type'            => self::ORBIPAY_REQUESTOR_TYPE_CUSTOMER, // Could also user => Client Agent
            'client_key'                => $this->_clientKey

        ];
    }

    public function printCreds()
    {
        print_r([
            $this->_clientKey,
            $this->_password
        ]);
    }

    private function checkCredentials()
    {
        if (empty ($this->_password) || (empty($this->_clientKey))) {
            throw new \Exception('Empty OrbiPay password or client ID');
        }
    }

    public function setCredentials($signatureKey, $partnerId)
    {
        $this->_password =  $signatureKey;//env('UMB_SIGNATURE_KEY');
        $this->_clientKey = $partnerId;// env('UMB_PARTNER_ID');

        //print_r($this->_password);
    }


    /**
     * @param $input
     * @param $password
     * @return string
     *
     *  //Base64(HMAC-SHA256(secret,input))
     *
     */
    private function calculateSignature($input, $password)
    {
        $this->checkCredentials();
        return base64_encode(hash_hmac('sha256', $input, $password, true));
    }


    /**
     * Returns headers in a string, order alphabetically
     *
     * @return string
     */
    public function getSignatureHeaders()
    {
        $this->checkCredentials();
        // override the requestor so it is part of the signature
        // and we do not get the 401
        $this->_headers['requestor'] = $this->_headerRequetor;

        //sort the array
        ksort($this->_headers);
        $string = '';

        foreach ($this->_headers as $key => $value) {
            $string .= $key . '=' . $value . '&';
        }
        // remove the last ampersand
        $string = substr($string, 0, strlen($string) - 1);

        return $string;
    }

    private function getSignatureQueryString()
    {
        $this->checkCredentials();
        return $this->_queryString;
    }

    private function getSignatureInput()
    {
        $this->checkCredentials();
        $input = $this->_method . ':' . $this->_uri . ':' . $this->getSignatureQueryString() . ':' .
            $this->getSignatureHeaders() . ':' . $this->getSignaturePayload();

        return $input;
    }


    /**
     * @return string
     */
    private function getSignaturePayload()
    {
        // send no payload if the request is GET
        if (strtoupper($this->_method) == 'GET') {
            return '';
        }
        return json_encode($this->_payload);
    }



    /**
     * @param string $signature
     * @return string
     */
    private function getAuthHeaderString($signature)
    {
        $this->checkCredentials();
        return 'OPAY1-HMAC-SHA256 Credential=' . $this->_clientKey . ',Signature=' . $signature;
    }


    private function makeGuzzleRequest()
    {
        $this->_url = self::URL . $this->_uri . $this->_queryString;

        $client = new Client(['base_uri' => $this->_url]);

        $headers = $this->buildRequestHeaders();

        $this->_debugRequest = [
            'url'               => $this->_url,
            'payload'           => $this->_payload,
            'input'             => $this->getSignatureInput(),
            'signature'         => $this->_signature,
            'headers'           => $this->_headers,
            'signatureHeaders'  => $this->getSignatureHeaders(),
            'authHeader'        => $this->getAuthHeaderString($this->_signature),
            'allHeaders'        => $headers

        ];


        $response = ['status' => 'success'];
        try {

            $guzzleOptions = [
                'headers' => $headers
            ];

            if ($this->isMultiPartRequest ==true) {
                $guzzleOptions['multipart'] = $this->getMultipartPayload();
            } else {
                $guzzleOptions['body'] = $this->getSignaturePayload();
            }

            $guzzleResponse = $client->request($this->_method, $this->_url, $guzzleOptions);

            $response['data'] = json_decode($guzzleResponse->getBody()->getContents());



        } catch (ClientException $ce) {

            $response['status'] = 'error';

            $response['message'] = 'Call to the OrbiPay API returned an error';

            $errorResponse = json_decode($ce->getResponse()->getBody()->getContents());

            if (isset ($errorResponse->errors[0])) {

                $response['error'] = $errorResponse->errors[0];

            } else {
                $response['error']['message'] = $ce->getMessage();
            }

           // echo __LINE__;
           // dd($this->_debugRequest);

        } catch (Exception $e) {

            $response['status'] = 'error';

            $response['message'] = 'Call to the OrbiPay API returned an error';

            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());

            if (isset ($errorResponse->errors[0])) {
                $response['error'] = $errorResponse->errors[0];
            }
        }

        return $response;


    }

    private function makeGuzzleRequest2()
    {


        $response = ['status' => 'success'];

        $this->_url = self::URL . $this->_uri . $this->_queryString;

        $client = new Client(['base_uri' => $this->_url]);

        $headers = $this->buildRequestHeaders();

        $this->_debugRequest = [
            'url'               => $this->_url,
            'payload'           => $this->_payload,
            'input'             => $this->getSignatureInput(),
            'signature'         => $this->_signature,
            'headers'           => $this->_headers,
            'signatureHeaders'  => $this->getSignatureHeaders(),
            'authHeader'        => $this->getAuthHeaderString($this->_signature),
            'allHeaders'        => $headers

        ];


        try {

            $guzzleOptions = [
                'headers' => $headers
            ];

            if ($this->isMultiPartRequest == true) {
                $guzzleOptions['multipart'] = $this->getMultipartPayload();
            } else {
                $guzzleOptions['body'] = $this->getSignaturePayload();
            }

            $guzzleResponse = $client->request($this->_method, $this->_url, $guzzleOptions);

            $body = ($guzzleResponse->getBody());

            $response['data']  = \GuzzleHttp\json_decode($guzzleResponse->getBody()->getContents());

        } catch (ClientException $ce) {

            $response['status'] = 'error';

            $response['data']   = \GuzzleHttp\json_decode($ce->getResponse()->getBody()->getContents());

        } catch (Exception $e) {
            //echo $e->getMessage();
            $response['status'] = 'error';
            $response['data']   = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
        } finally {

            return $response;
        }




    }

    private function getMultipartPayload()
    {
        //dd($this->_payload);
        $payload =  $this->_payload;
        $payload['contents'] = 'test';
        $payload['name'] = 'test';

        $multipart = [];

        $index = 0;
        foreach ($this->_payload as $key => $value) {
            $multipart[$index]['name']       = $key;
            $multipart[$index]['contents']   = $value;
            $index++;
        }

        return $multipart;
    }


    private function buildSignature()
    {
        $this->_signature = $this->calculateSignature($this->getSignatureInput(), $this->_password);
    }

    /**
     * Takes the signature headers and adds authorization, accept and content-type headers
     *
     * @return array
     */
    private function buildRequestHeaders()
    {
        $this->checkCredentials();

        $this->buildSignature();
        $headers = $this->_headers;

        $headers['Authorization']   = $this->getAuthHeaderString($this->_signature);
        $headers['Accept']          = self::HEADER_CONTENT_TYPE_APPLICATION_JSON;
        $headers['Content-Type']    = $this->_headerConntentType;

        return $headers;
    }


    public function setUri($uri) {
        $this->_uri = $uri;
    }

    public function setMethod($method) {
        $this->_method =  $method;
    }

    public function setPayLoad($payload) {
        $this->_payload = $payload;
    }

    public function setHeaderRequestor($headerRequestor) {
        $this->_headerRequetor = $headerRequestor;
    }

    public function setHeaderContentType($headerContentType)
    {
        $this->_headerConntentType  = $headerContentType;
    }

    public function setQueryString($queryString)
    {
        $this->_queryString = $queryString;
    }


    public function __toString()
    {
        $data = get_class_vars($this);

        return json_encode($data);
    }


    public function callApi($input)
    {

        if (empty($input['uri'])) {
            throw new \Exception('Missing URI input - right here');
        } else {
            $this->setUri($input['uri']);
        }

        if (empty($input['method'])) {
            throw new \Exception('Missing URI input');
        } else {
            $this->_method = $input['method'];
        }

        if (empty($input['headerRequestor'])) {
            throw new \Exception('Missing Header Requestor input');
        } else {
            $this->_headerRequetor = $input['headerRequestor'];
        }

        if (empty($input['headerContentType'])) {
            throw new \Exception('Missing headerContentType');
        } else {
            $this->_headerConntentType  = $input['headerContentType'];
        }

        if (!isset($input['payload'])) {
                throw new \Exception('Missing Payload input');
        } else {
            $this->_payload =  $input['payload'];
        }

        if (isset($input['isMultiPartRequest'])) {


            $this->isMultiPartRequest =  $input['isMultiPartRequest'];
        } else {
            $this->isMultiPartRequest = true;
        }




        $this->makeGuzzleRequest();
    }

    public static function staticMakeRequest($input)
    {

        $clientKey = env('UMB_PARTNER_ID');
        $password = env('UMB_SIGNATURE_KEY');

        $url = self::URL . $input['uri'] . $input['queryString'];

        $client = new Client(['base_uri' => $url]);

        $headers = self::staticGetHeaders($input['headerRequestor'], $clientKey);

        $signatureInput = self::staticGetSignatureInput($headers, $input);

        $signature = self::staticBuildSignature($signatureInput, $password);

        $requestHeaders = self::staticBuildRequestHeaders($input, $signatureInput, $password , $clientKey);



        $debugRequest = [
            'url'               => $url,
            'payload'           => $input['payload'],
            'input'             => $signatureInput,
            'signature'         => $signature,
            'headers'           => $headers,
            'signatureHeaders'  => static::staticGetSignatureHeaders($headers, $input),
            'authHeader'        => self::staticGetAuthHeaderString($signature, $clientKey),
            'allHeaders'        => $requestHeaders,
            'method'            => $input['method']

        ];

//        echo __FILE__ .  ' ' . __LINE__ . '<br />';
//        print_r($debugRequest);

        $response = null;
        try {

            $response = $client->request(
                $input['method'],
                $url, [
                'body' => self::staticGetSignaturePayload($signature, $password),
                'headers' => $headers
            ]);

            $body = ($response->getBody());

            //print_r(json_decode($body->getContents()));

            return json_decode($response->getBody()->getContents());

            // $response =   $this->doCurlPostRequest($this->_url, $headers);
        } catch (ClientException $ce) {

            echo 'Client Exception ' . $ce->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        print_r($debugRequest);
    }


    private static function staticBuildRequestHeaders( $input, $signatureInput, $password, $clientKey)
    {



        $signature = self::staticBuildSignature($signatureInput, $password);
        $headers = self::staticGetHeaders($input['headerRequestor'], $clientKey);

        $headers['Authorization']   = self::staticGetAuthHeaderString($signature, $clientKey);
        $headers['Accept']          = self::HEADER_CONTENT_TYPE_APPLICATION_JSON;
        $headers['Content-Type']    = $input['headerContentType'];

        return $headers;
    }


    public static function staticGetHeaders($headerRequestor, $clientKey)
    {
        $headers = [
            'channel'                   => self::ORBIPAY_CHANNEL,
            'product'                   => self::ORBIPAY_PRODUCT_PAYMENTS,
            'timestamp'                 => date('Y-m-d H:i:s') . '.000 -0400',//'03/27/2018 13:16:30:111',
            'idempotent_request_key'    => md5(rand()), // must be different every time
            'requestor'                 => $headerRequestor, //'guest', // hardcoded to guest
            'requestor_type'            => self::ORBIPAY_REQUESTOR_TYPE_CUSTOMER, // Could also user => Client Agent
            'client_key'                => $clientKey

        ];

        return $headers;
    }

    private static function staticBuildSignature($signatureInput, $password)
    {


        $signature = self::staticCalculateSignature($signatureInput, $password);

        return $signature;
    }

    private static function staticGetAuthHeaderString($signature, $clientKey)
    {

        return 'OPAY1-HMAC-SHA256 Credential=' . $clientKey . ',Signature=' . $signature;
    }

    private static function staticCalculateSignature($input, $password)
    {

        return base64_encode(hash_hmac('sha256', $input, $password, true));
    }

    private static function staticGetSignatureInput($headers, $input)
    {

        $input = $input['method'] . ':' . $input['uri'] . ':' . self::staticGetSignatureQueryString($input) . ':' .
            self::staticGetSignatureHeaders($headers, $input) . ':' . self::staticGetSignaturePayload($input['payload']);

        return $input;
    }

    private static function staticGetSignatureQueryString($input)
    {

        return $input['queryString'];

    }

    private static function staticGetSignatureHeaders($headers, $input)
    {

        // override the requestor so it is part of the signature
        // and we do not get the 401
        $headers['requestor'] = $input['headerRequestor'];

        //sort the array
        ksort($headers);
        $string = '';

        foreach ($headers as $key => $value) {
            $string .= $key . '=' . $value . '&';
        }
        // remove the last ampersand
        $string = substr($string, 0, strlen($string) - 1);

        return $string;
    }


    private static function staticGetSignaturePayload($payload)
    {
        return json_encode(($payload));
    }


    public function callApi2()
    {
        return $this->makeGuzzleRequest();
    }

}

