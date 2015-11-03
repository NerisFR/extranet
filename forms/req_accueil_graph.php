<?php
  session_start();
  setlocale(LC_TIME, "fr_FR");
  try {
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  catch(PDOException $e)
    {
    echo $e->getMessage();
    }
  
  // $myid = mysql_real_escape_string($_POST['collab_id']);
  $myid = $_SESSION['auth']['myid'];
  $sql = "SELECT contrats.id as id, clients.nom as client, contrats.description as contrat FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$myid'))";
  $stcli = $db->query($sql);
  $list_contrat = $stcli->fetchall();
  $nb_contrat = $stcli->rowCount();
  
  $collabid = $myid;

    $j=0;
    $tour = (round($nb_contrat/2, 0, PHP_ROUND_HALF_UP));
    for ($k=0; $k<$nb_contrat; $k++) {

      $id_cont = $list_contrat[$j][0];
      $nom_cli = $list_contrat[$j][1];
      $nom_contrat = $list_contrat[$j][2];
      echo "<div>";

          $contratid = $list_contrat[$j][0];
          $NDS = array();
          $sql = "SELECT demarrage FROM contrats WHERE contrats.id='$contratid'";
          $date = $db->query($sql);
          $dem = $date->fetch();
          $demarrage = $dem[0];
          $annee_court = date('Y');
          $today = date('Y/m/d');
          $date_deb =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          if ($date_deb > $today){
            $date_fin =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
            $date_deb =  ($annee_court-1)."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          }
          else{
            $date_fin =  ($annee_court+1)."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
            $date_deb =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          }
              $req = "SELECT D.ANNEE, (SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), (If(D.MOIS=8,'0',If(D.MOIS=12,(SELECT Round(contrats.volume/45*3,2) FROM contrats WHERE ((contrats.id)='$contratid')),(SELECT Round((contrats.volume-contrats.volume/45*3)/10,2) FROM contrats WHERE (((contrats.id)='$contratid')))))) AS prevu, N.Temps_realise
          FROM (
                  SELECT MONTH(calendrier.Jour) AS MOIS, Year(calendrier.Jour) AS ANNEE
                  FROM calendrier 
                  WHERE ((calendrier.Jour) BETWEEN '$date_deb' AND '$date_fin') 
                  GROUP BY Month(calendrier.Jour), Year(calendrier.Jour) 
                  ORDER BY Year(calendrier.Jour), MONTH(calendrier.Jour) ASC) AS D 
              LEFT JOIN (
                  SELECT MONTH(nds.Jour) AS MOIS, Year(nds.Jour) AS ANNEE, If(isnull(Sum(nds.TPS_TOTAL)),0,Sum(nds.TPS_TOTAL)) AS Temps_realise
                  FROM (clients INNER JOIN contrats ON clients.Id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_Affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat
                  WHERE (((contrats.id)='$contratid') AND ((nds.Jour) BETWEEN '$date_deb' AND '$date_fin') AND (nds.type_heure='Normale'))
                  GROUP BY Month(nds.Jour), Year(nds.Jour)) AS N 
              ON (D.ANNEE=N.ANNEE) AND (D.MOIS=N.MOIS)
          ORDER BY D.ANNEE, D.MOIS;" or die (mysql_error());

          $cli = $db->query($req);
          $NDS = $cli->fetchall();
          
          echo "<script type='text/javascript'>";
                echo "CanvasJS.addColorSet('Test',
                [
                '#74a5c1',
                '#3c8dbc',
                '#00a65a',
                '#f56954'                
                ]);";
          
          
          
              echo "var chart = new CanvasJS.Chart('chartContainer$id_cont', {";
                echo "colorSet: 'Test',";
                  echo "animationEnabled: true,";
                echo "toolTip: {";
                  echo "shared: true";
                echo "},"; 
                echo "axisY: {";
                  echo "title: 'Heures'";
                echo "},";
                echo "axisX: {";
                  echo "title: 'Du $date_deb au $date_fin'";
                echo "},";

                echo "legend:{";
                  echo "verticalAlign: 'top',";
                  echo "horizontalAlign: 'center'";
                echo "},";
                echo "data: [";
                echo "{";
                  echo "type: 'column',"; 
                  echo "name: 'Heures prévues',";
//                  echo "legendText: 'Heures prévues',";
//                  echo "showInLegend: true, ";
                  echo "dataPoints:[";
                  for ($i=0; $i<11; $i++) {
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
//                  echo "legendText: 'Heures réalisées',";
                  // echo "axisYType: 'secondary',";
//                  echo "showInLegend: true,";
                  echo "dataPoints:[";
                  for ($i=0; $i<11; $i++) {
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
//                  echo "legendText: 'Ecart',";
                  // echo "axisYType: 'secondary',";
//                  echo "showInLegend: true,";
                  echo "dataPoints:[";
                  for ($i=0; $i<11; $i++) {
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
                  echo "dataPoints:[";
                  $cumul=0;
                  for ($i=0; $i<11; $i++) {
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
      echo "<section class='col-lg-3 connectedSortable'>";
        echo "<div class='box box-primary'>";
            echo "<div class='box-header'>";
//                echo "<i class='ion ion-clipboard'></i>";
                echo "<h3 class='box-title'>$nom_cli - $nom_contrat</h3>";
            echo "</div>";
            echo "<div class='box-body'>";
                echo "<div id='chartContainer$id_cont' style='position: relative; height: 200px;'></div>";
            echo "</div>";
        echo "</div>";
    echo "</section>";
    $j++;
          
    }
    
  ?>
<!--<script src='dist/js/pages/dashboard.js' type='text/javascript'></script>-->
<script type='text/javascript'>
$(function () {

  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  });
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
});
</script>