<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace thegoodbyte\orbipay;


interface OrbiPayPaymentSetupInterface
{

    public function createPaymentSetup($customerId, $fundingAccountNumberId, $customerAccountId, $payload);

    public function getPaymentSetup($customerId, $paymentSetupId);

    public function deletePaymentSetup( $customerId, $paymentSetupId);

    public function listPaymentSetups($customerId);


}