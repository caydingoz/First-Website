<?php
   	$servername="localhost";
	$dbname="login";
	$dbusername="root";
	$dbpassword="";

	$db=new mysqli($servername, $dbusername, $dbpassword, $dbname);
	
	function pdo_connect_mysql() {//Databes bağlantısı kuruluyor.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'login';
    try {   
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {//Bağlanmazsa error.
    	die ('Failed to connect to database!');
    }
}
?>