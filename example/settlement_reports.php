<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;
// Start the session
session_start();

// check configuration
if(empty( $_SESSION["serverData"])){
    header("Location: index.php");
}


// Example usage
try {

    // Configured  CatalystPaySDK
    $token =  $_SESSION["serverData"]['token'];
    $entityId = $_SESSION["serverData"]['entityId'];
    $isProduction =  $_SESSION["serverData"]['isProduction'] =='false'?false:true ;
    $CatalystPaySDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    $resultTransactionById = $resultTransactionMerchant = $resultTransactionSpecifiedTimeFrame = $resultTransactionSpecifiedTimeFrame = $resultTransactionPagination = '';
    $title = '';
    $resultGetDetailLevel = $resultGetSummaryLevel = $resultGetDetailLevelWithPagination = [];
    // Get summary level information for a certain date and/or settlement currency
    if (isset($_POST['submit1'])) {

        $dataSettlementReportBySummary['dateFrom'] = $_POST['dateFrom'];
        $dataSettlementReportBySummary['dateTo'] = $_POST['dateTo'];

        // check if currency  
        if (isset($_POST['currency'])) {
            $dataSettlementReportBySummary['currency'] = $_POST['currency'];
        }

        $dataSettlementReportBySummary['testMode'] = CatalystPaySDK::TEST_MODE_INTERNAL;

        $settlementReportBySummary = $CatalystPaySDK->getSettlementReportBySummary($dataSettlementReportBySummary);
        $resultGetDetailLevel = $settlementReportBySummary->getApiResponse();
    }

    //Get further details for a particular aggregation id.
    if (isset($_POST['submit2'])) {
        $detailLevelData['id'] = $_POST['id']; // id 
        $detailLevelData['testMode'] = CatalystPaySDK::TEST_MODE_INTERNAL;
        // check if sortValue  
        if (isset($_POST['sortValue'])) {
            $detailLevelData['sortValue'] = $_POST['sortValue'];
        }
        // check if sortOrder  
        if (isset($_POST['sortOrder'])) {
            $detailLevelData['sortOrder'] = $_POST['sortOrder'];
        }
        $responseDetailLevelData = $CatalystPaySDK->getDetailLevelById($detailLevelData);
        $resultGetSummaryLevel = $responseDetailLevelData->getApiResponse();
    }

    // Get transactions for a specified time frame
    if (isset($_POST['submit3'])) {
        $detailLevelWithPaginationData['id'] = $_POST['id']; // id 
        // check if pageNo  
        if (isset($_POST['pageNo'])) {
            $detailLevelWithPaginationData['pageNo'] = $_POST['pageNo'];
        }
        $detailLevelWithPaginationData['testMode'] = CatalystPaySDK::TEST_MODE_INTERNAL;
        $settlementReportPagination = $CatalystPaySDK->getDetailLevelByIdWithPagination($detailLevelWithPaginationData);
        $resultGetDetailLevelWithPagination = $settlementReportPagination->getApiResponse();
    }
} catch (Exception $e) {
    echo  $e->getMessage();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settlement Report</title>
    <style>
        .custom-box {
            display: none;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
<?php include_once('header.php');?>
    <div class="row">
        <div class="col-md-12 my-5 d-flex justify-content-center align-items-center">
            <div class="form-group">
                <label><input type="radio" name="colorCheckbox" value="box1" <?php echo (isset($_POST['submit1'])) ? "checked" : ""; ?>>Get Summary Level</label>
                <label><input type="radio" name="colorCheckbox" value="box2" <?php echo (isset($_POST['submit2'])) ? "checked" : ""; ?>> Get Detail Level </label>
                <label><input type="radio" name="colorCheckbox" value="box3" <?php echo (isset($_POST['submit3'])) ? "checked" : ""; ?>> Get Detail Level with Pagination</label>

            </div>
        </div>
    </div>
    <div class="custom-box box1" style="<?php echo (isset($_POST['submit1'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="dateFrom" class="text-danger"> dateFrom*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="dateFrom" value="2015-08-01" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="dateTo" class="text-danger"> dateTo*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="dateTo" value="2015-08-02" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="currency"> currency:</label>
                        <input type="text" class="form-control" placeholder="Enter currency" name="currency" value="EUR">
                    </div>
                    <input type="submit" name="submit1" class="btn btn-primary" value="Get Summary Level">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get Summary Level Api Response :</h1>
            <?php print_r($resultGetDetailLevel); ?>
        </div>
    </div>
    <div class="custom-box box2" style="<?php echo (isset($_POST['submit2'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12  d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="id" class="text-danger"> id*:</label>
                        <input type="text" class="form-control" placeholder="Enter id" name="id" value="8a82944a4cc25ebf014cc2c782423202" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="sortValue"> sortValue:</label>
                        <input type="text" class="form-control" placeholder="SettlementTxDate" name="sortValue" value="SettlementTxDate">
                    </div>
                    <div class="form-group my-2">
                        <label for="sortOrder"> sortOrder:</label>
                        <input type="text" class="form-control" placeholder="ASC|DESC|asc|desc" name="sortOrder" value="">
                    </div>
                    <input type="submit" name="submit2" class="btn btn-secondary" value="Get Detail Level">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get Detail Level Api Response :</h1>
            <?php print_r($resultGetSummaryLevel); ?>
        </div>
    </div>
    <div class="custom-box box3" style="<?php echo (isset($_POST['submit3'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="id" class="text-danger"> id*:</label>
                        <input type="text" class="form-control" placeholder="Enter id" name="id" value="8a82944a4cc25ebf014cc2c782423202" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="reconciliationType"> reconciliationType :</label>
                        <input type="text" class="form-control" placeholder="SETTLED|FEE|CHARGEBACK|CHARGEBACK REVERSAL" name="reconciliationType" value="">
                    </div>
                    <div class="form-group my-2">
                        <label for="pageNo" class="text-danger"> pageNo*:</label>
                        <input type="text" class="form-control" placeholder="Enter pageNo" name="pageNo" value="2">
                    </div>
                    <input type="submit" name="submit3" class="btn btn-info" value="Get transactions for a specified time frame">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get Detail Level with Pagination Api Response:</h1>
            <?php print_r($resultGetDetailLevelWithPagination); ?>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                $(".custom-box").hide();
                $("." + inputValue).show();
            });
        });
    </script>
</body>

</html>