<?php

namespace Tests\GatewayPayTestCase;

use GatewayPay\GatewayPaySDK;
use Tests\TestCase;

class BackofficeOperationsTestCase extends TestCase
{
    /**
     * Test the payments by operations.
     */
    public function testPaymentsByOperations()
    {
        $GatewayPay =  $this->getGatewayPayConfig();

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


        // Capture an authorization
        $dataCapturePaymentsByOperations = [
            'paymentId' => $payCardRequest->getId(),
            'paymentType' => 'RC',
            'amount' => '10.00',
            'currency' => 'EUR',
        ];

        $paymentsByCaptureOperations = $GatewayPay->paymentsByOperations($dataCapturePaymentsByOperations);
        // assert
        $this->assertTrue($paymentsByCaptureOperations->isSuccessful(), 'The transaction for capture payment should be pending, but is ' . $paymentsByCaptureOperations->getResultCode());

        // Refund a payment
        $dataRefundPaymentsByOperations = [
            'paymentId' => $payCardRequest->getId(),
            'paymentType' => 'RF',
            'amount' => '10.00',
            'currency' => 'EUR',
        ];

        $paymentsRefundByOperations = $GatewayPay->paymentsByOperations($dataRefundPaymentsByOperations);
        // assert
        $this->assertTrue($paymentsRefundByOperations->isSuccessful(), 'The transaction for refund payment should be pending, but is ' . $paymentsRefundByOperations->getResultCode());


        // Receipt for payment
        $dataReceiptPaymentsByOperations = [
            'paymentId' => $payCardRequest->getId(),
            'paymentType' => 'RC',
            'amount' => '10.00',
            'currency' => 'EUR',
        ];

        $paymentsReceiptByOperations = $GatewayPay->paymentsByOperations($dataReceiptPaymentsByOperations);
        // assert
        $this->assertTrue($paymentsReceiptByOperations->isSuccessful(), 'The transaction for receipt should be pending, but is ' . $paymentsReceiptByOperations->getResultCode());

        // Rebill for payment
        $dataRebillPaymentsByOperations = [
            'paymentId' => $payCardRequest->getId(),
            'paymentType' => 'RB',
            'amount' => '10.00',
            'currency' => 'EUR',
        ];

        $paymentsRebillByOperations = $GatewayPay->paymentsByOperations($dataRebillPaymentsByOperations);
        // assert
        $this->assertTrue($paymentsRebillByOperations->isSuccessful(), 'The transaction for rebill should be pending, but is ' . $paymentsRebillByOperations->getResultCode());
    }

    /**
     * Test the Credit is a independent transaction that results in a refund.
     */
    public function testCreditStandAloneRefund()
    {
        $GatewayPay =  $this->getGatewayPayConfig();
        $dataPaymentsByOperations = [
            'paymentType' => 'CD',
            'amount' => '10.00',
            'currency' => 'EUR',
            'paymentBrand' => 'VISA',
            'cardNumber' => '4200000000000000',
            'cardExpiryMonth' => '12',
            'cardExpiryYear' => '2025',
            'cardHolder' => 'Jane Jones',
        ];

        $paymentsByOperations = $GatewayPay->CreditStandAloneRefund($dataPaymentsByOperations);
        // assert
        $this->assertTrue($paymentsByOperations->isSuccessful(), 'The transaction for refund should be pending, but is ' . $paymentsByOperations->getResultCode());
    }

    /**
     * Test the payments by  the Reverse a payment operations.
     */
    public function testReversePayment()
    {
        $GatewayPay =  $this->getGatewayPayConfig();
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
        // Reverse a payment
        $dataReversePaymentsByOperations = [
            'paymentId' => $payCardRequest->getId(),
            'paymentType' => 'RV',
        ];

        $paymentsReverseByOperations = $GatewayPay->paymentsByOperations($dataReversePaymentsByOperations);
        // assert
        $this->assertTrue($paymentsReverseByOperations->isSuccessful(), 'The transaction for reverse payment should be pending, but is ' . $paymentsReverseByOperations->getResultCode());
    }
}
