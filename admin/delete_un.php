<?php
require_once('../admin/dbcon.php');

$del_id=$_GET['del_id'];

// sql to delete a record
$sql = "Delete from unavailable where id = '".$del_id."'";
$stmet = $DB_con->prepare($sql);
if($stmet->execute()){
	header('location:profile.php?deleted');
}


?>