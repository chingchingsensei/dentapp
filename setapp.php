<?php

	require  'src/medoo.php';
	 
	// Using Medoo namespace
	use Medoo\Medoo;
	 
	$database = new Medoo([
		// required
		'database_type' => 'mysql',
		'database_name' => 'u655308956_dent',
		'server' => 'localhost',
		'username' => 'u655308956_tutor',
		'password' => 'www.g2ix.com',
	 
		// [optional]
		//'charset' => 'utf8',
		//'port' => 3306,
	 
		// [optional] Table prefix
		//'prefix' => 'PREFIX_',
	 
		// [optional] Enable logging (Logging is disabled by default for better performance)
		'logging' => true,
	 
		// [optional] MySQL socket (shouldn't be used with server and port)
		'socket' => '/tmp/mysql.sock',
	 
		// [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
		'option' => [
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		],
	 
		// [optional] Medoo will execute those commands after connected to the database for initialization
		'command' => [
			'SET SQL_MODE=ANSI_QUOTES'
		]
	]);
	
	$messenger_id = $_GET['messenger_user_id'];
//	$first_name = $_GET['first_name'];
//	$last_name = $_GET['last_name'];
	$apptype = $_GET['apptype'];
	$username = $_GET['username'];
//	$user_type = $_GET['user_type'];
//	$source = $_GET['biz_name'];
//	$email = $_GET['email_address'];
//	$phone = $_GET['phone_number'];

	$start_date = $_GET['start_date'];
	$start_event = strtotime($start_date);
	$start_event = date('Y-m-d H:i:s',$start_event);

    $dates = strtotime($start_date);
	$dates = date('Y-m-d',$dates);
	$regdate = date("Y-m-d");
//	$title = print($apptype."-".$last_name.", ".$first_name); 
	
	if($_GET['apptype']=="New"){
	$tim = new DateTime($start_event);
	$tim->add(new DateInterval('PT' . 30 . 'M'));
	$end_event = $tim->format('Y-m-d H:i');
	}

	if($_GET['apptype']=="Recall"){
	$tim = new DateTime($start_event);
	$tim->add(new DateInterval('PT' . 15 . 'M'));
	$end_event = $tim->format('Y-m-d H:i');
	}
    require('admin/dbcon.php');
    $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE username = :username");
    $sthandler->bindParam(':username', $username);
    $sthandler->execute();
    $row=$sthandler->fetch();

     $title = $apptype."- ".$row['lastname'].", ".$row['firstname'];
     $pid = $row['id'];  
     $usern = $row['username'];
    
    if($username === $usern){
	$database->insert("events", [
		"title" => $title,
		"patient_id" => $pid,
		"username" => $username,
		
		"start_event" => $start_event,
		"end_event" => $end_event,
		"created" => $regdate,
		"dates" => $dates,
		"messenger_id" => $messenger_id
	]);
	
    }
    else {
        echo 'Register';  
    }

?>