# GatewayPay SDK for PHP

#This is a PHP SDK for integrating with the GatewayPay API to handle payment processing.

## Installation

`composer require gatewaypay/gateway-php-sdk`

## Catalyst Pay Integration Guide
### 1) Go to root project and you can use this GatewayPaySDK class in your PHP code as follows

```php

require_once 'vendor/autoload.php';

use GatewayPay\GatewayPayResponseCode;
use GatewayPay\GatewayPaySDK;
try {
    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Form Values defined variable
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

    //Prepare Check out form 
    $responseData = $GatewayPaySDK->prepareCheckout($data);
    // Check if isPrepareCheckoutSuccess is true
    if ($responseData->isCheckoutSuccess()) {
        //Show checkout success
        $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . GatewayPayResponseCode::CREATED_CHECKOUT;
            $wpwlOptions = "{
                iframeStyles: {
                    'card-number-placeholder': {
                        'color': '#ff0000',
                        'font-size': '16px',
                        'font-family': 'monospace'
                    },
                    'cvv-placeholder': {
                        'color': '#0000ff',
                        'font-size': '16px',
                        'font-family': 'Arial'
                    }
                }
            }";
            
       // Payment with card
        $formData = [
            'checkoutId' => $responseData->getId(),
            'shopperResultUrl' => 'http://localhost/GatewayPay-php-sdk/copy_and_pay_result.php',
            'dataBrands' => [
                GatewayPaySDK::PAYMENT_BRAND_VISA,
                GatewayPaySDK::PAYMENT_BRAND_MASTERCARD,
                GatewayPaySDK::PAYMENT_BRAND_AMEX
                ],
            'wpwlOptions' => $wpwlOptions
        ];
        echo $GatewayPaySDK->createPaymentForm($formData);

        // Payment with google pay
        $formData2 = [
            'checkoutId' => $responseData->getId(),
            'shopperResultUrl' => 'http://localhost/GatewayPay-php-sdk/copy_and_pay_result.php',
            'dataBrands' => [GatewayPaySDK::PAYMENT_BRAND_GOOGLE_PAY],
            'wpwlOptions' => $wpwlOptions
        ];
        echo $GatewayPaySDK->createPaymentForm($formData2);

        // Payment with rocket fuel
        $formData4 = [
            'checkoutId' => $responseData->getId(),
            'shopperResultUrl' => 'http://localhost/GatewayPay-php-sdk/copy_and_pay_result.php',
            'dataBrands' => [GatewayPaySDK::PAYMENT_BRAND_ROCKET_FUEL],
            'wpwlOptions' => $wpwlOptions
        ];
        echo $GatewayPaySDK->createPaymentForm($formData4);
    } else {
        echo "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
   echo $e->getMessage();
}
```

### 2) Go to root project and you can use this GatewayPaySDK class to get payment status in your PHP code as follows

```php

require_once 'vendor/autoload.php';
use GatewayPay\GatewayPaySDK;

try {

    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );
    $errorMsg = '';
    // Handle the payment status as needed
    if (isset(($_GET['id']))) {
        $checkoutId = $_GET['id'];
        $responseData = $GatewayPaySDK->getPaymentStatus($checkoutId);
        print_r($responseData->getApiResponse()); // Get payment status response 
        var_dump($responseData->isPaymentStatus()); // Check  payment status value True or False

        // Check IF payment  status is success 
        if ($responseData->isPaymentStatus()) {

            // Check IF payment transaction pending is true
            if ($responseData->isPaymentTransactionPending()) {
                echo 'The transaction should be pending, but is ' . $responseData->getResultCode();
            } elseif ($responseData->isPaymentRequestNotFound()) { // Check IF payment request not found is true
                echo'No payment session found for the requested id, but is ' . $responseData->getResultCode();
            }
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

```

## Gateway Pay Registration Tokens

### 1) Go to root project and you can use this GatewayPaySDK class for Prepare the checkout and create the registration form in your PHP code as follows

