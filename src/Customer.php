<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/22/18
 * Time: 9:07 PM
 */

namespace thegoodbyte\orbipay;

use Dompdf\Exception;
use thegoodbyte\orbipay\OrbiPayRequest;
use thegoodbyte\orbipay\OrbiPayCustomerInterface;
use thegoodbyte\orbipay\OrbiPayRequestInterface;




class Customer implements OrbiPayCustomerInterface
{

    private $orbiPayRequest = null;

    /**
     * IF the values are empty  - do not sent to the service
     */
    /**
     * @var string = null
     */
    private $comments           = null;
    // 'customer_reference'    => '',

    /**
     * @var string null
     */
    private $first_name         = null;

    /**
     * @var string = null
     */
    private $last_name          = null;
    //  'middle_name'           => '',

    /**
     * @var string = null
     *
     * Male or Female
     */
    private $gender             = null;

    /**
     * @var string = null
     *
     * Format : YYYY-mm-dd
     */
    private $date_of_birth      = null;

    /**
     * @var string = null
     *
     * no hyphens
     */
    private $ssn                = null;
    //'locale'                => '',

    /**
     * @var string = null
     */
    private $email              = null;  //               => 'martin@hawthorne-advisors.com',
    // 'home_phone'            => '',
    // 'work_phone'            => '',

    /**
     * @var string  = null
     *
     * // no hyphens
     */
    private $mobile_phone       = null;

    /**
     * @var string = null
     */
    private $address_line1      = null;
    // 'address_line2'             => '',

    /**
     * @var string = null
     */
    private $address_city       = null;//              => 'Albrightsville',

    /**
     * @var string = null
     *
     * Example; NJ
     */
    private $address_state      = null;

    /**
     * @var string = USA
     *
     * Example: USA
     */
    private $address_country    = 'USA';

    /**
     * @var string  = null
     *
     * Example; 07059
     */
    private $address_zip1       = null;


    // A C C O U N T

    /**
     * @var string = null
     *
     * Example: JOhn Smith
     */
    private $accountHolderName                  = null;

    /**
     * @var string = null
     */
    private $acountNickname                     = null;

    /**
     * @var string = null
     *
     * Example: 123 Main Street
     */
    private $accountAddressLine                 = null;

    // 'address_line2'             => '',

    /**
     * @var string = null
     *
     * Example: Warren
     */
    private $accountAddressCity                 = null;

    /**
     * @var string = null
     *
     * Example: NJ
     */
    private $accountAddressState                = null;

    /**
     * @var string = null
     *
     * Example = USA
     */
    private $accountAddressCountry              = null;

    /**
     * @var string = null
     *
     * Example: 07059
     */
    private $accountAddressZip1                 = null;
    //  'address_zip2'              => '',

    /**
     * @var string = null
     *
     * Example: JH123 (no hyphens)
     */
    private $accountCustomerAccountReference    = null;

    /**
     * @var string = null
     *
     * This must be unique
     * Example: JHGI12345 (no hyphens)
     */
    private $accountNumber                      = null;

    /**
     * @var double = 0
     */
    private $accountCurrentBalance              = 0;
    /**
     * @var double = 0
     */
    private $accountCurrentStatementBalance     = 0;

    /**
     * @var double  = 0
     */
    private $accountMinimumPaymentDue          = 0;

    /**
     * @var double = 0
     */
    private $accountPastAmountDue               = 0;

    /**
     * @var string = null
     *
     * Example: 2017-08-09
     */
    private $accountPaymentSueDate              = null;

    /**
     * @var string = null
     *
     * Example: 2017-08-09
     */
    private $accountStatementDate               = null;


    /**
     * @var null
     */
    private $accountNickName = null;

    private $customerAccount = null;


    public function __construct(OrbiPayRequest $opri)
    {
        $this->orbiPayRequest = $opri;
    }


    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getComments()
    {
        return $this->comments ;
    }

    // 'customer_reference'    => '',

    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    public function getLastName()
    {
        return $this->last_name ;
    }
//
//    public function setGender($gender)
//    {
//        $gender = strtolower($gender);
//
//        if (($gender != 'male') || ($gender != 'female')) {
//            throw new Exception('Wrong gender assigned, excepted values are male or female')
//        } else {
//            $this->gender = $gender;
//        }
//    }

