<?php

    include '../../functions.php';
    global $db;
    
    $req = "SELECT id, nom_usage FROM collaborateurs ORDER BY nom_usage" or die (mysql_error());
    $cli = $db->query($req);

    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->nom_usage";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
            };
  echo json_encode($data);
?>