<?php
 
$id=$_POST['id'];
$start=$_POST['start'];
$end=$_POST['end'];
include '../../functions.php';
 global $db;
// connexion à la base de données

 
$sql = $db->query("UPDATE planning SET start='$start', end='$end' WHERE id='$id'");

 

 
?>