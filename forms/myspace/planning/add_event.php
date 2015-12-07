<?php
 
$id_collab=$_POST['id_collab'];
$id_client=$_POST['id_client'];
$start=$_POST['start'];
$end=$_POST['end'];
include '../../functions.php';
 global $db;
// connexion à la base de données

 
$sql = $db->query("INSERT INTO planning (start, end, id_collab, id_client) VALUES ('$start', '$end', '$id_collab', '$id_client')");

?>