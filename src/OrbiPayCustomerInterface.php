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


    public function createCustomer($payload);


    public function getCustomer($customerId);


}