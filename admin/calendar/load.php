<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=u655308956_dent', 'u655308956_tutor', 'www.g2ix.com');

$data = array();

$query = "SELECT * FROM events where status='1' ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
