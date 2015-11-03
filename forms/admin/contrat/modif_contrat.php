<?php
    include '../../functions.php';
    $num = $_POST['num'];
    $date_sign = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_sign'])));
    $vol = $_POST['vol'];
    $date_dem = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_dem'])));
    $preavis = $_POST['preavis'];
    $marche = $_POST['marche'];
    $tacite = $_POST['tacite'];
    $id_cli = $_POST['id_cli'];
    $base_sem = $_POST['base_sem'];
    $nb_mois = $_POST['nb_mois'];
    $desc = $_POST['desc'];
    $id_contrat = $_POST['id_contrat'];
    $date_fin_mission = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_fin_mission'])));

    global $db;
    $rep = $db->query("UPDATE contrats SET numero='$num', signature = '$date_sign', demarrage = '$date_dem', marche = '$marche', reconduction = '$tacite', volume = '$vol', base_sem = '$base_sem', nb_mois = '$nb_mois', description = '$desc', id_client = '$id_cli', date_fin_mission = '$date_fin_mission' WHERE contrats.id = $id_contrat");
    $rep->closeCursor();
    
    echo "<br></br>";
    echo "<span>Le contrat n°$num a bien été modifié.</span>";
    echo "<br></br>";




?>