<?php

    include '../../functions.php';
    $id_affect = $_POST['affect_id'];
    
    global $db;
    $rep = $db->query("DELETE FROM affect_cont_collab WHERE affect_cont_collab.id = ".$id_affect);
    $rep->closeCursor();

    echo "<div>";
    echo "<span>L'affectation n°".$id_affect." a bien été supprimé.</span>";
    echo "</div>";

?>
  