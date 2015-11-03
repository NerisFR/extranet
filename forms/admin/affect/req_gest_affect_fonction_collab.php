<?php

    include '../../functions.php';
    global $db;
    $id_collab = mysql_real_escape_string($_POST['id_collab']);
    $req = "SELECT id, fonction FROM collaborateurs WHERE id=".$id_collab or die (mysql_error());
    $cli = $db->query($req);

    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->fonction";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
            };
  echo json_encode($data);
?>