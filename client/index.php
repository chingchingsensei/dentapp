<?php
include 'app-header.php'; 
include_once '../admin/dbcon.php';


      $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE username = :username");
        $sthandler->bindParam(':username', $_SESSION['username']);
        $sthandler->execute();
        $trow=$sthandler->fetch();

        $pid = $trow['id'];


include 'app-nav.php';
include 'appointment.php'; 
?>

<div class="clearfix"></div>

<div class="">

<div class="container">
	 <table class='table table-bordered table-responsive'>
     <tr>
     <th>Title</th>
     <th>Date</th>
     <th>Time Start</th>
     <th>Time End</th>
     <th>Appointment Status</th>
    
     </tr>
     
    <?php 
        $limit = 3;

        $sql = $DB_con->prepare("SELECT * FROM events where patient_id = '".$pid."'");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        $total_results = $sql->rowCount();
        $total_pages = ceil($total_results/$limit);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else{
            $page = $_GET['page'];
        }

        $starting_limit = ($page-1)*$limit;

        $show  = "SELECT * FROM events where patient_id = '".$pid."' ORDER BY status DESC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($show);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr><td>".$row['title']."</td>";
                    echo "<td>".date("M d Y", strtotime($row['dates']))."</td>";
                    echo "<td>".date("h.i A", strtotime($row['start_event']))."</td>";
                    echo "<td>".date("h.i A", strtotime($row['end_event']))."</td>";
                    ?>

                    <td>
                    <?php
                    $status = $row['status'];
                    ($status == '1')?print("<i>".$row['changes']."</i> | <a href='app-cancel.php?cancel_id=".$row['id']."&pid=".$row['patient_id']."'><i class='glyphicon glyphicon-remove-circle'></i><small> Cancel </small></a> | <a href='index.php?mod_id=".$row['id']."'><i class='glyphicon glyphicon-edit'></i><small> Reschedule </small></a>"):print("<a>".$row['changes']."</a>"); ?></a>
                    </td>
                    <?php
                    }
                   ?>

                </tr>
                    
                    
               
    <label>HISTORY</label>
    <tr>
        <td colspan="5" align="center">
            
                    <?php
                    for ($page=1; $page <= $total_pages ; $page++):?>

                    <a href='<?php echo "?page=$page"; ?>' class="btn btn-green"><?php  echo $page; ?>
                     </a>

                    <?php endfor; ?>
        </td>
    </tr>
 
</table>
   
</div>
</div>


<?php include('app-footer.php'); ?>
