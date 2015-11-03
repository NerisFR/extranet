<?php

    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $data = array();
    $collabid = $_POST['collab_id'];
    $clientid = $_POST['client_id'];
    if($collabid==0){
        $req = "SELECT contrats.id, contrats.description FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) WHERE ((clients.id)='$clientid'); " or die (mysql_error());

    }
    else{
        $req = "SELECT contrats.id, contrats.description FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((clients.id)='$clientid') AND ((collaborateurs.id)='$collabid')); " or die (mysql_error());

    }
    $cli = $db->query($req);

    // $contrats = $cli->fetch(PDO::FETCH_ASSOC);
    // $dbConnect = null;

    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->description";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
            };
  echo json_encode($data);
  
?>