```php
require_once 'vendor/autoload.php';
use GatewayPay\GatewayPayResponseCode;
use GatewayPay\GatewayPaySDK;

try {
    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $isCreateRegistration = 'true';
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Form Values defined variable
    $data = [
        'testMode' => GatewayPaySDK::TEST_MODE_EXTERNAL,
        'createRegistration' => $isCreateRegistration
    ];
    //Prepare Check out form 
    $responseData = $GatewayPaySDK->prepareRegisterCheckout($data);

    //  print_r($responseData);
    // var_dump($responseData->isCheckoutSuccess());
    // Check if checkout success is true
    if ($responseData->isCheckoutSuccess()) {
        //Show checkout success
        $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . GatewayPayResponseCode::CREATED_CHECKOUT;

        $wpwlOptions = "{
            iframeStyles: {
                'card-number-placeholder': {
                    'color': '#ff0000',
                    'font-size': '16px',
                    'font-family': 'monospace'
                },
                'cvv-placeholder': {
                    'color': '#0000ff',
                    'font-size': '16px',
                    'font-family': 'Arial'
                }
            }
        }";

        // Payment with card
        $formData = [
            'checkoutId' => $responseData->getId(),
            'shopperResultUrl' => 'http://localhost/GatewayPay-php-sdk/registration_token_payment.php',
            'dataBrands' => [
                GatewayPaySDK::PAYMENT_BRAND_VISA ,
                GatewayPaySDK::PAYMENT_BRAND_MASTERCARD,
                GatewayPaySDK::PAYMENT_BRAND_AMEX
                ],
            'wpwlOptions' => $wpwlOptions
        ];

        echo $GatewayPaySDK->getCreateRegistrationPaymentForm($formData);       
    } else {
        echo "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
   echo $e->getMessage();
} 
```


### 2) Go to root project and you can use this GatewayPaySDK class to get the registration status and Send payment using the token in your PHP code as follows

```php
// Example usage
try {
    $errorMsg = '';
    $isSuccessful = false;
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Handle the payment Registration status as needed
    if (isset(($_GET['id']))) {
        $checkoutId = $_GET['id'];
        $responseData = $GatewayPaySDK->getRegistrationStatus($checkoutId);
        print_r($responseData->getApiResponse()); // Get payment Registration status response 
        var_dump($responseData->isRegistrationStatus()); // Check  payment Registration status value True or False

        // Check IF payment registration status is success 
        if ($responseData->isRegistrationStatus()) {
            $paymentId = $responseData->getId(); // get the payment id

            // Form Values defined variable
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

            // Send payment using the token
            $registerPayment = $GatewayPaySDK->sendRegistrationTokenPayment($paymentId, $data);

            //check if payment Successful true
            $isPaymentSuccessful =  $registerPayment->isSuccessful();

            print_r($registerPayment->getApiResponse()); // Get send payment Registration response
            // Check IF payment transaction pending is true
            if ($registerPayment->isPaymentTransactionPending()) {
               echo'The transaction should be pending, but is ' . $registerPayment->getResultCode();
            } elseif ($registerPayment->isPaymentRequestNotFound()) { // Check IF payment request not found is true
               echo 'No payment session found for the requested id, but is ' . $registerPayment->getResultCode();
            }
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## Transaction Reports

### 1) Go to root project and you can use this GatewayPaySDK class for transaction reports allow to retrieve detailed transactional data from the platform in your PHP code as follows

```php
require_once 'vendor/autoload.php';

use GatewayPay\GatewayPaySDK;

// Example usage
try {

    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Get Transaction by id
    $responseData = $GatewayPaySDK->getTransactionById(['id' => '8ac7a4a1845f7e19018461a00b366a74', 'includeLinkedTransactions' => 'true', 'paymentTypes' => 'DB,3D','paymentMethods' => 'CC,DC']);
    print_r($responseData->getApiResponse()); // Get Transaction response 

       // Get Transaction by merchant ID 
    $transactionMerchant = $GatewayPaySDK->getMerchantTransactionById('test123');
    print_r($transactionMerchant->getApiResponse());

    // Get transactions for a specified time frame
    $transactionSpecifiedTimeFrame = $GatewayPaySDK->getTransactionByDateFilter(['dateFrom' => '2023-01-01 00:00:00', 'dateTo' => '2023-01-01 01:00:00','merchantTransactionId' => 'test123', 'paymentTypes' => 'DB,3D', 'paymentMethods' => 'CC,DC', 'limit' => 20]);
    print_r($transactionSpecifiedTimeFrame->getApiResponse());

    // Get transactions for a specified time frame with pagination
    $transactionPagination = $GatewayPaySDK->getTransactionByDateWithPagination(['dateFrom' => '2023-01-01 00:00:00', 'dateTo' => '2023-01-01 01:00:00','merchantTransactionId' => 'test123', 'paymentTypes' => 'DB,3D', 'paymentMethods' => 'CC,DC', 'pageNo' => 2]);
    print_r($transactionPagination);
} catch (Exception $e) {
    echo  $e->getMessage();
}
```

### 2) Go to root project and you can use this GatewayPaySDK class for settlement reports allow to retrieve detailed settlements data from the platform in your PHP code as follows
```php
require_once 'vendor/autoload.php';

