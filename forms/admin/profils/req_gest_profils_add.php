<?php

    include '../../functions.php';

    $pro = $_POST['pro'];
    $nds = $_POST['nds'];
    $tdbh = $_POST['tdbh'];
    $tdbt = $_POST['tdbt'];
    $gclient = $_POST['gclient'];
    $gcollab = $_POST['gcollab'];
    $gcontrat = $_POST['gcontrat'];
    $gaffect = $_POST['gaffect'];
    $gprofils = $_POST['gprofils'];
    global $db;
    
    
    $rep = $db->query("INSERT INTO profils(id, profils, nds, tdbhour, tdbtask, client, contrat, collaborateur, affectation, gest_profils) VALUES ('','$pro', '$nds', '$tdbh', '$tdbt', '$gclient', '$gcontrat', '$gcollab', '$gaffect', '$gprofils')");
    
   
    
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le nouveau profils a bien été enregistré.</span>";
    echo "</div>";

?>
  