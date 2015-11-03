<!--INSERT ID_DEP-->

<?php
    include '../../functions.php';
    $id_profil = $_POST['id_profil'];
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
    $req_send = "UPDATE profils SET profils='$pro', nds='$nds', tdbhour='$tdbh', tdbtask='$tdbt', client='$gclient', contrat='$gcontrat', collaborateur='$gcollab', affectation='$gaffect', gest_profils='$gprofils' WHERE profils.id = $id_profil";
    $rep = $db->query("UPDATE profils SET profils='$pro', nds='$nds', tdbhour='$tdbh', tdbtask='$tdbt', client='$gclient', contrat='$gcontrat', collaborateur='$gcollab', affectation='$gaffect', gest_profils='$gprofils' WHERE profils.id = $id_profil");
    $rep->closeCursor();
    echo "<br></br>";
    echo "<span>Le profils $pro a bien été modifié.</span>";
    echo "<br></br>";




?>