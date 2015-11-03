<?php

    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $data = array();
    $collabid = $_POST['collab_id'];
    if($collabid==0){
        $req = "SELECT DISTINCT clients.id, clients.nom FROM clients ORDER BY clients.nom" or die (mysql_error());
    }
    else{
       $req = "SELECT DISTINCT clients.id, clients.nom FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$collabid')) ORDER BY clients.nom" or die (mysql_error()); 
    }
    $cli = $db->query($req);

    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->nom";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
            };
  echo json_encode($data);
?>