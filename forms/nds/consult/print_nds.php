<?php

$nds_id = $_GET['nds_id'];
$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
$req = "SELECT collaborateurs.nom_usage as nom_collab, clients.nom as nom_client, contrats.description as contrat, nds.id as id, nds.jour as jour, clients.id as client_id, contrats.id as contrat_id, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure,  collaborateurs.id as collab_id, nds.tps_adm , nds.tps_maint, nds.tps_parc, nds.tps_prix, nds.tps_inst, nds.tps_assist, nds.tps_form, nds.tps_proj, nds.tps_dev, nds.tps_reunion, nds.tps_dep, nds.tps_ctrl, nds.tps_autre, nds.ctrl_log, nds.ctrl_hdd, nds.ctrl_raid, nds.ctrl_maj_os, nds.ctrl_maj_hard, nds.ctrl_maj_soft, nds.ctrl_backup, nds.volum_backup, nds.maj_backup, nds.ctrl_antivirus, nds.maj_antivirus, nds.commentaire FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = NDS.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  nds.id = '".$nds_id."'" or die (mysql_error());
$list_nds = $db->query($req);
$nds = $list_nds->fetch(PDO::FETCH_ASSOC);
$dbConnect = null;

if (($nds['ctrl_log'])==true){
	$CTRL_LOG = "checked";
}
else{
	$CTRL_LOG = "";
}

if (($nds['ctrl_hdd'])==true){
	$CTRL_HDD = "checked";
}
else{
	$CTRL_HDD = "";
}

if (($nds['ctrl_raid'])==true){
	$CTRL_RAID = "checked";
}
else{
	$CTRL_RAID = "";
}

if (($nds['ctrl_maj_os'])==true){
	$CTRL_MAJ_OS = "checked";
}
else{
	$CTRL_MAJ_OS = "";
}

if (($nds['ctrl_maj_hard'])==true){
	$CTRL_MAJ_HARD = "checked";
}
else{
	$CTRL_MAJ_HARD = "";
}

if (($nds['ctrl_maj_soft'])==true){
	$CTRL_MAJ_SOFT = "checked";
}
else{
	$CTRL_MAJ_SOFT = "";
}

if (($nds['ctrl_backup'])==true){
	$CTRL_BACKUP = "checked";
}
else{
	$CTRL_BACKUP = "";
}

if (($nds['volum_backup'])==true){
	$VOLUM_BACKUP = "checked";
}
else{
	$VOLUM_BACKUP = "";
}

if (($nds['maj_backup'])==true){
	$MAJ_BACKUP = "checked";
}
else{
	$MAJ_BACKUP = "";
}

if (($nds['ctrl_antivirus'])==true){
	$CTRL_ANTIVIRUS = "checked";
}
else{
	$CTRL_ANTIVIRUS = "";
}

if (($nds['maj_antivirus'])==true){
	$MAJ_ANTIVIRUS = "checked";
}
else{
	$MAJ_ANTIVIRUS = "";
}

// var_dump($CTRL_LOG);
ob_start();

// var_dump($nds);
?>


<style type="text/css">
	table{ 
		width:100%;
		font-family : helvetica;
	}
	table td{
		height:25px;
	}
</style>

