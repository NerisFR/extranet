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
  $mynds = $_SESSION['auth']['nds'];
  $tod = date('Y-m-d');
  
  if ($mynds=="r"){
    $sql = "SELECT DISTINCT contrats.id AS id, clients.nom AS client, contrats.description AS contrat, contrats.numero, clients.id FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE contrats.date_fin_mission is NULL";
  }
  else{
      $sql = "SELECT contrats.id as id, clients.nom as client, contrats.description as contrat FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$myid') AND (((affect_cont_collab.fin)>'$tod') OR ((affect_cont_collab.fin) Is Null)))";
  }
  // $sql = "SELECT contrats.id as id, clients.nom as client, contrats.description as contrat FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$myid') AND (((affect_cont_collab.fin)>'$tod') OR ((affect_cont_collab.fin) Is Null)))";
  $stcli = $db->query($sql);
  $list_contrat = $stcli->fetchall();
  $nb_contrat = $stcli->rowCount();
  $collabid = $myid;
  $j=0;
  $tour = ceil($nb_contrat/4);
  ?>


<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class='item active'>
  <?php
    for ($l=0; $l<$tour; $l++) {
      if ($l<>0){
        echo "<div class='item'>";
      }
      
 
    for ($k=($l*4); $k<=($l*4+3); $k++) {
      if(isset($list_contrat[$j][0])){
        $id_cont = $list_contrat[$j][0];
        $nom_cli = $list_contrat[$j][1];
        $nom_contrat = $list_contrat[$j][2];
        $contratid = $list_contrat[$j][0];
        $NDS = array();
        $sql = "SELECT demarrage, base_sem, nb_mois FROM contrats WHERE contrats.id='$contratid'";
        $date = $db->query($sql);
        $dem = $date->fetch();
        $demarrage = $dem[0];
        $base_sem = $dem[1];
        $nb_mois = $dem[2];
        $annee_court = date('Y');
        $today = date('Y/m/d');
        $date_deb =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
        if ($date_deb > $today){
          $date_fin =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          $date_deb =  ($annee_court-1)."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          $annee_deb = ($annee_court-1);
          $annee_fin = ($annee_court);
        }
        else{
          $date_fin =  ($annee_court+1)."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          $date_deb =  $annee_court."/".date("m", strtotime($demarrage))."/".date("d", strtotime($demarrage));
          $annee_deb = ($annee_court);
          $annee_fin = ($annee_court+1);
        }
            if($nb_mois < 12){
        
        $req = "SELECT D.ANNEE, (SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), (SELECT Round((contrats.volume/$nb_mois),2) FROM contrats WHERE ((contrats.id)='$contratid')) AS prevu, N.Temps_realise
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
        $req = "SELECT D.ANNEE, (SELECT mois.nom_court FROM mois WHERE mois.id = D.MOIS), (If(D.MOIS=8,'0',If(D.MOIS=12,(SELECT Round(contrats.volume/$base_sem*3,2) FROM contrats WHERE ((contrats.id)='$contratid')),(SELECT Round((contrats.volume-contrats.volume/$base_sem*3)/10,2) FROM contrats WHERE (((contrats.id)='$contratid')))))) AS prevu, N.Temps_realise
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
        $NDS = $cli->fetchall();

        $cumul=0;
        for ($i=0; $i<11; $i++) {
            if (!empty($NDS[$i][3])){
                $cumul = $NDS[$i][3]-$NDS[$i][2]+$cumul;
            }
            if (!empty($NDS[11][3])){
                $cumul = $NDS[11][3]-$NDS[11][2]+$cumul;
            }
        }
      echo "<div class='col-lg-3 col-xs-3'>";
        if ($cumul>=0){
          echo "<div class='small-box bg-green'>";
        }
        else{
          echo "<div class='small-box bg-red'>";
        }
          echo "<div class='inner'>";
            echo "<p>$nom_cli</p>";
            echo "<p style='display:none' id='annee$id_cont'>$annee_deb - $annee_fin</p>";
            echo "<p style='text-overflow:ellipsis;white-space:nowrap;overflow: hidden;'>$nom_contrat</p>";
            echo "<h3>$cumul h.</h3>";
          echo "</div>";
          echo "<div class='icon'>";
            echo "<i class='glyphicon glyphicon-stats'></i>";
          echo "</div>";
          echo "<a href='#' class='small-box-footer details_hour' id='".$id_cont."'>Détails <i class='fa fa-arrow-circle-right'></i></a>";
        echo "</div>";
      echo "</div>";
      $j++;
    }
  }
  echo "</div>";
}
?>
  </div>
  <!-- Contrôles -->
  <a class="left carousel-control" href="#my_carousel" data-slide="prev">
  <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#my_carousel" data-slide="next">
  <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
  </div>

<script>
    $('.carousel').carousel({
        interval: 3000
    })
</script>