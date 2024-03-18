<?php
require_once "config.php";
require_once 'vendor/autoload.php';
use CatalystPay\Notification;

  if(!empty(file_get_contents("php://input"))) {
    $raw_data = file_get_contents("php://input");
    if(!empty($raw_data))
    {
      //$http_body = "0A3471C72D9BE49A8520F79C66BBD9A12FF9";
      $http_body = file_get_contents("php://input");
      $notification = new Notification($raw_data);
   
      //Get decrypted message from webhook  
      $decrypted_data = $notification->getDecryptedMessage($raw_data);

      // Prepare an insert statement
      $sql = "INSERT INTO hook_data (raw_data, decrypted_data) VALUES (?, ?)";
       
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "ss", $raw_data, $decrypted_data);
          
          // Set parameters
          $raw_data = $raw_data;
          $decrypted_data = $decrypted_data;
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // Records created successfully. Redirect to landing page
              echo "Records created successfully.";
              exit();
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
        }
    }
  }else{
    echo "No data Available";
}

?>