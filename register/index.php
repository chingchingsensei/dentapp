<?php

  error_reporting( ~E_NOTICE );
  
  require_once '../admin/dbcon.php';
  
  if(isset($_POST['btn_save_updates']))
  {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
  
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // validate data
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errMSG = "Enter a  valid email";
    }

    // Password length
    if (strlen($password) <= 6){
        $errMSG = "Choose a password longer then 6 character";
    }


    // if no error occured, continue ....
    if(!isset($errMSG)) 
    {
        $sthandler = $DB_con->prepare("SELECT username FROM patient WHERE username = :username");
        $sthandler->bindParam(':username', $username);
        $sthandler->execute();

        if($sthandler->rowCount() > 0){
            $errMSG = "User Name exists";
        } 
        else 
        {
          $stmt = $DB_con->prepare('INSERT INTO patient
            (lastname, firstname, contact, email, address, type, username, password)
            VALUES(:lastname, :firstname, :contact, :email, :address, :type, :username, :password)');

          $stmt->bindParam(':lastname',$lastname);
          $stmt->bindParam(':firstname',$firstname);
          
          $stmt->bindParam(':contact',$contact);
          $stmt->bindParam(':email',$email);
          $stmt->bindParam(':address',$address);
          $stmt->bindParam(':type',$type);
          $stmt->bindParam(':username',$username);
          $stmt->bindParam(':password',md5($password)); 
       
          if($stmt->execute()){
        
            header("location:signup.php");
            }
        }
    }
    else{
        $errMSG;
    }
    

    
      $sql = "INSERT INTO log(user_name, change_time, action_made) 
              VALUES ('".$firstname." ".$lastname."',NOW(),'new Client added.')";
      $stmt= $DB_con->prepare($sql);
      $stmt->execute();    
              
  }
  
?>

 <?php include('header.php'); ?>  

<body>
                
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">  

        <div class="wrapper wrapper--w790">
             
            <div class="card card-5">
            
                <div class="card-heading">
                    <h2 class="title">Register here </h2>
                </div>
                <!--lastname, :firstname, :mi, :contact, :email, :address, :type, :idnumber, :position-->
                <div class="card-body">
                     
                     <?php
                            if(isset($errMSG))
                            {
                                  ?><h3 style="color: red;">
                                  <div class="name">
                                      <?php echo $errMSG; ?> !
                                  </div></h3>
                                  <?php
                            }
                     ?>
                    <form method="POST">
                        <div class="form-row m-b-55">
                            <div class="name">Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="firstname" required>
                                            <label class="label--desc">first name</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="lastname" required>
                                            <label class="label--desc">last name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Phone</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="contact" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Email</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="email" name="email" id="email" required>
                                    <label class="label--desc"><span id="eavailability"></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Address</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="address" required>
                                </div>
                            </div>
                        </div>
                        
                        
                      
                        <div class="form-row">
                            <div class="name">Client Type</div>
                            <div class="value">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="type">
                                            <option disabled="disabled" selected="selected" required>Choose option</option>
                                            <option>Student</option>
                                            <option>Employee</option>
                                            <option>Guest</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row m-b-55">
                        <div class="name">Account</div>
                        <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="username" id="username" placeholder="Facebook Username" required>
                                            <label class="label--desc"><span id="availability"></span></label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc"> 
                                            <input class="input--style-5" type="password" name="password" id="password" placeholder="Password" required>
                                            <label class="label--desc"><span id="pavailability"></span></label>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <div align="right">
                            <button class="btn btn--radius-2 btn--teal" name="btn_save_updates" type="submit" id="register">Register</button>
                            <button class="btn btn--radius-2 btn--teal" name="clear" type="button" id="clear">Clear</button>
                            <a href="../"><button class="btn btn--radius-2 btn--teal" type="button">Cancel
                            </button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?> 

<script>  
 $(document).ready(function(){  
   $('#username').blur(function(){

     var username = $(this).val();

     $.ajax({
      url:'check.php',
      method:"POST",
      data:{username:username},
      success:function(data)
      {
       if(data != '0')
       {
        $('#availability').html('<span class="text-danger" style="color:red;">Enter a unique username.</span>');
        $('#register').attr("disabled", true);
       }
       else if(username == "")
       {
        $('#availability').html('<span class="text-danger" style="color:orange;">Username is empty.</span>');
        $('#register').attr("disabled", true);
       }
       else
       {
        $('#availability').html('<span class="text-success" style="color:green;">Username is unique.</span>');
        $('#register').attr("disabled", false);
       }
      }
     })

  });

   $('#email').blur(function(){

     var email = $(this).val();

     $.ajax({
      url:'check.php',
      method:"POST",
      data:{email:email},
      success:function(data)
      {
       if(data != '0')
       {
        $('#eavailability').html('<span class="text-danger" style="color:red;">Email already exist! Try another one</span>');
        $('#register').attr("disabled", true);
       }
       else if(email == "")
       {
        $('#eavailability').html('<span class="text-danger" style="color:orange;"> Type your e-mail address.</span>');
        $('#register').attr("disabled", true);
       }
       else
       {
        $('#eavailability').html('<span class="text-success" style="color:green;"> Email is available.</span>');
        $('#register').attr("disabled", false);
       }
      }
     })

  });

    $('#password').keyup(function(){

     var password = $(this).val();

       if(password.length <= 6)
       {
        $('#pavailability').html('<span class="text-danger" style="color:red;">Enter 7 characters or more.</span>');
        $('#register').attr("disabled", true);
       }
       else
       {
        $('#pavailability').html('<span class="text-success" style="color:green;">Remember this password.</span>');
        $('#register').attr("disabled", false);
       }
      });


    $('#clear').click(function(){
    $('input[type="text"]').val("");
    });

 });  
 
 </script>