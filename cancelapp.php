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
  //Query 2: Attempt to update the user's profile.
  // Connect and create the PDO object
  // changes data in "name" si "link" colummns, where id=3
  $sql = "UPDATE `events` SET status='0', `changes`='Cancelled Appointment' WHERE `messenger_id`=$messenger_id;
  
  $count = $db->exec($sql);

  $conn = null;        // Disconnect

// If the query is succesfully performed ($count not false)
if($count !== false) echo 'Affected rows : '. $count;       // Shows the number of affected rows

?>


