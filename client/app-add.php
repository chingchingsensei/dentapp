<?php


  error_reporting( ~E_NOTICE );
 
  require_once '../admin/dbcon.php';
  
  if(isset($_POST['btn_app']))
  {

    $apptype = $_POST['title'];
    $select_date = $_POST['select_date'];
    $end_date = $_POST['end_date'];
    $date = new DateTime();
    $stdate = new DateTime($select_date);
    $endate = new DateTime($end_date); 
    //get select $timestamp = strtotime('10:09') + 60*60; $time = date('H:i', $timestamp); echo $time;
    $dates = $stdate->format('Y-m-d');
    $created = $date->format('Y-m-d H:i:s');
    $start_event = $stdate->format('Y-m-d H:i:s');
    $end_event = $endate->format('Y-m-d H:i:s');


        $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE username = :username");
        $sthandler->bindParam(':username', $_SESSION['username']);
        $sthandler->execute();
        $row=$sthandler->fetch();

		 $title = $apptype."- ".$row['lastname'].", ".$row['firstname'];
		 $pid = $row['id'];

        $stmt = $DB_con->prepare("SELECT * FROM events WHERE patient_id = '".$pid."' AND dates = '".$dates."'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $stm = $DB_con->prepare("SELECT * FROM events where dates = ".$dates );
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute();

        if($stmt->rowCount() != 0 && $stm->rowCount() >= 8 ) { 
        	?>
        	<script>
        		alert("Multiple appointment on the same day is NOT allowed. Set Appointment on other day. ");
        	</script>
       	<?php
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
          	?>
	        <script>
	            alert("Appointment Successfully Added..");
	        </script> 
	        <?php
	       }
   		}
 }
 else {
 	header('location:index.php');
 }
    
    
      $sql = "INSERT INTO log(user_name, change_time, action_made) 
              VALUES ('".$firstname." ".$lastname."',NOW(),'Add Appointment.')";
      $stmt= $DB_con->prepare($sql);
      $stmt->execute();   

 
include'app-header.php'; 
include 'app-nav.php';     
?>


<div class="page-wrapper p-t-30 p-b-100">
   <div class="wrapper wrapper--w680">
   	<h1>Add Appointment</h1>
   	<fieldset style="width: 300px;height:700px">
      <div class="card card-4">
        	<div class="card-body"> 
		        <form method="POST" class="mc-trial">

				<div class="form-group">
		          <div class="controls">
		          	<div class="rs-select2__arrow select--no-search">
                                    <select name="title" class="form-control" id="apptype">
                                        <option disabled="disabled" selected="selected">Choose Appointment</option>
                                        <option value="New">New Appointment</option>
                                        <option value="Recall">Recall Appointment</option>
                                    </select>
                         <div class="select-dropdown"></div>

                    </div>
                 </div>
             	</div>  
             	
		        <div class="form-group">
		          <div class="controls">
		          	<input class="form-control" type="text" name="select_date" id="select_date" placeholder="Choose date">		 
		          </div>
		        </div>
		        <?php
             		if($title=='New') {
				      $end_date = strtotime($select_date) + 30*60*1000;
				    }
             	?>
		        <div class="form-group">
		          <div class="controls" >    
                    <input class="form-control" type="text" value="<?php echo (isset($end_date))?$end_date:'';?>" name="end_date" placeholder="Duration" readonly/>				  
		        	</div>
		        </div>

		        <div class="form-group">
				<div class="controls">
		            <button style="margin-top: 10px;" name="btn_app" type="submit" class="btn btn-block btn-submit">
		            Submit <i class="fa fa-arrow-right"></i></button>
		        </div>
		        </div>
				</form>
			</div>
		</div>
		</fieldset>
		<br>
	</div>
</div>

<?php
include('app-footer.php');
require('../admin/dbcon.php');

$udates = array();

$sql = $DB_con->prepare("SELECT udates FROM unavailable");
$sql->setFetchMode(PDO::FETCH_ASSOC);
$sql->execute();
	while ($row=$sql->fetch()) {
		# code...
	 $udates[] = $row["udates"];
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
			minDate: '-1D',
			maxDate: '+3M',
			hourMin: 8,
			hourMax: 16,
			
			beforeShowDay: function(date) {
			var exclude = <?php echo json_encode($udates); ?>;
		    var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
		    return [!~$.inArray(day, exclude) ]; //&& (date.getDay() != 0)
			}
		});
		/*
		$("#end_date").change(function(){
        var selectedapp = $('#apptype').children("option:selected").val();
        var startDateTx = $('#select_date');
		var endDateTx = $('#end_date');

		if(selectedapp === "New"){
			endDateTx = new Date(startDateTx) + 30*60*1000;
			endDateTx.getTime();
		}
		else if(selectedapp === "Recall"){
			endDateTx = new Date(startDateTx) + 15*60*1000;
			endDateTx.getTime();
		}


    	});
*/
		
	});
</script> 

