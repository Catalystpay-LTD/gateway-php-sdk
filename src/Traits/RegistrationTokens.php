<?php

namespace GatewayPay\Traits;

use GatewayPay\GatewayPaySDK;
use GatewayPay\Traits\Client\PerformsGET;
use GatewayPay\Traits\Client\PerformsPOST;

/**
 * Trait RegistrationTokens
 * This trait provides methods to interact with the GatewayPay COPYandPAY Registration Tokens API.
 */
trait RegistrationTokens
{
    use PerformsPOST, PerformsGET;

    /**
     * Prepares a new Register checkout.
     *
     * @param array  $data  The payment data like amount,currency paymentType etc..     
     *
     * @return array The decoded JSON response.
     */
    public function prepareRegisterCheckout($data)
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "testMode" => $data['testMode'],
            "createRegistration" => $data['createRegistration'],
        ];
        $url = $this->baseUrl . GatewayPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Get the registration status.
     *
     * @param string $checkoutId The ID of the payment.
     * @return string The URL to check the payment status.
     */
    public function getRegistrationStatus($checkoutId)
    {
        $url = $this->baseUrl . GatewayPaySDK::URI_CHECKOUTS . '/' . $checkoutId . GatewayPaySDK::URI_REGISTRATION . '?entityId=' . $this->entityId;
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }

    /**
     *  Send payment using the token.
     *     
     * @param array $data The payment data like amount,currency paymentType etc.
     *
     * @return array The decoded JSON response.
     */
    public function sendRegistrationTokenPayment($paymentId, $data = [])
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "paymentBrand" => $data['paymentBrand'],
            "paymentType" => $data['paymentType'],
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "standingInstruction.type" => $data['standingInstructionType'],
            "standingInstruction.mode" => $data['standingInstructionMode'],
            "standingInstruction.source" => $data['standingInstructionSource'],
            "testMode" => $data['testMode']
        ];

        $url = $this->baseUrl . GatewayPaySDK::URI_REGISTRATIONS . '/' . $paymentId . GatewayPaySDK::URI_PAYMENTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }
}
