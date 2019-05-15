<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  include('header.php');
  include('nav.php');
?>

	<div class="clearfix"></div>
  <div class="container">

    <div class="panel panel-default">
      <div class="panel-body">
      <?php include('services.php'); ?>
    <table class='table table-bordered table-responsive'>
     <tr>
      <th>Dental Service</th>
     <th>Category</th>
     <th>Fee Schedule</th>
     <th colspan="2" align="center">Actions</th>
     </tr>
     
    <?php 
        $limit = 6;

        $sq = $DB_con->prepare("SELECT * FROM services");
        $sq->setFetchMode(PDO::FETCH_ASSOC);
        $sq->execute();
        $total_result = $sq->rowCount();
        $total_page = ceil($total_result/$limit);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else{
            $page = $_GET['page'];
        }

        $starting_limit = ($page-1)*$limit;

        $sw  = "SELECT * FROM services ORDER BY category DESC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($sw);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr><td>".$row['service']."</td>";;
                    echo "<td>".$row['category']."</td>";
                    echo "<td>".$row['fee']."</td>";
                    
                    ?>

                    <td align="center">
                    <a href="delete_se.php?del_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
                      <i class='glyphicon glyphicon-remove-circle'></i>
                      </a>
                    </td>
                    <td align="center">
                    <a href='service.php?se_id=<?php echo $row['id']; ?>'>
                      <i class='glyphicon glyphicon-edit'></i></a>
                    </td>
                   

                </tr>
                     <?php
                    }
                   ?>
                    
               
    <label>Dental Services</label>
    <tr>
        <td colspan="5" align="center">
            
                    <?php
                    for ($page=1; $page <= $total_page ; $page++):?>

                    <a href='<?php echo "?page=$page"; ?>' class="btn btn-green"><?php  echo $page; ?>
                     </a>

                    <?php endfor; ?>
        </td>
    </tr>
 
    </table>
    </div>
  </div>
</div>


<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>