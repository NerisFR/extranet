<!--INSERT ID_DEP-->

<?php
    include '../../functions.php';
    $id_collab = $_POST['collab_id'];
    $civ = $_POST['civ'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $fonction = $_POST['fonction'];
    $arrivee=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['arrivee'])));
    $depart = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['depart'])));
    $loggin = $_POST['loggin'];
    $passwd = $_POST['passwd'];
    $id_profil = $_POST['id_profil'];

    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $req_send = "UPDATE collaborateurs SET civilite='$civ', nom = '$nom', prenom = '$prenom', fonction = '$fonction', embauche = '$arrivee', debauche = '$depart', nom_usage = '$prenom $nom', login = '$loggin', password = '$passwd', id_profils = '$id_profil' WHERE collaborateurs.id = $id_collab";
    $db->exec($req_send);
    
    echo "<br></br>";
    echo "<span>Le collaborateur '$prenom' '$nom' a bien été modifié.</span>";
    echo "<br></br>";




?>