<page backtop="20mm" backleft="10mm" backright="10mm">
	<table>
		<tr>
			<td style="width:50%"><img src="../../../src/img/Logo_def.png" width="299" height="137" /></td>
		</tr>
		<tr>
		    <td style="width:50%">Les Bureaux du lac II - Rue Robert Caumont - Imm. P</td>
		</tr>
		<tr>
		    <td style="width:50%">33000 BORDEAUX</td>
		</tr>
		<tr>
		    <td style="width:50%">Tel : 05 35 54 44 55 - Fax : 05 35 54 44 55</td>
		</tr>
	</table>

	<table>
		<tr>
			<td style="width:100%; height:30px; text-align: center; font-size:18;"><h1>Note de synthèse n°<?php echo $nds["id"]; ?></h1></td>
		</tr>	
	</table>

	<table align="center">
		<!-- <tr>
		  <td style="width:100%; text-align=center;" colspan="5"></td>
		</tr> -->
		<tr>
		  <td style=" text-align:left; background-color : #6394bd; color:#ffffff;font-size:16px;text-align:center;" colspan="5">Renseignement administratif</td>
		</tr>
		<tr>
		  <td style="width:100%; text-align:center;height:20px;" colspan="5"></td>
		</tr>
		<tr>
		  <td style="width:18%;text-align: left;height:25px;"><label for="Collab3">Collaborateur : </label></td>
		  <td style="width:48%;height:25px;"><?php echo $nds["nom_collab"]; ?></td>
		  <td style="width:4%;height:25px;">&nbsp;</td>
		  <td style="width:18%;height:25px;"><label for="Jour3">Date</label>
		    : </td>
		  <td style="width:12%;height:25px;"><?php echo $nds["jour"]; ?></td>
		</tr>
		<tr>
		  <td style="width:18%;text-align: left;height:25px;">Client :</td>
		  <td style="width:48%;height:25px;"><?php echo $nds["nom_client"]; ?></td>
		  <td style="width:4%;height:25px;">&nbsp;</td>
		  <td style="width:18%;height:25px;">Heure d'arrivée :</td>
		  <td style="width:12%;height:25px;"><?php echo $nds["arrivee"]; ?></td>
		</tr>
		<tr>
		  <td style="width:18%;height:25px;">Contrat :</td>
		  <td style="width:48%;height:25px;"><?php echo $nds["contrat"]; ?></td>
		  <td style="width:4%;height:25px;">&nbsp;</td>
		  <td style="width:18%;height:25px;">Heure de départ :</td>
		  <td style="width:12%;height:25px;"><?php echo $nds["depart"]; ?></td>
		</tr>
		<tr>
		  <td style="width:18%;"><label for="type_heure3">Type d'heure :</label></td>
		  <td style="width:48%;"><?php echo $nds["type_heure"]; ?></td>
		  <td style="width:4%;">&nbsp;</td>
		  <td style="width:18%;">&nbsp;</td>
		  <td style="width:12%;">&nbsp;</td>
		</tr>
