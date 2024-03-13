<?php 
$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
//echo "The current page name is: ".$curPageName;  
?>
<nav class="navbar navbar-static-top navbar-inverse bg-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbarSupportedContent">    
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>   
      </button>
      <a class="navbar-brand " href="index.php">CatalystPay SDK Configuration </a>
    </div>
    <div class="collapse navbar-collapse navbarSupportedContent">
      <ul class="nav navbar-nav navbar-right">
      <li class="nav-item <?php echo $curPageName =='copy_and_pay.php' ?'active':''?>">
        <a class="nav-link" href="copy_and_pay.php">CopyAndPay <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php echo $curPageName =='registration_token.php' ?'active':''?>">
        <a class="nav-link" href="registration_token.php">Recurring Payments via COPYandPAY</a>
      </li>
      <li class="nav-item <?php echo $curPageName =='transaction_reports.php' ?'active':''?>">
        <a class="nav-link" href="transaction_reports.php">Transaction Report</a>
      </li>
      <li class="nav-item <?php echo $curPageName =='settlement_reports.php' ?'active':''?>">
        <a class="nav-link" href="settlement_reports.php">Settlement Report</a>
      </li>
      <li class="nav-item <?php echo $curPageName =='backoffice_operations.php' ?'active':''?>">
        <a class="nav-link" href="backoffice_operations.php">Backoffice operations</a>
      </li>
      
    </ul>
    </div>
  </div>
</nav>