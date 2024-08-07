<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait CopyAndPayCheckout
 * This trait provides methods to interact with the CatalystPay CopyAndPay Checkout API.
 */
trait SubscriptionCheckout
{
    use PerformsPOST, PerformsGET;

    /**
     * Prepares a new checkout.
     *
     * @param array  $data  The payment data like amount,currency , paymentType etc.
     * 
     * @return array The decoded JSON response.
     */
    public function prepareSubscriptionCheckout($data = [])
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "paymentType" => $data['paymentType'],
        ];

        // check if billing city
        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if billing country
        if (isset($data['billing.country'])) {
            $baseOptions['billing.country'] = $data['billing.country'];
        }
        // check if billing street1
        if (isset($data['billing.street1'])) {
            $baseOptions['billing.street1'] = $data['billing.street1'];
        }
        // check if billing postcode
        if (isset($data['billing.postcode'])) {
            $baseOptions['billing.postcode'] = $data['billing.postcode'];
        }

        // check if billing city
        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if customer email
        if (isset($data['customer.email'])) {
            $baseOptions['customer.email'] = $data['customer.email'];
        }
        // check if customer.givenName
        if (isset($data['customer.givenName'])) {
            $baseOptions['customer.givenName'] = $data['customer.givenName'];
        }
        // check if customer surname
        if (isset($data['customer.surname'])) {
            $baseOptions['customer.surname'] = $data['customer.surname'];
        }
        if (isset($data['standingInstruction.type'])) {
            $baseOptions['standingInstruction.type'] = $data['standingInstruction.type'];
        }
        if (isset($data['standingInstruction.mode'])) {
            $baseOptions['standingInstruction.mode'] = $data['standingInstruction.mode'];
        }
        if (isset($data['standingInstruction.source'])) {
            $baseOptions['standingInstruction.source'] = $data['standingInstruction.source'];
        }
        if (isset($data['standingInstruction.recurringType'])) {
            $baseOptions['standingInstruction.recurringType'] = $data['standingInstruction.recurringType'];
        }
        if (isset($data['threeDSecure.eci'])) {
            $baseOptions['threeDSecure.eci'] = $data['threeDSecure.eci'];
        }
        if (isset($data['threeDSecure.authenticationStatus'])) {
            $baseOptions['threeDSecure.authenticationStatus'] = $data['threeDSecure.authenticationStatus'];
        }
        if (isset($data['threeDSecure.version'])) {
            $baseOptions['threeDSecure.version'] = $data['threeDSecure.version'];
        }
        if (isset($data['threeDSecure.dsTransactionId'])) {
            $baseOptions['threeDSecure.dsTransactionId'] = $data['threeDSecure.dsTransactionId'];
        }
        if (isset($data['threeDSecure.acsTransactionId'])) {
            $baseOptions['threeDSecure.acsTransactionId'] = $data['threeDSecure.acsTransactionId'];
        }
        if (isset($data['threeDSecure.verificationId'])) {
            $baseOptions['threeDSecure.verificationId'] = $data['threeDSecure.verificationId'];
        }
        if (isset($data['threeDSecure.amount'])) {
            $baseOptions['threeDSecure.amount'] = $data['threeDSecure.amount'];
        }
        if (isset($data['threeDSecure.currency'])) {
            $baseOptions['threeDSecure.currency'] = $data['threeDSecure.currency'];
        }
        if (isset($data['threeDSecure.flow'])) {
            $baseOptions['threeDSecure.flow'] = $data['threeDSecure.flow'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Payment with card.
     *
     * @param array  $data  The payment data like amount,currency paymentType etc.
     * @return array The decoded JSON response.
     */
    public function paySubscriptionCard($data = [])
    {
        $baseOptions = [
            "entityId" => $data['entityId'],
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "paymentType" => $data['paymentType'],
            "paymentBrand"=> $data['paymentBrand'],
            "card.number"=> $data['card.number'],
            "card.holder"=> $data['card.holder'],
            "card.expiryMonth"=> $data['card.expiryMonth'],
            "card.expiryYear"=> $data['card.expiryYear'],
            "card.cvv"=> $data['card.cvv'],
        ];

        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if billing country
        if (isset($data['billing.country'])) {
            $baseOptions['billing.country'] = $data['billing.country'];
        }
        // check if billing street1
        if (isset($data['billing.street1'])) {
            $baseOptions['billing.street1'] = $data['billing.street1'];
        }
        // check if billing postcode
        if (isset($data['billing.postcode'])) {
            $baseOptions['billing.postcode'] = $data['billing.postcode'];
        }

        // check if billing city
        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if customer email
        if (isset($data['customer.email'])) {
            $baseOptions['customer.email'] = $data['customer.email'];
        }
        // check if customer.givenName
        if (isset($data['customer.givenName'])) {
            $baseOptions['customer.givenName'] = $data['customer.givenName'];
        }
        // check if customer surname
        if (isset($data['customer.surname'])) {
            $baseOptions['customer.surname'] = $data['customer.surname'];
        }
        if (isset($data['testMode'])) {
            $data['testMode'] = $data['testMode'];
        }
        if (isset($data['standingInstruction.type'])) {
            $baseOptions['standingInstruction.type'] = $data['standingInstruction.type'];
        }
        if (isset($data['standingInstruction.mode'])) {
            $baseOptions['standingInstruction.mode'] = $data['standingInstruction.mode'];
        }
        if (isset($data['standingInstruction.source'])) {
            $baseOptions['standingInstruction.source'] = $data['standingInstruction.source'];
        }
        if (isset($data['standingInstruction.recurringType'])) {
            $baseOptions['standingInstruction.recurringType'] = $data['standingInstruction.recurringType'];
        }
        
        $url = $this->baseUrl . '/v1' . CatalystPaySDK::URI_PAYMENTS;
        $response =  $this->doPOST($url, $data, $this->isProduction, $this->token);
        return $response;
    }

    public function paymentSubscriptionCard($data = [])
    {
        $baseOptions = [
            "entityId" => $data['entityId'],
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "paymentType" => $data['paymentType'],
            "registrationId" => $data['registrationId'],
            "testMode" => $data['testMode'],
            "standingInstruction.type" => $data['standingInstruction.type'],
            "standingInstruction.mode" => $data['standingInstruction.mode'],
            "standingInstruction.source" => $data['standingInstruction.source'],
            "standingInstruction.recurringType" => $data['standingInstruction.recurringType'],
            "job.second" =>$data['job.second'],
            "job.minute" =>$data['job.minute'],
            "job.hour" =>$data['job.hour'],
            "job.dayOfMonth" =>$data['job.dayOfMonth'],
            "job.month" =>$data['job.month'],
            "job.dayOfWeek" =>$data['job.dayOfWeek'],
            "job.year" =>$data['job.year'],
            "job.startDate" =>$data['job.startDate'],
        ];

        $url = $this->baseUrl . CatalystPaySDK::SCHEDULING_PAYMENTS;
        $response =  $this->doPOST($url, $data, $this->isProduction, $this->token);
        return $response;
    }
    /**
     * Get the Request for a Cancel Schedule
     *
     * @param string $scheduleId The ID of the Schedule.
     * @return string The URL to check the Cancel Schedule.
     */
    public function CancelSchedule($scheduleId)
    {
        $url = $this->baseUrl . CatalystPaySDK::SCHEDULING_PAYMENTS . '/' . $scheduleId;
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }   
}
