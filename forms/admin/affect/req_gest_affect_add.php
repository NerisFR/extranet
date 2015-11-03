<?php

    include '../../functions.php';
    $id_collab = $_POST['id_collab'];
    $contrat_id = $_POST['contrat_id'];
    $date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_debut'])));
    $date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_fin'])));
    
    
    global $db;
    if($date_fin="1970-01-01"){
        $rep = $db->query("INSERT INTO affect_cont_collab(id, id_contrat, id_collab, debut) VALUES ('','$contrat_id','$id_collab','$date_debut')");
    }
    else{
        $rep = $db->query("INSERT INTO affect_cont_collab(id, id_contrat, id_collab, debut, fin) VALUES ('','$contrat_id','$id_collab','$date_debut','$date_fin')");
    }
        
    

     
    
    $rep->closeCursor();

    echo "<div>";
    echo "<span>La nouvelle affectation a bien été enregistré.</span>";
    echo "</div>";

?>
  