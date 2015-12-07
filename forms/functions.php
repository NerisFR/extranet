<?php
try { 
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9', array(
    PDO::ATTR_PERSISTENT => true
	));
} catch (PDOException $e) { 
print "Erreur ! : " . $e->getMessage() . "<br />"; 
die(); 
} 


 ?>