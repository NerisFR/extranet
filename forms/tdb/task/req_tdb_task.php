<?php
    setlocale(LC_TIME, "fr_FR");
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $NDS = array();
    $collabid = $_POST['collab_id'];
    $clientid = $_POST['client_id'];
    $contratid = $_POST['contrat_id'];
    $annees = $_POST['annees'];
    $sql = "SELECT demarrage FROM contrats WHERE contrats.id='$contratid'";
    $date = $db->query($sql);
    $dem = $date->fetch();
    $demarrage = $dem[0];
    if(strlen($annees)>5){
        $annee_deb = substr($annees, 0, 4);
        $annee_fin = substr($annees, -4, 4);
        $date_deb =  $annee_deb."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
        $date_fin =  $annee_fin."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
        }
    else{
        $annee_deb = $annees;
        $annee_fin = $annees+1;
        $date_deb =  $annee_deb."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
        $date_fin =  $annee_fin."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
        }

        $req = "SELECT  D.ANNEE,(SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), ADM_SYS, MAINTENANCE, GEST_PARC, ETUDE_PRIX, INSTALL, ASSISTANCE, FORMATION, PROJET, DEVELOPPEMENT, REUNION, DEPLACEMENT, CONTROLE, AUTRE
            FROM (SELECT MONTH(calendrier.Jour) AS MOIS, Year(calendrier.Jour) AS ANNEE
            FROM calendrier 
            WHERE ((calendrier.Jour) BETWEEN '$date_deb' AND '$date_fin') 
            GROUP BY Month(calendrier.Jour), Year(calendrier.Jour) 
            ORDER BY Year(calendrier.Jour), MONTH(calendrier.Jour) ASC)  AS D LEFT JOIN (SELECT MONTH(nds.Jour) AS MOIS, Year(nds.Jour) AS ANNEE, If(isnull(Sum(nds.TPS_ADM)),0,Sum(nds.TPS_ADM)) AS ADM_SYS, If(isnull(Sum(nds.TPS_MAINT)),0,Sum(nds.TPS_MAINT)) AS MAINTENANCE, If(isnull(Sum(nds.TPS_PARC)),0,Sum(nds.TPS_PARC)) AS GEST_PARC, If(isnull(Sum(nds.TPS_PRIX)),0,Sum(nds.TPS_PRIX)) AS ETUDE_PRIX, If(isnull(Sum(nds.TPS_INST)),0,Sum(nds.TPS_INST)) AS INSTALL, If(isnull(Sum(nds.TPS_ASSIST)),0,Sum(nds.TPS_ASSIST)) AS ASSISTANCE, If(isnull(Sum(nds.TPS_FORM)),0,Sum(nds.TPS_FORM)) AS FORMATION, If(isnull(Sum(nds.TPS_PROJ)),0,Sum(nds.TPS_PROJ)) AS PROJET, If(isnull(Sum(nds.TPS_DEV)),0,Sum(nds.TPS_DEV)) AS DEVELOPPEMENT, If(isnull(Sum(nds.TPS_REUNION)),0,Sum(nds.TPS_REUNION)) AS REUNION, If(isnull(Sum(nds.TPS_DEP)),0,Sum(nds.TPS_DEP)) AS DEPLACEMENT, If(isnull(Sum(nds.TPS_CTRL)),0,Sum(nds.TPS_CTRL)) AS CONTROLE, If(isnull(Sum(nds.TPS_AUTRE)),0,Sum(nds.TPS_AUTRE)) AS AUTRE
            FROM (clients INNER JOIN contrats ON clients.Id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat
            WHERE (((contrats.id)=$contratid) AND ((nds.Jour) BETWEEN '$date_deb' AND '$date_fin'))
            GROUP BY Month(nds.Jour), Year(nds.Jour))  AS N ON (D.ANNEE=N.ANNEE) AND (D.MOIS=N.MOIS)
            ORDER BY D.ANNEE, D.MOIS;" or die (mysql_error());

    $cli = $db->query($req);
    $NDS = $cli->fetchall();

    echo "<div class='box box-primary'>";
        echo "<div class='box-header with-border'>";
            echo "<h3 class='box-title'>Données de synthèse</h3><i class='pull-right fa fa-fw fa-chevron-down' style='cursor:Pointer;text-align: right;' id='icon-bilan-tsk'/>";
        echo "</div>";
    echo "</div>";

    echo "<div class='box-body' id='table-bilan-tsk'>";
        echo "<table class='pull-center'>";
            echo "<tr width='200'>";
            echo "<td>";
            echo "<table class='table table-bordered table-striped'>";
                echo "<tr  rowspan='2' width='40' height='35'>";
                    echo "<th>Période</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Admin. Syst.</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Maintenance Matériel</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Gestion de parc</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Etude de prix</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Install. / Param.</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Assistance Utilisateur</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Formation</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Gestion de projet</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Developpement</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Reunion</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Déplacement</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Controle journalier</th>";
                echo "</tr>";
                echo "<tr width='40' height='25'>";
                    echo "<th>Autre</th>";
                echo "</tr>";
            echo "</table>";
            echo "</td>";
            echo "<td>";
                echo "<table id='tdbh' class='table table-bordered table-striped table-hover display nowrap' cellspacing='0' width='100%''>";
                $heur =0;
                echo "<thead>";
                echo "<tr height='35'>";
                    for ($i=0; $i<12; $i++) {
                        $var = $NDS[$i][1]." ".$NDS[$i][0];
                        echo "<th class='sorting'>".$var."</th>";
                    }
                echo '</tr>';
                echo "</thead>";
                for($j=2; $j<15; $j++) {
                    echo "<tr height='25'>";
                    for ($i=0; $i<12; $i++) {
                        if (!(($NDS[$i][$j])==0)){
                            $var = $NDS[$i][$j];
                            echo "<td>".$NDS[$i][$j]."</td>";
                        }
                        else{
                            echo "<td>-</td>";
                        }
                    }
                    echo '</tr>';
                }   
            echo "</table>";
        echo "</td>";
//        echo "<tr>";
//            echo "<td height='20'>&nbsp;</td>";
//        echo "</tr>";
        echo "</table>";
    echo "</div>";

require_once ('../../../plugins/jpgraph-3.5.0b1/src/jpgraph.php');
require_once ('../../../plugins/jpgraph-3.5.0b1/src/jpgraph_bar.php');

for ($i=2; $i<15; $i++){
    $TSK = 0;
    for ($j=0; $j<12; $j++){
        $TSK = $TSK + $NDS[$j][$i];
    }
    $total[] = $TSK;
}


$task = array("Admin. syst.", "Maint.", "Gest. de parc", "Etude de prix", "Install.", "Assist.", "Formation", "Gestion de proj.", "Dev.", "Reunion", "Déplacement", "Ctrl journalier", "Autre");

echo "<div class='box box-primary'>";
echo "<div class='box-header with-border'>";
echo "<h3 class='col-xs-6 box-title'>Graph de synthèse</h3>";
echo "</div>";
echo "</div>";
echo "<div class='box-body'>";

echo "<script type='text/javascript'>";
    echo "var chart = new CanvasJS.Chart('chartContainer', {";
      // echo "theme: 'theme2',";
    echo "animationEnabled: true,";
    echo "backgroundColor: '#f1f1f1',";
      echo "title:{";
        echo "text: 'Bilan par taches',";
        echo "fontSize: 30";
      echo "},";

      echo "legend:{";
        echo "fontFamily: 'Open sans',";
        echo "verticalAlign: 'center',";
        echo "horizontalAlign: 'left'";
      echo "},";
      echo "data: [";
      echo "{";
        echo "type: 'pie',"; 
        echo "indexLabelFontSize: 12,";
        echo "indexLabelFontFamily: 'Open sans',";
        echo "indexLabelFontColor: 'darkgrey',";
        echo "indexLabelLineColor: 'darkgrey',";
        echo "indexLabelPlacement: 'outside',";
        echo "showInLegend: true,";
        echo "toolTipContent: '{y} - <strong>#percent%</strong>',";
        echo "dataPoints:[";
        for ($i=0; $i<13; $i++) {
                echo "{ y: ".$total[$i].", legendText:'".$task[$i]."', indexLabel: '".$task[$i]."' },";
            }
        echo "]";
      echo "}";
    echo "]";
    echo "});";

    echo "chart.render();";
echo "</script>";
echo "<div id='chartContainer' style='height: 300px; width: 700px;'></div>";

echo "</div>";

?>
  