<?php
//include('app-header.php');
include '../admin/dbcon.php';

if(isset($_POST['btn-save']))
{
	$caption = $_POST['caption'];
    $select_date = $_POST['select_date'];
    $stdate = new DateTime($select_date);
    $udates = $stdate->format('Y-m-d');

        $stm = $DB_con->prepare('INSERT INTO unavailable (udates, caption)
            VALUES(:udates, :caption)');

          $stm->bindParam(':udates',$udates);
          $stm->bindParam(':caption',$caption);

          if($stm->execute()){
            header("location:profile.php?date_set");
          }
           
        
 } 

if(isset($_POST['btn_edit']))
{
    $edit = $_GET['edit_id']; 
    $select_date = $_POST['select_date'];
    $stdate = new DateTime($select_date);
    $udates = $stdate->format('Y-m-d');
    $caption = $_POST['caption'];

     $stmt = $DB_con->prepare("UPDATE unavailable SET 
        caption = '".$caption."',
        udates = '".$udates."'
        WHERE id=:id");
        $stmt->bindparam(":id",$edit);
        if($stmt->execute()){
            
            header("Location:profile.php?edited");

        }
            
}

if(isset($_POST['btn-c']))
{
    header("Location: profile.php");
}
?>


	 <form method='post'>
    
    <table class='table'>
         <?php
        if(isset($_GET['edit_id'])){
        $edit = $_GET['edit_id'];
        $query = $DB_con->prepare("SELECT * FROM unavailable where id = '".$edit."'");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $row=$query->fetch();

        echo"<label>Change date</label>";
} else {
        echo"<label>SET UNAVAILABLE DATES</label>";
}
?>  
        <label></label>
    
        <tr>

        
            <td><input type="text" class="form-control" name="select_date" id="select_date" placeholder="Set unavailable date" value="<?php if(isset($_GET['edit_id'])){ echo $row['udates']; } ?>" required></input></td>
            <td><input type="text" class="form-control" name="caption" placeholder="Caption" value="<?php if(isset($_GET['edit_id'])){ echo $row['caption']; } ?>" required></input></td>
         
             <?php if(isset($_GET['edit_id']))
{
    ?>
            <td colspan="2">
            <button type="submit" class="btn btn-submit" name="btn_edit">
            <i class="glyphicon glyphicon-ok"></i>
            </button>
              
             <button class="btn btn-submit" name="btn-c">
            <i class="glyphicon glyphicon-remove"></i>
            </button>
            </td>
<?php
        } else {
 ?>
            <td colspan="2">
            <button type="submit" class="btn btn-submit" name="btn-save">
            <span class="glyphicon glyphicon-plus"></span> Save
            </button>  
            
            </td>
<?php
        }
        
?>  
            
            
        </tr>
 
    </table>
   
</form>
     

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

        $("#select_date").datepicker({
            format: 'dd M yy',
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            minDate: '+1D',
            
            beforeShowDay: function(date) {
            var exclude = <?php echo json_encode($udates); ?>;
            var day = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [!~$.inArray(day, exclude) && (date.getDay() != 0)];
            }
        });

       
    });
</script> 