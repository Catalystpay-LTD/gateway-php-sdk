<?php

namespace Tests\GatewayPayTestCase;

use GatewayPay\GatewayPayResponse;
use Tests\TestCase;
use GatewayPay\GatewayPaySDK;
use GatewayPay\GatewayPayResponseCode;

class SubscriptionCheckoutTestCase extends TestCase
{
    /**
     * Test the prepares a new checkout.
     */
    public function testsubscriptioncheckout()
    {

        $GatewayPay =  $this->getGatewayPayConfig();

        $data = [
            'amount' => '92',
            'currency' => 'EUR',
            'paymentType' => GatewayPaySDK::PAYMENT_TYPE_DEBIT,
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
            'threeDSecure.amount' => '92.00',
            'threeDSecure.currency' => 'EUR',
            'threeDSecure.flow' => 'CHALLENGE',
        ];


        $response = $GatewayPay->prepareSubscriptionCheckout($data);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . GatewayPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));

        //card details
        $cardData = [
            'amount' => 92.00,
            'currency' => 'EUR',
            'paymentBrand' => GatewayPaySDK::PAYMENT_BRAND_VISA,
            'paymentType' => GatewayPaySDK::PAYMENT_TYPE_DEBIT,
            'card.number' => 4111111111111111,
            'card.expiryMonth' => 12,
            'card.expiryYear' => 2025,
            'card.holder' => 'John Smith',
            'card.cvv' => 123,
        ];

        //payment with card
        $payCardRequest = $GatewayPay->paySubscriptionCard($cardData);
        $this->assertTrue($payCardRequest->isSuccessful(), 'The payment was not successful and should have been');
        // Get the payment status
        $id = $GatewayPay->getPaymentStatus($response->getId());

        //card details
        $cardData = [
            'amount' => 92.00,
            'currency' => 'EUR',
            'paymentType' => GatewayPaySDK::PAYMENT_TYPE_DEBIT,
            "registrationId" => $id,
            "testMode" => true,
            "standingInstruction.type"=>"RECURRING",
            "standingInstruction.mode"=>"REPEATED",
            "standingInstruction.source"=>"MIT",
            "standingInstruction.recurringType"=>"SUBSCRIPTION",
            "job.second"=>30,
            "job.minute"=>24,
            "job.hour"=>15,
            "job.dayOfMonth"=>"*",
            "job.month"=>"*",
            "job.dayOfWeek"=>"?",
            "job.year"=>"*",
        ];

        //payment with card
        $payCardRequest = $GatewayPay->paymentSubscriptionCard($cardData);
        $this->assertTrue($payCardRequest->isSuccessful(), 'The payment was not successful and should have been');
        // Get the payment status
        $paymentStatusResponse = $GatewayPay->getPaymentStatus($response->getId());
        $this->assertEquals(GatewayPayResponseCode::TRANSACTION_PENDING, $paymentStatusResponse->getResultCode(), 'The Subscription should be pending, but is ' . $paymentStatusResponse->getResultCode());
    }
}
