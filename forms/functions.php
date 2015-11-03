<?php
try { 
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9', array(
    PDO::ATTR_PERSISTENT => true,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
	));
} catch (PDOException $e) { 
print "Erreur ! : " . $e->getMessage() . "<br />"; 
die(); 
} 


 ?>