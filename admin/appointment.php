<?php
//include('app-header.php');
include '../admin/dbcon.php';


if(isset($_POST['btn-save']))
{   
    $set_id = $_GET['set_id'];
	$apptype = $_POST['title'];
    $select_date = $_POST['select_date'];
    $end_event = strtotime($_POST['end_date']);
    
    $date = new DateTime();
    $stdate = new DateTime($select_date);
    //$endate = new DateTime($end_date); 
    //get select $timestamp = strtotime('10:09') + 60*60; $time = date('H:i', $timestamp); echo $time;
    $dates = $stdate->format('Y-m-d');
    $created = $date->format('Y-m-d H:i:s');
    $start_event = $stdate->format('Y-m-d H:i:s');
    //$end_event = $endate->format('Y-m-d H:i:s');
    $end_event = date('Y-m-d H:i:s',$end_event);

        $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE id = :sid");
        $sthandler->bindParam(':sid', $set_id);
        $sthandler->execute();
        $row=$sthandler->fetch();

         $title = $apptype."- ".$row['lastname'].", ".$row['firstname'];
         $pid = $row['id'];  

        $stmt = $DB_con->prepare("SELECT * FROM events WHERE status = '1' AND patient_id = '".$pid."' AND dates = '".$dates."'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $stm = $DB_con->prepare("SELECT * FROM events where dates = '".$dates."'" );
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute();

        $stmp = $DB_con->prepare("SELECT * FROM events where status = '1' AND start_event = '".$start_event."'" );
        $stmp->setFetchMode(PDO::FETCH_ASSOC);
        $stmp->execute();

        $stt = $DB_con->prepare("SELECT * FROM events WHERE status = '1' AND patient_id = '".$pid."'");
        $stt->setFetchMode(PDO::FETCH_ASSOC);
        $stt->execute();

        if($stmt->rowCount() != 0 ) { 
             header("Location: patient.php?1");
        } 
        elseif ($stm->rowCount() >= 7 ){
            header("Location: patient.php?2");
        }
        elseif ($stmp->rowCount() > 0 ){
            header("Location: patient.php?3");
        }
        elseif (strtotime($dates) < time()) {
            header("Location: patient.php?4");
        }
        elseif ($stt->rowCount() > 0 ){
            header("Location: patient.php?1");
        }
        else {

        $stmt = $DB_con->prepare('INSERT INTO events
            (patient_id, title, dates, created, start_event, end_event)
            VALUES(:pid, :title, :dates, :created, :start_event, :end_event)');

          $stmt->bindParam(':pid',$pid);
          $stmt->bindParam(':title',$title);
          $stmt->bindParam(':dates',$dates);
          $stmt->bindParam(':created',$created);    
          $stmt->bindParam(':start_event',$start_event);
          $stmt->bindParam(':end_event',$end_event);

       
          if($stmt->execute()){
            
            header("Location: patient.php?inserted");


              $sql = "INSERT INTO log(user_name, change_time, action_made) 
                      VALUES ('".$title."',NOW(),'Add Appointment.')";
              $stt= $DB_con->prepare($sql);
              $stt->execute();   
      
           }
          // $que = "SELECT COUNT(*)FROM ;"
          //  new DateTime($_POST['select_date'],'Y-m-d');

        }
 } 

if(isset($_GET['btn-c']))
{ 
    header("location:patient.php");
}
?>

<div class="clearfix"></div>

<?php
if(isset($_GET['inserted']))
{
	?>
    <div class="container">
	<div class="alert alert-info">
    <strong>Done!</strong> Appointment was scheduled. 
    <?php header("refresh:2;url=index.php" ); ?>
	</div>
	</div>
    <?php
}

else if(isset($_GET['1']))
{
	?>
    <div class="container">
	<div class="alert alert-warning">
    <strong>Patient has pending appointment</strong> !
    <?php header("refresh:3;url=index.php" ); ?>
	</div>
	</div>
    <?php
}
else if(isset($_GET['2']))
{
    ?>
    <div class="container">
    <div class="alert alert-warning">
    <strong>Full Appointment. </strong> Please choose another date !
    <?php header("refresh:3;url=index.php" ); ?>
    </div>
    </div>
    <?php
}
else if(isset($_GET['3']))
{
    ?>
    <div class="container">
    <div class="alert alert-warning">
    <strong>Time Taken</strong> Please pick other time !
    </div>
    </div>
    <?php
}
else if(isset($_GET['4']))
{
    ?>
    <div class="container">
    <div class="alert alert-warning">
    <strong>Invalid start date.</strong> !
    <?php header("refresh:3;url=index.php" ); ?>
    </div>
    </div>
    <?php
}

?>


<div class="clearfix"></div><br />

<div class="container">

	 <form method='post'>
    
    <table class='table'>
        
        <label>Schedule an Appointment</label>

        <tr>

        
            <td><input type="text" class="form-control" name="select_date" id="select_date" placeholder="Choose date"  required></input></td>
            <td><select name="title" class="form-control" id="apptype" required="true">
                <option disabled="disabled" selected="selected">Choose Appointment</option>
                <option value="New">New Appointment</option>
                <option value="Recall">Recall Appointment</option>
                <option value="Procedure">Procedure</option>
            </select></td>
       
            <td><input type="text" name="end_date" id="end_date" class="form-control" placeholder="Just Click Done" readonly></td>

            <td colspan="2">
            
            <button type="submit" class="btn btn-submit" name="btn-save">
            <span class="glyphicon glyphicon-plus"></span> Save Appointment
            </button>  
            <a href="patient.php?btn-c"><button type="button" class="btn btn-submit">Cancel</button></a>
            
            </td>

        </tr>
 
    </table>
   
</form>
     
     
</div>

<?php 
require('../admin/dbcon.php');

$udates = array();
$utimes = array();

$sql = $DB_con->prepare("SELECT udates FROM unavailable");
$sql->setFetchMode(PDO::FETCH_ASSOC);
$sql->execute();
    while ($row=$sql->fetch()) {
        # code...
     $udates[] = $row["udates"];
    }

$sql = $DB_con->prepare("SELECT sched_time FROM sched");
$sql->setFetchMode(PDO::FETCH_ASSOC);
$sql->execute();
    while ($row=$sql->fetch()) {
        # code...
     $utimes[] = $row["sched_time"];
    }

?>
<script type="text/javascript">
    $(function(){

        $("#select_date").datetimepicker({
            format: 'dd M yy',
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            minDate: '+1D',
            
            hourMin: 8,
            hourMax: 16,
            
            beforeShowDay: function(date) {
            var exclude = <?php echo json_encode($udates); ?>;
            var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [!~$.inArray(day, exclude) && (date.getDay() != 0)];
            }
        });

        $("#apptype").change(function(){
        var selectedapp = $('#apptype').children("option:selected").val();
        
        var startDateTx = $('#select_date');
        var endDateTx = $('#end_date');

        if(selectedapp == "New"){
             
            $.timepicker.datetimeRange(
            startDateTx,
            endDateTx,
            {
                minInterval: (30 * 60 * 1000), // 1hr
                dateFormat: 'dd M yy', 
                timeFormat: 'HH:mm',
                start: {}, // start picker options
                end: {} // end picker options                   
            }); 
        } else if(selectedapp == "Recall"){
           
            $.timepicker.datetimeRange(
            startDateTx,
            endDateTx,
            {
                minInterval: (15 * 60 * 1000), // 15 * 60 * 1000
                dateFormat: 'dd M yy', 
                timeFormat: 'HH:mm',
                start: {}, // start picker options
                end: {} // end picker options                   
            }); 
        } else if(selectedapp == "Procedure"){
           
            $.timepicker.datetimeRange(
            startDateTx,
            endDateTx,
            {
                minInterval: (60 * 60 * 1000), // 15 * 60 * 1000
                dateFormat: 'dd M yy', 
                timeFormat: 'HH:mm',
                start: {}, // start picker options
                end: {} // end picker options                   
            }); 
        }


        });

        
    });
</script> 