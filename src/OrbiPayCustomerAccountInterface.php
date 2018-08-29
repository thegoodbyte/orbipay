<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace thegoodbyte\orbipay;

interface OrbiPayCustomerAccountInterface
{


    public function createCustomerAccount($payload);

    public function getCustomerAccount($customerId);

    public function listCustomerAccounts($customerId);

    public function getDebugInfo();


}