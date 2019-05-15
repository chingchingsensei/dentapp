<?php
session_start();
  
  require_once 'class.user.php';
  $session = new USER();
 
  if(!$session->is_loggedin())
  {
    
    $session->redirect('../');
  }
	
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

include('header.php');
include('nav.php');
include_once '../admin/dbcon.php';

  $result= $DB_con->prepare("SELECT count(*) as total from events where status='1'");
  $result->execute();
  $data=$result->fetch(PDO::FETCH_ASSOC);
 
if(isset($_GET['noshow_id']))
{
    $nid = $_GET['noshow_id']; 
     $stmt = $DB_con->prepare("UPDATE events SET status = '0', changes = 'NO_SHOW' WHERE id=:id");
        $stmt->bindparam(":id",$nid);
        if($stmt->execute()){
          header("location:index.php");
        }
}
else if(isset($_GET['done_id']))
{
    $did = $_GET['done_id']; 
     $stt = $DB_con->prepare("UPDATE events SET status = '0', changes = 'Done' WHERE id=:id");
        $stt->bindparam(":id",$did);
         if($stt->execute()){
            header("location:index.php");
          }
}


?>

<div class = "container">
  

<div class="clearfix"></div>
 
  <div class="row-fluid">
      <div><h4>Total Pending Appointments:<?php echo $data['total']; ?></h4></div></br>
    <table class="table table-responsive" style='display:inline-block'>
      <td><h4>SEARCH:</h4></td>
      <td><input type="text" name="search" id="search" class="form-control" placeholder="Please search here"></td>
      <td>
            <select class="form-control" id='filterText' style='display:inline-block' onchange='filterText()'>
                <option selected></option>
                <option value='Done'>Done</option>
                <option value='NO_SHOW'>No Show</option>
                <option value='Cancelled'>Cancelled</option>
                <option value='Pending'>Pending</option>
              </select>
      </td>
  </table>
  </div>
  
   <table class='table table-bordered table-responsive' id='myTable'>
     <tr class="myHead">
     <th>Title</th>
     <th>Date</th>
     <th>Time Start</th>
     <th>Time End</th>
     <th>Appointment Status</th>
    
     </tr>
     
    <?php 
        $limit = 10;
        include_once '../admin/dbcon.php';
        $sql = $DB_con->prepare("SELECT * FROM events");
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

        $show  = "SELECT * FROM events ORDER BY status DESC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($show);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr class='content'><td>".$row['title']."</td>";
                    echo "<td>".date("M d Y", strtotime($row['start_event']))."</td>";
                    echo "<td>".date("h.i A", strtotime($row['start_event']))."</td>";
                    echo "<td>".date("h.i A", strtotime($row['end_event']))."</td>";
                    ?>

                    <td>
                    <?php
                    $status = $row['status'];
                    ($status == '1')?print("<i>".$row['changes']."</i> 
                    | <a href='home.php?done_id=".$row['id']."'>DONE</a> 
                    | <a href='home.php?noshow_id=".$row['id']."'>NO SHOW</a>")
                    :print("<a>".$row['changes']."</a>"); ?></a>
                    </td>
                    <?php
                    }
                   ?>

                </tr>
                    
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

<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
function filterText()
  {  
    var rex = new RegExp($('#filterText').val());
    if(rex =="/all/"){clearFilter()}else{
      $('.content').hide();
      $('.content').filter(function() {
      return rex.test($(this).text());
      }).show();
  }
  }
  
function clearFilter()
  {
    $('.filterText').val('');
    $('.content').show();
  }

$('#search').on('keyup', function() {
  var value = $(this).val();
  var patt = new RegExp(value, "i");

  $('#myTable').find('tr').each(function() {
    if (!($(this).find('td').text().search(patt) >= 0)) {
      $(this).not('.myHead').hide();
    }
    if (($(this).find('td').text().search(patt) >= 0)) {
      $(this).show();
    }
  });
});


</script>
</body>
</html>