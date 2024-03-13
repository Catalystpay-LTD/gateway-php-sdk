<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Configure Gateway PHP SDK Server Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<?php include_once('header.php');?>
    <div class="container">

        <?php

        // Example usage
        try {

            $infoMessage = $errorMessage = '';
     
            if (isset($_POST['submit'])) {                           
                // Set session variables
                $_SESSION["serverData"] =[
                    "token" => $_POST['token'],
                    "entityId"=> $_POST['entityId'],
                    "isProduction"=> isset($_POST['isProduction']) && $_POST['isProduction']==true  ?'true':'false',
                ];
                header("Location: copy_and_pay.php");                         
                $infoMessage = 'We have successfully configured the Gateway PHP SDK server details!';
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
        ?>
        <div class="container">
            <div class="row m-5">
                <h1> Configure Gateway PHP SDK Server Details:</h1>

            </div>
            <div class="row">
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <form action="#" method="POST">
                        <div class="form-group my-2">
                            <label for="token">Token:</label>
                            <input type="text" class="form-control" placeholder="Enter token" name="token" value="<?php echo isset($_SESSION["serverData"]['token'])?$_SESSION["serverData"]['token']:'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='?>">
                        </div>
                        <div class="form-group my-2">
                            <label for="entityId"> Entity Id :</label>
                            <input type="text" class="form-control" placeholder="Enter entity id" name="entityId" value="<?php echo isset($_SESSION["serverData"]['entityId'])?$_SESSION["serverData"]['entityId']:'8a8294174b7ecb28014b9699220015ca';?>">
                        </div>
                        <div class="form-group my-2">
                        <div class="checkbox">
                            <label><input type="checkbox" name="isProduction" value="true" <?php echo isset($_SESSION["serverData"]['isProduction'])?$_SESSION["serverData"]['isProduction']:'checked';?>> Is Production</label>
                        </div>
                    </div>
                         
                        <input type="submit" name="submit" class="btn btn-info" value="Checkout">
                    </form>
                </div>
            </div>

        </div>
        <div class="container" style="margin-top:10px">
            <div class="row" >
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
    </div>
</body>

</html>