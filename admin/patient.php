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

if(isset($_GET['set_id'])){
  include 'appointment.php';
}
 
?>

<div class = "container">
  

<div class="clearfix"></div>
 
  <div class="row-fluid">
    <table class="table table-responsive" style='display:inline-block'>
      <td><h4>SEARCH:</h4></td>
      <td><input type="text" name="search" id="search" class="form-control" placeholder="Please search here"></td>
  </table>
  </div>
  
   <table class='table table-bordered table-responsive' id='myTable'>
     <tr class="myHead">
     <th>Name</th>
     <th>Username</th>
     <th>Contact</th>
     <th>Email</th>
     <th>Address</th>
     <th>Manage</th>
    
     </tr>
     
    <?php 
        $limit = 10;
        include_once '../admin/dbcon.php';
        $sql = $DB_con->prepare("SELECT * FROM patient");
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

        $show  = "SELECT * FROM patient ORDER BY lastname ASC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($show);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr class='content'><td>".$row['lastname'].", ".$row['firstname']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['contact']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['address']."</td>";
                    ?>

                    <td colspan="2">
                  <?php if(!isset($_GET['set_id'])){ ?>
                    <a href="patient.php?set_id=<?php echo $row['id']; ?>" class="btn btn-submit" name="btn_set">
                      <i class="glyphicon glyphicon-plus"></i><small>Set Appointment</small>
                    </a>
                  <?php } ?>
                    </td>
                    <?php
                    }
                   ?>

                </tr>
                    
    <tr>
        <td colspan="6" align="center">
            
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