<?php
include 'app-header.php'; 
include_once '../admin/dbcon.php';
        

if(isset($_POST['btn-del']))
{
	$id = $_GET['cancel_id']; 
    $reason = $_POST['reason'];

        $query = $DB_con->prepare("SELECT * FROM events where id = '".$id."'");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $row=$query->fetch();
        $pid = $row["patient_id"];
        $title = $row["title"];
        $dates = $row["start_event"];

        $stmt = $DB_con->prepare("UPDATE events SET status = '0', changes = 'Cancelled Appointment' WHERE id=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();

        $sql = "INSERT INTO cancelled(app_id, title, dates, canc, reason) 
                VALUES ('".$id."','".$title."','".$dates."',NOW(),'".$reason."')";
              $stt= $DB_con->prepare($sql);
              $stt->execute(); 

	header("Location: index.php?cancelled");	
}

?>

<div class="clearfix"></div>

<div class="container">

	<?php
	if(isset($_GET['cancelled']))
	{
		?>
        <div class="alert alert-success">
    	<strong>Success!</strong> ... 
		</div>
        <?php
	}
	else
	{
		?>
        <div class="alert alert-warning">
    	<strong>Sure</strong> to cancel the appointment ? 
		</div>
        <?php
	}
	?>	
</div>

<div class="container">
<p>
<?php
if(isset($_GET['cancel_id']))
{
    $pid = $_GET['pid'];
    $stm = $DB_con->prepare("SELECT * FROM events where changes = 'Cancelled Appointment' AND patient_id='".$pid."'" );
    $stm->setFetchMode(PDO::FETCH_ASSOC);
    $stm->execute();

    if($stm->rowCount() >= 30)
    {
        header("Location: index.php?6");
    } 
    else {

	?>
  	<form method="post">
    <label>Please state your reason</label>
    <input type="text" class="form-control" name="reason" id="reason" required>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" /><br />
    <button class="btn btn-large btn-submit" type="submit" name="btn-del"><i class="glyphicon glyphicon-check"></i> &nbsp; YES</button>
    <a href="index.php" class="btn btn-large btn-submit"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
    </form>  
	<?php
    }
}
else
{
	?>
    <a href="index.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
    <?php
}
?>
</p>
</div>	
