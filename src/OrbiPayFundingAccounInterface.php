<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace thegoodbyte\orbipay;


interface OrbiPayFundingAccountInterface
{

    public function listCustomerAccounts($customerId);

    public function updateCustomerAccount($customerId, $fundingAccountNumberId, $payload);


}