<?php
require_once 'vendor/autoload.php';

use GatewayPay\GatewayPayResponseCode;
use GatewayPay\GatewayPaySDK;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <?php

        // Example usage
        try {
            $infoMessage = $errorMessage = '';

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
            if (isset($_POST['submit'])) {
                // Form Values defined variable
                $data = [
                    'testMode' => GatewayPaySDK::TEST_MODE_EXTERNAL,
                    'createRegistration' => $isCreateRegistration,                    
                ];
                //Prepare Check out form 
                $responseData = $GatewayPaySDK->prepareRegisterCheckout($data);

                //  print_r($responseData);
                // var_dump($responseData->isCheckoutSuccess());
                // Check if checkout success is true
                if ($responseData->isCheckoutSuccess()) {
                    //Show checkout success
                    $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . GatewayPayResponseCode::CREATED_CHECKOUT;

                    $wpwlOptions = $_POST['wpwlOptions'];

                    // Payment with card
                    $formData = [
                        'checkoutId' => $responseData->getId(),
                        'shopperResultUrl' => 'http://localhost/gateway-php-sdk/registration_token_payment.php',
                        'dataBrands' => [
                            GatewayPaySDK::PAYMENT_BRAND_VISA,
                            GatewayPaySDK::PAYMENT_BRAND_MASTERCARD,
                            GatewayPaySDK::PAYMENT_BRAND_AMEX
                        ],
                        'wpwlOptions' => $wpwlOptions
                    ];

                  echo $GatewayPaySDK->getCreateRegistrationPaymentForm($formData);                  
                } else {
                    $errorMessage = "The Prepare Checkout was not successful";
                }
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        } ?>
        <div class="custom-box box3" style="<?php echo (isset($_POST['submit'])) ? 'display: none;' : ''; ?>">

            <div class="row">
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <form action="#" method="POST">
                        <div class="form-group my-2">
                            <label for="id"> wpwlOptions:</label>
                            <textarea class="form-control" name="wpwlOptions" id="wpwlOptions" cols="30" rows="10">{
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
                        }</textarea>
                        </div>
                        <input type="submit" name="submit" class="btn btn-info" value="Checkout">
                    </form>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <?php

                //Show info Message
                if ($infoMessage !== "") { ?> <div class="alert alert-info">
                        <strong>Info!</strong>
                        <?php echo $infoMessage; ?>
                    </div>
                <?php
                }

                //Show Error Message
                if ($errorMessage !== "") { ?>
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> <?php echo $errorMessage; ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</body>

</html>