<!-- 		<tr>
		  <td style="width:100%; text-align=center;" colspan="5"></td>
		</tr> -->
	</table>

	<table>
		    <tr>
		      <td style="width:100%;" colspan="9" >&nbsp;</td>
	        </tr>
		    <tr>
		      <td style="width:52%; text-align:center; background-color : #6394bd; color:#ffffff;padding:2px;font-size:16px;" colspan="5">Actions réalisées</td>
		      <td style="width:4%">&nbsp;</td>
		      <td style="width:44%; text-align:center; background-color : #6394bd; color:#ffffff;padding:2px;font-size:16px;" colspan="3">Maintenance technique</td>
	        </tr>
	        <tr>
		      <td style="width:100%;height:15px;" colspan="9">&nbsp;</td>
	        </tr>
		    <tr>
		      <td style="width:20%">Admin. système :</td>
		      <td style='width:4%'><?php echo $nds["tps_adm"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Suivi de projet :</td>
		      <td style='width:4%'><?php echo $nds["tps_proj"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style="width:44%;; text-align:center; background-color : #6394bd; color:#ffffff;padding:2px;font-size:14;" colspan="3">Serveur</td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Maint. matériel : </td>
		      <td style='width:4%'><?php echo $nds["tps_maint"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Etude &amp; dev. :</td>
		      <td style='width:4%'><?php echo $nds["tps_dev"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_LOG; ?>' name="CTRL_LOG" id="CTRL_LOG" />
		        <label for="CTRL_LOG">Contrôle Log </label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_MAJ_OS; ?>' name="CTRL_LOG4" id="CTRL_LOG4" />
		        <label for="CTRL_LOG4">MAJ OS</label></td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Suivi de parc :</td>
		      <td style='width:4%'><?php echo $nds["tps_parc"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Réunion :</td>
		      <td style='width:4%'><?php echo $nds["tps_reunion"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_HDD; ?>' name="CTRL_LOG2" id="CTRL_LOG2" />
		        Disques
		        <label for="CTRL_LOG2"></label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_MAJ_HARD; ?>' name="CTRL_LOG5" id="CTRL_LOG5" />
		        MAJ Hard
		        <label for="CTRL_LOG5"></label></td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Etudes de prix : </td>
		      <td style='width:4%'><?php echo $nds["tps_prix"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Déplacement : </td>
		      <td style='width:4%'><?php echo $nds["tps_dep"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_RAID; ?>' name="CTRL_LOG3" id="CTRL_LOG3" />
		        RAID
		        <label for="CTRL_LOG3"></label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_MAJ_SOFT; ?>' name="CTRL_LOG6" id="CTRL_LOG6" />
		        <label for="CTRL_LOG6">MAJ Logiciel</label></td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Inst. / paramètrage : </td>
		      <td style='width:4%'><?php echo $nds["tps_inst"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Ctrl journalier : </td>
		      <td style='width:4%'><?php echo $nds["tps_ctrl"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%; text-align:center; background-color : #6394bd; color:#ffffff;padding:2px;font-size:14;'>Sauvegarde</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%; text-align:center; background-color : #6394bd; color:#ffffff;padding:2px;font-size:14;'>Antivirus</td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Assist. utilisateur :</td>
		      <td style='width:4%'><?php echo $nds["tps_assist"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>Autre : </td>
		      <td style='width:4%'>0</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_BACKUP; ?>' name="CTRL_LOG7" id="CTRL_LOG7"/>
		        <label for="CTRL_LOG7">Vérification</label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $CTRL_ANTIVIRUS; ?>' name="CTRL_LOG10" id="CTRL_LOG10" />
		        <label for="CTRL_LOG10">Vérification</label></td>
	        </tr>
		    <tr>
		      <td style='width:20%'>Formation :</td>
		      <td style='width:4%'><?php echo $nds["tps_form"]; ?></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $VOLUM_BACKUP; ?>' name="CTRL_LOG8" id="CTRL_LOG8" />
		        Volumétrie
		        <label for="CTRL_LOG8"></label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input type="checkbox" disabled="disabled" checked='<?php echo $MAJ_ANTIVIRUS; ?>' name="CTRL_LOG11" id="CTRL_LOG11" />
		        <label for="CTRL_LOG11">Mise à jour</label></td>
	        </tr>
		    <tr>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'><input disabled="disabled" checked='<?php echo $MAJ_BACKUP; ?>'type="checkbox" name="CTRL_LOG9" id="CTRL_LOG9" />
		        <label for="CTRL_LOG9">Mise à jour</label></td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
	        </tr>
		    <tr>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
		      <td style='width:4%'>&nbsp;</td>
		      <td style='width:20%'>&nbsp;</td>
	        </tr>
		    <tr>
		      <td style="width:100%;" colspan="9" height="15">Commentaires :</td>
	        </tr>
		    <tr>
		      <td style="width:100%;" colspan="9"><textarea text-align="left" cols="70" rows="3"><?php echo $nds["commentaire"]; ?></textarea></td>
	        </tr>
	        
  		</table>
</page>

<?php
$contentpdf = ob_get_clean();
require('../../../src/assets/html2pdf_v4.03/html2pdf.class.php');
try{
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->pdf->SetDisplayMode('fullpage');
	$pdf->writeHTML($contentpdf);
	$pdf->Output('test3.pdf');

}catch(HTML2PDF_exception $e){
	die($e);
}

?>