<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhook Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="custom-box box4">
        <div class="row m-5">
            <h1>Get Webhook Notification Response :</h1>
        <?php
        require_once 'vendor/autoload.php';

        use CatalystPay\Notification;
        // Example usage
        try {

            $http_body =$_POST;
            //    print_r($http_body);
           // Configured  CatalystPaySDK
           //$http_body = "0A3471C72D9BE49A8520F79C66BBD9A12FF9";
           $notification = new Notification($http_body);

           //Get decrypted message from webhook  
           echo $responseData = $notification->getDecryptedMessage($http_body);
        } catch (Exception $e) {
            echo $errorMessage = $e->getMessage();
        }
        ?>
       
        </div>
    </div>
</body>

</html>
 