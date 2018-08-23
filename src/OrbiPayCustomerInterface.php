<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace thegoodbyte\orbipay;

use Customer;


interface OrbiPayCustomerInterface
{


    public function createCustomer();

    public function setFirstName($firstName);

    public function toJson();

    public function setComments($comments);

    public function setLastName($lastName);

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



    public function setDob($dob);

    public function setSsn($ssn);

    public function setEmail($email);

    public function setMobilPhone($mobilePhone);

    public function setAddress($address);

    public function setCity($city);

    public function setState($state);

    public function setCountry($country);

    public function setZip($zip);

    public function setAccountHolderName($name);

    public function setAccountNickname($accountNickName);

    public function setAccountAddressLine($address);

    public function setAccountAddressCity($addressCity);

    public function setAccountAddressState($accountAddressState);

    public function setAccountAddressCountry($accountAddressCountry);

    public function setAccountAddressZip1($accountAddressZip);

    public function setAccountCustomerReference($accountCustomerReference);

    public function setAccountNumber($accountNumber);

    public function setAccountCurrentBalance($accountCurrentBalance);

    public function setAccountCurrentStatementBalance($accountCurrentStatementBalance);

    public function setAccountMinimumPaymentDue($accountMinimumPaymentDue);

    public function setAccountPastAmountDue($accountPastAmountDue);

    public function setAccountPaymentDueDate($accountPaymentDueDate);

    public function setAccountStatementDate($accountStatementDate);

    public function setCustomerAccount(CustomerAccount $customerAccount);

    public function getCustomer(OrbiPayRequestInterface $OrbiPayRequest);


}