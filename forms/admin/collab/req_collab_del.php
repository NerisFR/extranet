<?php

    include '../../functions.php';
    $id_collab = $_POST['collab_id'];
    
    global $db;
    $rep = $db->query("DELETE FROM collaborateurs WHERE collaborateurs.id = ".$id_collab);
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le collaborateur n°".$id_collab." a bien été supprimé.</span>";
    echo "</div>";

?>
  