<?php


$dt =  $_GET['dates'];
$dates = strtotime($dt);
$dates = date('Y-m-d',$dates);

//echo $cop_here;

$link = mysqli_connect("localhost", "u655308956_tutor", "www.g2ix.com", "u655308956_dent"); 
  
if ($link ==  false) { 
    die("ERROR: Could not connect. "
                .mysqli_connect_error()); 
} 


$sql="SELECT * FROM events where dates = '$dates'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$event = $row['start_event'];
$dat =  $row['dates'];

if($dates === $dat){



$last = array (
  'messages' => 
  array (
    0 => 
    array (
      'text' => ' '.$event. '\n ',
     
    ),
  ),
);

$file_name = $_GET['dates'] . "_stock.json";  
 if(file_put_contents($file_name, json_encode($last,JSON_UNESCAPED_UNICODE )))  
 
 
 {  
 header("Content-Type: text/plain; charset=UTF-8");
      echo $file_name . ' File created';  
 }  
 else  
 {  
      echo 'There is some error';  
 }  


function json_encode_unicode($last) {
	if (defined('JSON_UNESCAPED_UNICODE')) {
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
//	return preg_replace_callback('/(?<!\\\\)\\\\u([0-9a-f]{4})/i',
//		function ($m) {
//			$d = pack("H*", $m[1]);
//			$r = mb_convert_encoding($d, "UTF8", "UTF-16BE");
//			return $r!=="?" && $r!=="" ? $r : $m[0];
//		}, 
    json_encode($data)
//	);
//}




//print_r(json_encode($last,JSON_UNESCAPED_UNICODE));




}else{

echo "nothing matches";
}




?>