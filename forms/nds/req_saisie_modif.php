<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include '../functions.php';
    global $db;
    $nds_id = $_POST['nds_id'];
    $collab_id = $_POST['collab_id'];
    $client_id = $_POST['client_id'];
    $contrat_id = $_POST['contrat_id'];
    $type_heure = $_POST['type_heure'];
    $jour = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['jour'])));
    
    $h_debut = $_POST['h_debut'];
    $h_fin = $_POST['h_fin'];

    $TPS_ADM = $_POST['TPS_ADM'];
    $TPS_PROJ = $_POST['TPS_PROJ'];
    $TPS_MAINT = $_POST['TPS_MAINT'];
    $TPS_DEV = $_POST['TPS_DEV'];
    $TPS_PARC = $_POST['TPS_PARC'];
    $TPS_REUNION = $_POST['TPS_REUNION'];
    $TPS_PRIX = $_POST['TPS_PRIX'];
    $TPS_DEP = $_POST['TPS_DEP'];
    $TPS_INST = $_POST['TPS_INST'];
    $TPS_CTRL = $_POST['TPS_CTRL'];
    $TPS_ASSIST = $_POST['TPS_ASSIST'];
    $TPS_AUTRE = $_POST['TPS_AUTRE'];
    $TPS_FORM = $_POST['TPS_FORM'];

    $CTRL_LOG = $_POST['CTRL_LOG'];
    $CTRL_MAJ_OS = $_POST['CTRL_MAJ_OS'];
    $CTRL_HDD = $_POST['CTRL_HDD'];
    $CTRL_MAJ_HARD = $_POST['CTRL_MAJ_HARD'];
    $CTRL_RAID = $_POST['CTRL_RAID'];
    $CTRL_MAJ_SOFT = $_POST['CTRL_MAJ_SOFT'];
    $CTRL_BACKUP = $_POST['CTRL_BACKUP'];
    $CTRL_ANTIVIRUS = $_POST['CTRL_ANTIVIRUS'];
    $VOLUM_BACKUP = $_POST['VOLUM_BACKUP'];
    $MAJ_ANTIVIRUS = $_POST['MAJ_ANTIVIRUS'];
    $MAJ_BACKUP = $_POST['MAJ_BACKUP'];

    $comment = $_POST['comment'];
    $TPS_TOTAL=$TPS_ADM+$TPS_MAINT+$TPS_PARC+$TPS_PRIX+$TPS_INST+$TPS_ASSIST+$TPS_FORM+$TPS_PROJ+$TPS_DEV+$TPS_REUNION+$TPS_DEP+$TPS_CTRL+$TPS_AUTRE;

    
    $req = "SELECT affect_cont_collab.id FROM affect_cont_collab WHERE affect_cont_collab.id_collab='$collab_id' AND affect_cont_collab.id_contrat='$contrat_id'" or die (mysql_error());
    $affect = $db->query($req);
    $idaffect = $affect->fetch();
    $id_affect = $idaffect[0];
    // $req_send = "INSERT INTO nds(id, jour, arrivee, depart, type_heure, tps_total, tps_adm, tps_maint, tps_parc, tps_prix, tps_inst, tps_assist, tps_form, tps_proj, tps_dev, tps_reunion, tps_dep, tps_ctrl, tps_autre, ctrl_log, ctrl_hdd, ctrl_raid, ctrl_maj_os, ctrl_maj_hard, ctrl_maj_soft, ctrl_backup, volum_backup, maj_backup, ctrl_antivirus, maj_antivirus, commentaire, id_affect) VALUES ('','$jour','$h_debut','$h_fin','$type_heure','$TPS_TOTAL','$TPS_ADM','$TPS_MAINT','$TPS_PARC','$TPS_PRIX','$TPS_INST','$TPS_ASSIST','$TPS_FORM','$TPS_PROJ','$TPS_DEV','$TPS_REUNION','$TPS_DEP','$TPS_CTRL','$TPS_AUTRE','$CTRL_LOG','$CTRL_HDD','$CTRL_RAID','$CTRL_MAJ_OS','$CTRL_MAJ_HARD','$CTRL_MAJ_SOFT','$CTRL_BACKUP','$VOLUM_BACKUP','$MAJ_BACKUP','$CTRL_ANTIVIRUS','$MAJ_ANTIVIRUS','$comment','$id_affect')";
    $req_send = "UPDATE nds SET jour='$jour', arrivee = '$h_debut', depart = '$h_fin', type_heure = '$type_heure', tps_total = $TPS_TOTAL, tps_adm = $TPS_ADM, tps_maint = $TPS_MAINT, tps_parc = $TPS_PARC, tps_prix = $TPS_PRIX, tps_inst = $TPS_INST, tps_assist = $TPS_ASSIST, tps_form = $TPS_FORM, tps_proj = $TPS_PROJ, tps_dev = $TPS_DEV, tps_reunion = $TPS_REUNION, tps_dep = $TPS_DEP, tps_ctrl = $TPS_CTRL, tps_autre = $TPS_AUTRE, ctrl_log = $CTRL_LOG, ctrl_hdd = $CTRL_HDD, ctrl_raid = $CTRL_RAID, ctrl_maj_os = $CTRL_MAJ_OS, ctrl_maj_hard = $CTRL_MAJ_HARD, ctrl_maj_soft = $CTRL_MAJ_SOFT, ctrl_backup = $CTRL_BACKUP, volum_backup = $VOLUM_BACKUP, maj_backup = $MAJ_BACKUP, ctrl_antivirus = $CTRL_ANTIVIRUS, maj_antivirus = $MAJ_ANTIVIRUS, commentaire = '$comment', id_affect = $id_affect WHERE nds.id = $nds_id";


    $db->exec($req_send);
    
    echo "<br></br>";
    echo "<span>Votre note de synthese $nds_id a bien été modifiée.</span>";
    echo "<br></br>";


?>