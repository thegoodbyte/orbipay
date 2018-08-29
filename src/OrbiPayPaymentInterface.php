<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace thegoodbyte\orbipay;

interface OrbiPayPaymentInterface
{

    public function chargeAccount($customerId, $payload);

    public function getPayment($customerId, $paymentId);

    public function updatePayment($customerId, $paymentId, $payload);

    public function deletePayment($customerId, $paymentId);

    public function listPayments($customerId, $fundingAccountId);

    public function getDebugInfo();

}