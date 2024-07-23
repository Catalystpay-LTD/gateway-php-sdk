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
        $data = [
            'amount' => '100.00',
            'currency' => 'USD',
            'paymentType' => 'DB',
            'billing.city' => 'Test City',
            'billing.country' => 'US',
            'billing.street1' => 'Test Street 1',
            'billing.postcode' => '12345',
            'customer.email' => 'test@example.com',
            'customer.givenName' => 'John',
            'customer.surname' => 'Doe',
            'standingInstruction.type' => 'RECURRING',
            'standingInstruction.mode' => 'REPEATED',
            'standingInstruction.source' => 'CIT',
            'standingInstruction.recurringType' => 'FIXED',
            'threeDSecure.eci' => '05',
            'threeDSecure.authenticationStatus' => 'Y',
            'threeDSecure.version' => '2.0',
            'threeDSecure.dsTransactionId' => '123456789',
            'threeDSecure.acsTransactionId' => '987654321',
            'threeDSecure.verificationId' => 'verification123',
            'threeDSecure.amount' => '100.00',
            'threeDSecure.currency' => 'USD',
            'threeDSecure.flow' => 'CHALLENGE',
        ];

        $registerPayment = $GatewayPay->sendRegistrationTokenPayment($response->getId(), $data);
        //$this->assertTrue($registerPayment->isPaymentTransactionPending(), 'The payment' . $registerPayment->getId() . ' was not successful and should have been');
        $this->assertTrue($registerPayment);
    }
}