    public function getGender()
    {
        return $this->gender ;
    }

    public function setDob($dob)
    {
        $this->date_of_birth = $dob;
    }

    public function getDob()
    {
        return $this->date_of_birth ;
    }

    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    public function getSsn()
    {
        return $this->ssn ;
    }
    //'locale'                => '',

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email ;
    }
    // 'home_phone'            => '',
    // 'work_phone'            => '',

    public function setMobilPhone($mobilePhone)
    {
        $this->mobile_phone = $mobilePhone;
    }

    public function getMobilePhone()
    {
        return $this->mobile_phone ;
    }

    public function setAddress($address)
    {
        $this->address_line1 = $address;
    }

    public function getAddress()
    {
        return $this->address_line1 ;
    }
    // 'address_line2'             => '',


    public function setCity($city)
    {
        $this->address_city = $city;
    }

    public function getCity()
    {
        return $this-> address_city;
    }

    public function setState($state)
    {
        $this->address_state = $state;
    }

    public function getState()
    {
        return $this->address_state ;
    }



    public function setCountry($country)
    {
        $this->address_country = $country;
    }

    public function getCountry()
    {
        return $this->address_country;
    }

    public function setZip($zip)
    {
        $this->address_zip1 = $zip;
    }

    public function getZip()
    {
        return $this->address_zip1 ;
    }





    public function setAccountHolderName($name)
    {
        $this->accountHolderName = $name;
    }

    public function getAccountHolderName()
    {
        return $this->accountHolderName;
    }


    public function setAccountNickname($accountNickName)
    {
        $this->accountNickName = $accountNickName;
    }

    public function getAccountNickname()
    {
        return $this->accountNickName;
    }

    public function setAccountAddressLine($address)
    {
        $this->accountAddressLine = $address;
    }

    public function getAccountAddressLine()
    {
        return $this->accountAddressLine;
    }

    // 'address_line2'             => '',


    public function setAccountAddressCity($addressCity)
    {
        $this->accountAddressCity = $addressCity;
    }

    public function getAccountAddressCity()
    {
        return $this->accountAddressCity;
    }


    public function setAccountAddressState($accountAddressState)
    {
        $this->accountAddressState = $accountAddressState;
    }

    public function getAccountAddressState()
    {
        return $this->accountAddressState;
    }

    public function setAccountAddressCountry($accountAddressCountry)
    {
        $this->accountAddressCountry = $accountAddressCountry;
    }

    public function getAccountAddressCountry()
    {
        return $this->accountAddressCountry;
    }


    public function setAccountAddressZip1($accountAddressZip)
    {
        $this->accountAddressZip1 = $accountAddressZip;
    }

    public function getAccountAddressZip1()
    {
        return $this->accountAddressZip1;
    }

    public function setAccountCustomerReference($accountCustomerReference)
    {
        $this->accountCustomerAccountReference = $accountCustomerReference;
    }

    public function getAccountCustomerAccountReference()
    {
        return $this->accountCustomerAccountReference;
    }


    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setAccountCurrentBalance($accountCurrentBalance)
    {
        $this->accountCurrentBalance = $accountCurrentBalance;
    }

    public function getAccountCurrentBalance()
    {
        return $this->accountCurrentBalance;
    }

    public function setAccountCurrentStatementBalance($accountCurrentStatementBalance)
    {
        $this->accountCurrentStatementBalance = $accountCurrentStatementBalance;
    }

    public function getAccountCurrentStatementBalance()
    {
        return $this->getAccountCurrentStatementBalance();
    }


    public function setAccountMinimumPaymentDue($accountMinimumPaymentDue)
    {

    }

    public function getAccountMinimumPaymentDue()
    {

    }

    public function setAccountPastAmountDue($accountPastAmountDue)
    {

    }

    public function getAccountPastAmountDue()
    {

    }


    public function setAccountPaymentDueDate($accountPaymentDueDate)
    {

    }

    public function getAccountPaymentDueDate()
    {

    }

    public function setAccountStatementDate($accountStatementDate)
    {

    }

    public function getAccountStatementDate()
    {

    }

    public function setCustomerAccount(CustomerAccount $customerAccount)
    {
        $this->customerAccount  = $customerAccount;
    }





    public function toJson()
    {
        return [
            'customer_accounts' => [
                0 => [
                    'account_holder_name'           => 'Martin Halla', //$this->customerAccount->getAccountHolderName(),
                    'nickname'                      => 'halladesign', //$this->customerAccount->get
                    'address'                       => [
                        'address_line1'             => '399 Scenic Drive', //$this->customerAccount->get
                        // 'address_line2'             => '',
                        'address_city'              => 'Albrightsville', //$this->customerAccount->get
                        'address_state'             => 'PA', //$this->customerAccount->get
                        'address_country'           => 'USA', //$this->customerAccount->get
                        'address_zip1'              => '18210', //$this->customerAccount->get
                        //  'address_zip2'              => '',
                    ],
                    'customer_account_reference'    => 'ha-123', //$this->customerAccount->get
                    'account_number'                => '123463', // must increment $this->customerAccount->get
                    'current_balance'               => '0', //$this->customerAccount->get
                    'current_statement_balance'     => '0', //$this->customerAccount->get
                    'minimum_payment_due'           => '100', //$this->customerAccount->get
                    'past_amount_due'               => '0', //$this->customerAccount->get
                    'payment_due_date'              => '2017-08-09', //$this->customerAccount->get
                    'statement_date'                => '2017-08-01', //$this->customerAccount->get

                    // 'custom_fields'                 => [],
                ]
            ],
            'comments'              => $this->getComments(),
            // 'customer_reference'    => '',
            'first_name'            => $this->getFirstName(),
            'last_name'             => $this->getLastName(),
            //  'middle_name'           => '',
            'gender'                => $this->getGender(),
            'date_of_birth'         => $this->getDob(),
            'ssn'                   => $this->getSsn(),
            //'locale'                => '',
            'email'                 => $this->getEmail(),
            // 'home_phone'            => '',
            // 'work_phone'            => '',
            'mobile_phone'          => $this->getMobilePhone(),
            'address_line1'         => $this->getAddress(),
            // 'address_line2'             => '',
            'address_city'          => $this->getCity(),
            'address_state'         => $this->getState(),
            'address_country'       => $this->getCountry(),
            'address_zip1'          => $this->getZip()
            //  'address_zip2'              => '',

            //  'custom_fields'         => []
        ];
    }


    public function update()
    {

    }


    /**
     * @param array $payload
     * @return array|void
     */
    public function createCustomer( $payload)
    {
        try {

            $this->checkPayload($payload);

            $this->orbiPayRequest->setUri('/payments/v1/customers');

            $this->orbiPayRequest->setMethod('POST');

            $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON);

            $this->orbiPayRequest->setHeaderRequestor('guest');

            $this->orbiPayRequest->setPayLoad($payload);

            $response = $this->orbiPayRequest->callApi2();

        } catch (Exception $e) {

            $response = ['status' => 'error', 'message' => $e->getMessage()];

        }

        return $response;

    }

    public function getCustomer($customerId)
    {
       // $OrbiPayRequest = new OrbiPayRequest();

        //$customerId         = '16614027';

        $input['uri'] = '/payments/v1/customers/' . $customerId;

        $input['method'] = 'GET';

        $input['payLoad'] = [];

        $input['headerRequestor'] = $customerId;

        $input['headerContentType'] = OrbipayRequest::HEADER_CONTENT_TYPE_APPLICATION_JSON;

        echo __FILE__ . ' ' . __LINE__. '<br />';
        print_r($input);

//        $customerId         = '16614027';
//        $this->_uri         = '/payments/v1/customers/' . $customerId;
//        $this->_method      = 'GET';
//
//        $this->_payload = [];
//
//        $this->_headerRequetor = $customerId;
//
//        $this->_headerConntentType  = self::HEADER_CONTENT_TYPE_APPLICATION_JSON;



        $response = $this->orbiPayRequest->callApi($input);

        return $response;
    }

    public function listCustomers($accountNumber, $customerReference)
    {

        $this->orbiPayRequest->setMethod('POST');
        $this->orbiPayRequest->setUri('/payments/v1/customers/lists');

        $this->orbiPayRequest->setPayload([
            'account_number'        => $accountNumber,
            'customer_reference'    => $customerReference
            ]
        );

        $this->orbiPayRequest->setHeaderRequestor('guest');
        $this->orbiPayRequest->setHeaderContentType(OrbiPayRequest::HEADER_CONTENT_TYPE_APPLICATION_FORM_URL_ENCODED);

        $this->orbiPayRequest->isMultiPartRequest = true;

        $response = $this->orbiPayRequest->callApi2();

        return $response;
    }


    /**
     * @param $payload
     *
     *
     * PayLoad Example:
             [
            'customer_accounts' => [
                0 => [
                    'account_holder_name' => 'Martin Halla 2',
                    'nickname' => 'halladesign',
                    'address' => [
                        'address_line1'     => '399 Scenic Drive',
                        // 'address_line2'             => '',
                        'address_city'      => 'Albrightsville',
                        'address_state'     => 'PA',
                        'address_country'   => 'USA',
                        'address_zip1'      => '18210',
                        //  'address_zip2'              => '',
                    ],
                    'customer_account_reference'    => 'ha-123',
                    'account_number'                => '123472' . rand(1, 100), // must increment
                    'current_balance'               => '0',
                    'current_statement_balance'     => '0',
                    'minimum_payment_due'           => '100',
                    'past_amount_due'               => '0',
                    'payment_due_date'              => $paymentDueDate,
                    'statement_date'                => '2017-08-01',

                    // 'custom_fields'                 => [],
                    ]
            ],
            'comments'          => 'Some comments',
            'customer_reference'    => 'mh76-1',
            'first_name'        => 'Martin',
            'last_name'         => 'Halla2',
            //  'middle_name'           => '',
            'gender'            => 'male',
            'date_of_birth'     => '1990-01-01',
            'ssn'               => '123456789', // no hyphens
            //'locale'                => '',
            'email'             => 'martin@hawthorne-advisors.com',
            // 'home_phone'            => '',
            // 'work_phone'            => '',
            'mobile_phone'      => '9177413162', // no hyphens
            'address_line1'     => '399 Scenic Drive',
            // 'address_line2'             => '',
            'address_city'      => 'Albrightsville',
            'address_state'     => 'PA',
            'address_country'   => 'USA',
            'address_zip1'      => '18210',
     *
     */
    private function checkPayload($payload)
    {


            $requiredFieldsCustomer = [
                'customer_accounts',
                'comments',
                'customer_reference',
                'first_name',
                'last_name',
                'gender',
                'date_of_birth',
                'ssn',
                'email',
                'mobile_phone',
                'address_line1',
                'address_city',
                'address_state',
                'address_country',
                'address_zip1'
            ];

        $requiredFieldsAccount = [
            'account_holder_name',
            'nickname',

            'customer_account_reference',
            'account_number',
            'current_balance',
            'current_statement_balance',
            'minimum_payment_due',
            'past_amount_due',
            'payment_due_date',
            'statement_date'
        ];

        $requiredFieldsAccountAddress = [

                'address_line1',
                'address_city',
                'address_state',
                'address_country',
                'address_zip1'
        ];

        foreach ($requiredFieldsCustomer as $field) {
            if (empty($payload[$field])) {
                throw new \Exception("Missing or empty Customer field: '$field'");
            }
        }

        foreach ($requiredFieldsAccount as $field) {
            foreach ($payload['customer_accounts'] as $index => $data) {

                if (! isset($payload['customer_accounts'][$index][$field])) {
                    throw new \Exception("Missing or empty Customer account field: 'customer_accounts'.'$index'.'$field'");
                }
            }
        }

        foreach ($requiredFieldsAccountAddress as $field) {
            foreach ($payload['customer_accounts'] as $index => $data) {

                if (empty($payload['customer_accounts'][$index]['address'])) {
                    throw new \Exception("Missing or empty 'customer_accounts'.'$index'.'address' data");
                }

                if (empty($payload['customer_accounts'][$index]['address'][$field])) {
                    throw new \Exception("Missing or empty Customer account address field: 'customer_accounts'.'$index'.'address'.'$field'");
                }

            }
        }
    }





}