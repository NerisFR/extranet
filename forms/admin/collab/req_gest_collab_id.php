<?php
	$id_collab = $_POST['collab_id'];

	$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
	$req = "SELECT * FROM collaborateurs WHERE collaborateurs.id = '".$id_collab."'" or die (mysql_error());
	$list_collab = $db->query($req);
	$collab = $list_collab->fetch(PDO::FETCH_ASSOC);
	$dbConnect = null;

	echo json_encode($collab);
?>