use GatewayPay\GatewayPaySDK;

// Example usage
try {

    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Get summary level information for a certain date and/or settlement currency
    $settlementReportBySummary = $GatewayPaySDK->getSettlementReportBySummary(['dateFrom' => '2015-08-01', 'dateTo' => '2015-08-02', 'currency' => 'EUR', 'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL]);
    print_r($settlementReportBySummary->getApiResponse());

    //Get further details for a particular aggregation id.
    $responseData = $GatewayPaySDK->getDetailLevelById(['id' => '8a82944a4cc25ebf014cc2c782423202','sortValue'=>'SettlementTxDate','sortOrder'=>'ASC', 'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL]);
    print_r($responseData->getApiResponse());

    // Get detail level with pagination
    $settlementReportPagination = $GatewayPaySDK->getDetailLevelByIdWithPagination(['id' => '8a82944a4cc25ebf014cc2c782423202','reconciliationType'=>'SETTLED' ,'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL, "pageNo" => 2]);
    print_r($settlementReportPagination);
} catch (Exception $e) {
    echo  $e->getMessage();
}

```

## Backoffice Operations

### 1) Go to root project and you can use this GatewayPaySDK class for  You can perform different types of backoffice operations for a rebill is performed against a previous payment, using our REST API from the platform in your PHP code as follows

```php
require_once 'vendor/autoload.php';

use GatewayPay\GatewayPaySDK;

// Example usage
try {

    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );
 
    // Capture an authorization
    $dataCapturePaymentsByOperations = [
        'paymentId' => '8a82944a4cc25ebf014cc2c782423202',
        'paymentType' => 'CP',
        'amount' => '10.00',
        'currency' => 'EUR',
    ];

    $paymentsByCaptureOperations = $GatewayPay->paymentsByOperations($dataCapturePaymentsByOperations);
    print_r($paymentsByCaptureOperations);

    // Refund a payment
    $dataRefundPaymentsByOperations = [
        'paymentId' => '8a82944a4cc25ebf014cc2c782423202',
        'paymentType' => 'RF',
        'amount' => '10.00',
        'currency' => 'EUR',
    ];

    $paymentsRefundByOperations = $GatewayPay->paymentsByOperations($dataRefundPaymentsByOperations);
    print_r($paymentsRefundByOperations);

    // Receipt for payment
    $dataReceiptPaymentsByOperations = [
        'paymentId' => '8a82944a4cc25ebf014cc2c782423202',
        'paymentType' => 'RC',
        'amount' => '10.00',
        'currency' => 'EUR',
    ];

    $paymentsReceiptByOperations = $GatewayPay->paymentsByOperations($dataReceiptPaymentsByOperations);
    print_r($paymentsReceiptByOperations);
       
    // Rebill for payment
    $dataRebillPaymentsByOperations = [
        'paymentId' => '8a82944a4cc25ebf014cc2c782423202',
        'paymentType' => 'RB',
        'amount' => '10.00',
        'currency' => 'EUR',
    ];

    $paymentsRebillByOperations = $GatewayPay->paymentsByOperations($dataRebillPaymentsByOperations);
    print_r($paymentsRebillByOperations);
     
    // Reverse a payment
    $dataReversePaymentsByOperations = [
        'paymentId' => $payCardRequest->getId(),
        'paymentType' => 'RV',
    ];

    $paymentsReverseByOperations = $GatewayPay->paymentsByOperations($dataReversePaymentsByOperations);
    print_r($paymentsReverseByOperations);
} catch (Exception $e) {
    echo  $e->getMessage();
}

```

### 2) Go to root project and you can use this GatewayPaySDK class for  You can perform different types of backoffice operations for Credit (stand-alone refund) using our REST API from the platform in your PHP code as follows

```php
require_once 'vendor/autoload.php';

use GatewayPay\GatewayPaySDK;

// Example usage
try {

    // Configured  GatewayPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $GatewayPaySDK = new GatewayPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    $dataPaymentsByOperations =[
        'paymentType'=> 'CD',
        'amount'=> '10.00',
        'currency'=> 'EUR', 
        'paymentBrand' =>'VISA',
        'cardNumber' => '4200000000000000',
        'cardExpiryMonth' => '12',
        'cardExpiryYear' => '2025',
        'cardHolder' => 'Jane Jones',        
    ];
    
    $paymentsByOperations = $GatewayPaySDK->CreditStandAloneRefund($dataPaymentsByOperations);
    $resultPaymentsByOperations = $paymentsByOperations->getApiResponse(); 
    print_r($resultPaymentsByOperations);
} catch (Exception $e) {
    echo  $e->getMessage();
}

```