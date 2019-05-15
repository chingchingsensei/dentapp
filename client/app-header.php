 <?php
 session_start();  
 
 
if( !isset($_SESSION['username']) ) {
    header("Location: ../");
    exit;
}
  
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tibiao-Dental</title>

	 <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	 <link rel="stylesheet" type="text/css" href="select2/select2.min.css">
	 <link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker-addon.css">
	 <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css">
	 <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.min.css">
	

	 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	 <link href="../css/style.css" rel="stylesheet" media="screen">
	 <link rel="icon" href="../img/logo.png">
	<script src="js/jquery-1.12.4.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery-ui-timepicker-addon.js"></script>
	
	

</head>
<body>