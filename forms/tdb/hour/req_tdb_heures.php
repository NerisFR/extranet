<?php
    setlocale(LC_TIME, "fr_FR");
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $NDS = array();

    $contratid = $_POST['contrat_id'];
    $annees = $_POST['annees'];
    $sql = "SELECT demarrage, base_sem, nb_mois FROM contrats WHERE contrats.id='$contratid'";
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
        $nb_sem = $dem[1]/(12/$dem[2]);

        if ($dem[2] == 12){
          $req = "SELECT D.ANNEE, (SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), (If(D.MOIS=8,'0',If(D.MOIS=12,(SELECT Round(contrats.volume/$nb_sem*3,2) FROM contrats WHERE ((contrats.id)='$contratid')),(SELECT Round((contrats.volume-contrats.volume/$nb_sem*3)/10,2) FROM contrats WHERE (((contrats.id)='$contratid')))))) AS prevu, N.Temps_realise
            FROM (
                SELECT MONTH(calendrier.Jour) AS MOIS, Year(calendrier.Jour) AS ANNEE
                FROM calendrier 
                WHERE ((calendrier.Jour) BETWEEN '$date_deb' AND '$date_fin') 
                GROUP BY Month(calendrier.Jour), Year(calendrier.Jour) 
                ORDER BY Year(calendrier.Jour), MONTH(calendrier.Jour) ASC) AS D 
            LEFT JOIN (
                SELECT MONTH(nds.Jour) AS MOIS, Year(nds.Jour) AS ANNEE, If(isnull(Sum(nds.TPS_TOTAL)),0,Sum(nds.TPS_TOTAL)) AS Temps_realise
                FROM (clients INNER JOIN contrats ON clients.Id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat
                WHERE (((contrats.id)='$contratid') AND ((nds.Jour) BETWEEN '$date_deb' AND '$date_fin') AND (nds.type_heure='Normale'))
                GROUP BY Month(nds.Jour), Year(nds.Jour)) AS N 
            ON (D.ANNEE=N.ANNEE) AND (D.MOIS=N.MOIS)
            ORDER BY D.ANNEE, D.MOIS;" or die (mysql_error());
        }
        else{
          $req = "SELECT D.ANNEE, (SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), (SELECT Round((contrats.volume)/$dem[2],2) FROM contrats WHERE (((contrats.id)='$contratid'))) AS prevu, N.Temps_realise
            FROM (
                SELECT MONTH(calendrier.Jour) AS MOIS, Year(calendrier.Jour) AS ANNEE
                FROM calendrier 
                WHERE ((calendrier.Jour) BETWEEN '$date_deb' AND '$date_fin') 
                GROUP BY Month(calendrier.Jour), Year(calendrier.Jour) 
                ORDER BY Year(calendrier.Jour), MONTH(calendrier.Jour) ASC) AS D 
            LEFT JOIN (
                SELECT MONTH(nds.Jour) AS MOIS, Year(nds.Jour) AS ANNEE, If(isnull(Sum(nds.TPS_TOTAL)),0,Sum(nds.TPS_TOTAL)) AS Temps_realise
                FROM (clients INNER JOIN contrats ON clients.Id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat
                WHERE (((contrats.id)='$contratid') AND ((nds.Jour) BETWEEN '$date_deb' AND '$date_fin') AND (nds.type_heure='Normale'))
                GROUP BY Month(nds.Jour), Year(nds.Jour)) AS N 
            ON (D.ANNEE=N.ANNEE) AND (D.MOIS=N.MOIS)
            ORDER BY D.ANNEE, D.MOIS;" or die (mysql_error());
        }

        

    $cli = $db->query($req);
        //     echo "<td>Mois</td>";
        // echo "</tr>";
    $NDS = $cli->fetchall();

     echo "<div class='box box-primary'>";
    echo "<div class='box-header with-border'>";
    echo "<h3 class='col-xs-6 box-title'>Données de synthèse</h3><i class='pull-right fa fa-fw fa-chevron-down' style='cursor:Pointer;text-align: right;' id='icon-bilan-hour'/>";
    echo "</div>";
    
    echo "<div class='box-body' id='table-bilan-hour'>";
    echo "<table class='table table-border table-hover display' cellspacing='0' width='100%'>";
    echo "<thead>";

        echo "<th>Période</th>";
        for ($i=0; $i<$dem[2]; $i++) {
            $var = $NDS[$i][1]." ".$NDS[$i][0];
            echo "<th>".$var."</th>";
        }
    echo "</thead>";
    echo "<tr'>";
        echo "<th>Heures prévues</th>";
            for ($i=0; $i<$dem[2]; $i++) {
                echo "<td>".$NDS[$i][2]."</td>";
            }
    echo "</tr>";
    echo "<tr>";
        echo "<th>Heures réalisées</th>";
        for ($i=0; $i<$dem[2]; $i++) {
            echo "<td>".$NDS[$i][3]."</td>";
        }
    echo "</tr>";
    echo "<tr>";
        echo "<th>Ecart</th>";
        for ($i=0; $i<$dem[2]; $i++) {
            if (!empty($NDS[$i][3])){
                $var = $NDS[$i][3]-$NDS[$i][2];
                echo "<td>".$var."</td>";
            }
            else{
                echo "<td></td>";
            }
        }
    echo "</tr>";
    echo "<tr>";
        echo "<th>Cumul</th>";
        for ($i=0; $i<$dem[2]; $i++) {
            if (!empty($NDS[$i][3])){
                if ($i==0) {
                    $var = $NDS[$i][3]-$NDS[$i][2];
                    echo "<td>".$var."</td>";
                }
                else{
                    $var = ($NDS[$i][3]-$NDS[$i][2])+$var;
                    echo "<td>".round($var,2)."</td>";
                }
            }
            else{
                echo "<td></td>";
            }
        }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    require_once ('../../../plugins/jpgraph-3.5.0b1/src/jpgraph.php');
    require_once ('../../../plugins/jpgraph-3.5.0b1/src/jpgraph_bar.php');




echo "<br></br>";

    echo "<div class='box box-primary'>";
    echo "<div class='box-header with-border'>";
    echo "<h3 class='col-xs-6 box-title'>Graph de synthèse</h3>";
    echo "</div>";
    echo "</div>";
    echo "<div class='box-body'>";
    
    echo "<script type='text/javascript'>";
    echo "CanvasJS.addColorSet('Test',
        [
        '#74a5c1',
        '#3c8dbc',
        '#00a65a',
        '#f56954'                
    ]);";
    echo "var chart = new CanvasJS.Chart('chartContainer', {";
      echo "colorSet: 'Test',";
        echo "animationEnabled: true,";
        echo "backgroundColor: '#f1f1f1',";
      echo "title:{";
        echo "text: 'Bilan des heures',";
        echo "fontSize: 30";
      echo "},";
      echo "toolTip: {";
        echo "shared: true";
      echo "},"; 
      echo "axisY: {";
        echo "title: 'Heures'";
      echo "},";
      echo "axisX: {";
        echo "title: 'Période'";
      echo "},";

      echo "legend:{";
        echo "fontFamily: 'Open sans',";
        echo "verticalAlign: 'top',";
        echo "horizontalAlign: 'center'";
      echo "},";
      echo "data: [";
      echo "{";
        echo "type: 'column',"; 
        echo "name: 'Heures prévues',";
        echo "legendText: 'Heures prévues',";
        echo "showInLegend: true, ";
        echo "dataPoints:[";
        for ($i=0; $i<$dem[2]-1; $i++) {
            if (!empty($NDS[$i][3])){
                echo "{label: '".$NDS[$i][1]."', y: ".$NDS[$i][2]." },";
                }
                else{
                echo "{label: '".$NDS[$i][1]."', y: 0 },";
                }
            }
            if (!empty($NDS[$i][3])){
                echo "{label: '".$NDS[11][1]."', y: ".$NDS[11][2]." }";
                }
                else{
                echo "{label: '".$NDS[11][1]."', y: 0 }";
                }
        echo "]";
      echo "},";
      echo "{";
        echo "type: 'column',"; 
        echo "name: 'Heures réalisées',";
        echo "legendText: 'Heures réalisées',";
        // echo "axisYType: 'secondary',";
        echo "showInLegend: true,";
        echo "dataPoints:[";
        for ($i=0; $i<$dem[2]-1; $i++) {
            if (!empty($NDS[$i][3])){
                echo "{label: '".$NDS[$i][1]."', y: ".$NDS[$i][3]." },";
                }
                else{
                echo "{label: '".$NDS[$i][1]."', y: 0 },";
                }
            }
            if (!empty($NDS[$i][3])){
                echo "{label: '".$NDS[11][1]."', y: ".$NDS[11][3]." }";
                }
                else{
                echo "{label: '".$NDS[11][1]."', y: 0 }";
                }
        echo "]";
      echo "},";
      echo "{";
        echo "type: 'line',"; 
        echo "name: 'Ecart',";
        echo "legendText: 'Ecart',";
        // echo "axisYType: 'secondary',";
        echo "showInLegend: true,";
        echo "dataPoints:[";
        for ($i=0; $i<$dem[2]-1; $i++) {
            if (!empty($NDS[$i][3])){
                $ecart = $NDS[$i][3]-$NDS[$i][2];
                echo "{label: '".$NDS[$i][1]."', y: ".$ecart." },";
                }
                else{
                echo "{label: '".$NDS[$i][1]."', y: 0 },";
                }
            }
            if (!empty($NDS[11][3])){
                $ecart = $NDS[11][3]-$NDS[11][2];
                echo "{label: '".$NDS[11][1]."', y: ".$ecart." }";
                }
                else{
                echo "{label: '".$NDS[11][1]."', y: 0 }";
                }
        echo "]";
      echo "},";
      echo "{";
                  echo "type: 'line',"; 
                  echo "name: 'Cumul',";
                  echo "legendText: 'Ecart cumulé',";
                  echo "showInLegend: true,";
                  echo "dataPoints:[";
                  $cumul=0;
                  for ($i=0; $i<$dem[2]-1; $i++) {
                      if (!empty($NDS[$i][3])){
                          $cumul = $NDS[$i][3]-$NDS[$i][2]+$cumul;
                          echo "{label: '".$NDS[$i][1]."', y: ".$cumul." },";
                          }
                          else{
                          echo "{label: '".$NDS[$i][1]."', y: 0 },";
                          }
                      }
                      if (!empty($NDS[11][3])){
                          $cumul = $NDS[11][3]-$NDS[11][2]+$cumul;
                          echo "{label: '".$NDS[11][1]."', y: ".$cumul." }";
                          }
                          else{
                          echo "{label: '".$NDS[11][1]."', y: 0 }";
                          }
                  echo "]";
                echo "}";
      echo "],";
          echo "legend:{";
            echo "cursor:'pointer',";
            echo "itemclick: function(e){";
              echo "if (typeof(e.dataSeries.visible) === 'undefined' || e.dataSeries.visible) {";
                echo "e.dataSeries.visible = false;";
              echo "}";
              echo "else {";
                echo "e.dataSeries.visible = true;";
              echo "}";
              echo "chart.render();";
            echo "}";
          echo "},";
        echo "});";

    echo "chart.render();";
echo "</script>";
echo "<div id='chartContainer' style='height: 400px; width: 100%;'></div>";

echo "</div>";


?>
 