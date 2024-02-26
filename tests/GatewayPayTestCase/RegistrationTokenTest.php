<?php

namespace Tests\GatewayPayTestCase;

use GatewayPay\GatewayPayResponse;
use Tests\TestCase;
use GatewayPay\GatewayPaySDK;
use GatewayPay\GatewayPayResponseCode;

class RegistrationTokenTest extends TestCase
{
    /**
     * Test the prepares a new checkout.
     */
    public function testPrepareRegistrationTokenCheckout()
    {

        $GatewayPay =  $this->getGatewayPayConfig();

        // Form Values defined variable
        $data = [
            'testMode' => GatewayPaySDK::TEST_MODE_EXTERNAL,
            'createRegistration' => true
        ];
        //Prepare Check out form 
        $response = $GatewayPay->prepareRegisterCheckout($data);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . GatewayPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));

        // Get the Registration Token status
        $registrationTokenStatusResponse = $GatewayPay->getRegistrationStatus($response->getId());
        $this->assertEquals(!$registrationTokenStatusResponse->isRegistrationStatus(), $registrationTokenStatusResponse->getResultCode(), 'The transaction should be pending, but is ' . $registrationTokenStatusResponse->getResultCode());    // Send payment using the token


        // Registration Token Values defined variable
        $data = [
            'paymentBrand' => GatewayPaySDK::PAYMENT_BRAND_VISA,
            'paymentType' =>  GatewayPaySDK::PAYMENT_TYPE_DEBIT,
            'amount' => 92.00,
            'currency' => 'EUR',
            'standingInstructionType' =>  GatewayPaySDK::STANDING_INSTRUCTION_TYPE_UNSCHEDULED,
            'standingInstructionMode' =>  GatewayPaySDK::STANDING_INSTRUCTION_MODE_INITIAL,
            'standingInstructionSource' => GatewayPaySDK::STANDING_INSTRUCTION_SOURCE_CIT,
            'testMode' => GatewayPaySDK::TEST_MODE_EXTERNAL
        ];
        $registerPayment = $GatewayPay->sendRegistrationTokenPayment($response->getId(), $data);
        //$this->assertTrue($registerPayment->isPaymentTransactionPending(), 'The payment' . $registerPayment->getId() . ' was not successful and should have been');
        $this->assertTrue($registerPayment);
    }
}
