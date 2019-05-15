<?php  

 require('admin/dbcon.php');

if ( isset($_SESSION['username'])!="" ) {
    header("Location: client/");
    exit;
  }
if(isset($_POST["btn-login"]))  
{  
  if(empty($_POST["username"]) || empty($_POST["password"]))  
    {  
      $message = '<label>All fields are required</label>';  
    }  
    else 
  {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE username = :username AND password = :password");
    $sthandler->bindParam(':username', $username);
    $sthandler->bindParam(':password', $password);
    $sthandler->execute();

    $count = $sthandler->rowCount();  
        if($count > 0)  
        {  
           $_SESSION["username"] = $_POST["username"];  
           header("location:client/index.php?username=".$_SESSION["username"]);  
        }  
        else  
        {  
           $message = '<label>User Login Incorrect.</label>';  
        } 
    }
}

?>
 <!--Navigation bar-->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">DENT<span>APP</span></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <!--li><a href="index.php">Home</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="#footer">Contact</a></li-->
          <li class="btn-trial"><a href="#" data-target="#login" data-toggle="modal">Make an Appointment</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Navigation bar-->
  <!--Modal box-->
  <div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content no 1-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center form-title">Login</h4>
        </div>
        <div class="modal-body">

          <div class="login-box-body">
            <p class="login-box-msg">Sign in to set appointment</p>
            <div class="form-group">
              <form id="login-form" method="post">
                <div class="form-group has-feedback"> <span>
                <?php  
                if(isset($message))  
                {  
                     echo '<label>'.$message.'</label>';  
                }  
                ?>  </span>
                  <input class="form-control" placeholder="Username or Email" type="text" autocomplete="off" name="username"/>
                  <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
               
                  <input class="form-control" placeholder="Password" type="password" autocomplete="off" name="password" />
                  <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="checkbox icheck">
                    
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-green btn-block btn-flat" name="btn-login">Sign In</button>
                    <!-- onclick="userlogin()" -->
                  </div>
                  <center>
                    <a href="register/index.php">Not registered? Signup here</a>
                  </center>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!--/ Modal box-->
