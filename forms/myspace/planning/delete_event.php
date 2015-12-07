<?php
 
$id=$_POST['id'];

include '../../functions.php';
 global $db;
// connexion à la base de données
 
$sql = $db->query("DELETE FROM planning WHERE id='$id'");

 
?>