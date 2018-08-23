<?php
/**
 * Created by PhpStorm.
 * User: halladesign
 * Date: 8/21/18
 * Time: 11:53 AM
 */

namespace mhalla\OrbiPay;




interface OrbiPayFundingAccountInterface
{


    public function createFundingAccount();

    public function listFundingAccount();

    public function deleteFundingAccount();


//    public function createFundingAccount()
//    {
//
//    }
//
//    public function setupPayment()
//    {
//
//    }


}