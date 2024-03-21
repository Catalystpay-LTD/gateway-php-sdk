<?php
require_once "config.php";
require_once 'vendor/autoload.php';
use CatalystPay\Notification;

 // Check webhook configuration like auth tag , iv etc 
  if(!empty($_SERVER)){
    $keyFromConfiguration="4FBB6197CD8D21651452D444B1AB5B3C2204F1308E1E1B45E0B6BEF50E64ABC9";
    $authTag = $_SERVER['HTTP_X_AUTHENTICATION_TAG'];
    $iv = $_SERVER['HTTP_X_INITIALIZATION_VECTOR'];
  }
  // Check webhook body
  if(!empty(file_get_contents("php://input"))) {
    $httpBody = file_get_contents("php://input");
    $notification = new Notification($keyFromConfiguration,$httpBody,$iv,$authTag);
  
    //Get decrypted message from webhook  
    $decrypted_data = $notification->getDecryptedMessage();
    // Prepare an insert statement
    $sql = "INSERT INTO hook_data (raw_data, decrypted_data) VALUES (?, ?)";
      
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $httpBody, $decrypted_data);
      
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          // Records created successfully. Redirect to landing page
          echo "Records created successfully.";
          exit();
      } else{
          echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }else{
    echo "No data Available";
}

?>