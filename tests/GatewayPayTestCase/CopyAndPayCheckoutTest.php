<?php

namespace Tests\GatewayPayTestCase;

use GatewayPay\GatewayPayResponse;
use Tests\TestCase;
use GatewayPay\GatewayPaySDK;
use GatewayPay\GatewayPayResponseCode;

class CopyAndPayCheckoutTest extends TestCase
{
    /**
     * Test the prepares a new checkout.
     */
    public function testPrepareCheckout()
    {
        $GatewayPay = $this->getGatewayPayConfig();

        // Checkout Values defined variable
        $data = [
            'amount' => 92.00,
            'currency' => 'EUR',
            'paymentType' => GatewayPaySDK::PAYMENT_TYPE_DEBIT,
            'billing.city' => 'surat',
            'billing.country' => 'DE',
            'billing.street1' => 'test',
            'billing.postcode' => 394210,
            'customer.email' => 'test@gmail.com',
            'customer.givenName' => 'John Smith',
            'customer.surname' => 'Don',
            'customer.ip' => '192.168.0.1'
        ];

        $response = $GatewayPay->prepareCheckout($data);

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
        $payCardRequest = $GatewayPay->payCard($cardData);
        $this->assertTrue($payCardRequest->isSuccessful(), 'The payment was not successful and should have been');

        // Get the payment status
        $paymentStatusResponse = $GatewayPay->getPaymentStatus($response->getId());
        $this->assertEquals(GatewayPayResponseCode::TRANSACTION_PENDING, $paymentStatusResponse->getResultCode(), 'The transaction should be pending, but is ' . $paymentStatusResponse->getResultCode());
    }
}
