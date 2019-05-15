<?php
require_once('../admin/dbcon.php');

$del_id=$_GET['del_id'];

// sql to delete a record
$sql = "Delete from services where id = '".$del_id."'";
$stmet = $DB_con->prepare($sql);
if($stmet->execute()){
	header('location:service.php?deleted');
}


?>