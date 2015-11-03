<?php

    include '../../functions.php';
    global $db;
    
    $req = "SELECT id, nom FROM clients ORDER BY nom" or die (mysql_error());
    $cli = $db->query($req);

    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->nom";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
            };
  echo json_encode($data);
?>