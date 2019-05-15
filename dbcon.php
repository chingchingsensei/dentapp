<?php

    $DB_HOST = 'localhost';
    $DB_USER = 'u655308956_tutor';
    $DB_PASS = 'www.g2ix.com';
    $DB_NAME = 'u655308956_dent';
	
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	
