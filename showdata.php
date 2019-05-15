<?php
// Connection data (server_address, database, name, poassword)
$hostdb = 'localhost';
$namedb = 'u655308956_dent';
$userdb = 'u655308956_tutor';
$passdb = 'www.g2ix.com';


  // Connect and create the PDO object
  $db = new PDO("mysql:host=$hostdb; dbname=$namedb", $userdb, $passdb);
  $messenger_id = $_GET['messenger_user_id'];
  $username = $_GET['username'];
 // $dates = $_GET['dates'];
 // $datess = strtotime($dates);
 // $datess = date('Y-m-d',$datess);
    
$stmt = $db->prepare("select * from events where username = '".$username."' AND status='1' OR messenger_id='".$messenger_id."'");
$stmt->execute();
$myarr=array();
while($data=$stmt->fetch()){
    $myarr[]=$data;
    
}

    
  // echo json_encode($myarr);
   
   $file = fopen('data.json' ,'w');
   fwrite($file, json_encode($myarr, JSON_FORCE_OBJECT));
   
   $url = 'data.json'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$characters = json_decode($data); // decode the JSON feed

//echo $characters[0]->first_name;
//echo $characters[0]->last_name;
//echo $characters[0]->email_address;
//echo json_encode($data);

  // Define and perform the SQL SELECT query
  //$messenger_id = $_GET['messenger_user_id'];
  //$sql = "SELECT * FROM `users` WHERE `messenger_id` = $messenger_id";
  //$result = $conn->query($sql);
  

?>
