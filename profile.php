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

      <?php include('setunavaible.php'); ?>
    <table class='table table-bordered table-responsive'>
     <tr>
      <th>Date</th>
     <th>Caption</th>
     <th colspan="2" align="center">Actions</th>
     </tr>
     
    <?php 
        $limit = 3;

        $sql = $DB_con->prepare("SELECT * FROM unavailable");
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

        $show  = "SELECT * FROM unavailable ORDER BY udates DESC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($show);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr><td>".date("M d Y", strtotime($row['udates']))."</td>";
                    echo "<td>".$row['caption']."</td>";
                    
                    
                    ?>

                    <td align="center">
                    <a href="delete_un.php?del_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
                      <i class='glyphicon glyphicon-remove-circle'></i>
                      </a>
                    </td>
                    <td align="center">
                    <a href='profile.php?edit_id=<?php echo $row['id']; ?>'>
                      <i class='glyphicon glyphicon-edit'></i></a>
                    </td>
                    <?php
                    }
                   ?>

                </tr>
                    
                    
               
    <label>Unavailable Dates</label>
    <tr>
        <td colspan="4" align="center">
            
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

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>