<?php
	$id_client = $_POST['client_id'];

	$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
	$req = "SELECT * FROM clients WHERE clients.id = '".$id_client."'" or die (mysql_error());
	$list_clients = $db->query($req);
	$client = $list_clients->fetch(PDO::FETCH_ASSOC);
	$dbConnect = null;

// 	while($clients = $list_clients->fetch(PDO::FETCH_ASSOC)) {
//     	$client[] = $clients;
// }
	echo json_encode($client);
?>