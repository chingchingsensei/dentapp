<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

include'dbcon.php';
  if(isset($_POST['btn-user']))
{
    $u_id = $_GET['user_id'];
    $username = $_POST['txt_uname'];
    $email = $_POST['txt_email'];
    $password = $_POST['txt_password'];
    $user_rec = $_POST['txt_rec'];


     $stt = $DB_con->prepare("UPDATE users SET 
        user_name = '".$username."',
        user_email = '".$email."',
        user_pass = '".md5($password)."',
        user_recovery = '".$user_rec."'
        WHERE user_id=:id");
        $stt->bindparam(":id",$u_id);
       if($stt->execute()){
            
            header("Location:profiledoc.php?updated");

        }
}

  include('header.php');
  include('nav.php');

?>


<div class="signin-form">

  <div class="container">
     
        <div class="col-md-3">
       <form class="form-signin" method="post" id="login-form">
        
        <div class="form-group">
        <input type="text" class="form-control" name="txt_uname" value="<?php echo $userRow['user_name']; ?>" />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="text" class="form-control" name="txt_email" value="<?php echo $userRow['user_email']; ?>" />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
        </div>

        <div class="form-group">
        <input type="text" class="form-control" name="txt_rec" value="<?php echo $userRow['user_recovery']; ?>" />
        <span id="check-e"></span>
        </div>
       
      <hr />
        
        <div class="form-group">
            <button type="submit" name="btn-user" class="btn btn-submit">
                  <i class="glyphicon glyphicon-send"></i> &nbsp; UPDATE PROFILE
            </button>
        </div>  
        <br />
            
      </form>
    </div>
    </div>
    
</div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>