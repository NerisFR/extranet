<?php
    setlocale(LC_TIME, "fr_FR");
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $NDS = array();
    // $collabid = $_POST['collab_id'];
    // $clientid = $_POST['client_id'];
    $contratid = 3;
    $annees = "2015";
    $sql = "SELECT demarrage, base_sem, nb_mois FROM contrats WHERE contrats.id='$contratid'";
    $date = $db->query($sql);
    $dem = $date->fetch();
    $demarrage = $dem[0];
    $base_sem = $dem[1];
    $nb_mois = $dem[2];


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

        
    var_dump($req);
    $cli = $db->query($req);

    $NDS = $cli->fetchall();


    echo "<div class='box box-primary'>";
    echo "<div class='box-header with-border'>";
    echo "<h3 class='col-xs-6 box-title'>Données de synthèse</h3><i class='pull-right fa fa-fw fa-chevron-down' style='cursor:Pointer;text-align: right;' id='icon-bilan-hour'/>";
    echo "</div>";
    echo "</div>";
    echo "<div class='box-body' id='table-bilan-hour'>";
    echo "<table>";
    echo "<tr width='40' height='35'>";
        echo "<th width='150'>Période</th>";
        for ($i=0; $i<$nb_mois; $i++) {
            $var = $NDS[$i][1]." ".$NDS[$i][0];
            echo "<td width='50'>".$var."</td>";
        }
    echo "</tr>";
    echo "<tr width='40' height='25'>";
        echo "<th width='150'>Heures prévues</th>";
            for ($i=0; $i<$nb_mois; $i++) {
                echo "<td width='50'>".$NDS[$i][2]."</td>";
            }
    echo "</tr>";
    echo "<tr width='40' height='25'>";
        echo "<th width='150'>Heures réalisées</th>";
        for ($i=0; $i<$nb_mois; $i++) {
            echo "<td width='50'>".$NDS[$i][3]."</td>";
        }
    echo "</tr>";
    echo "<tr width='40' height='25'>";
        echo "<th width='150'>Ecart</th>";
        for ($i=0; $i<$nb_mois; $i++) {
            if (!empty($NDS[$i][3])){
                $var = $NDS[$i][3]-$NDS[$i][2];
                echo "<td width='50'>".$var."</td>";
            }
            else{
                echo "<td width='50'></td>";
            }
        }
    echo "</tr>";
    echo "<tr width='40' height='25'>";
        echo "<th width='150'>Cumul</th>";
        for ($i=0; $i<$nb_mois; $i++) {
            if (!empty($NDS[$i][3])){
                if ($i==0) {
                    $var = $NDS[$i][3]-$NDS[$i][2];
                    echo "<td width='50'>".$var."</td>";
                }
                else{
                    $var = ($NDS[$i][3]-$NDS[$i][2])+$var;
                    echo "<td width='50'>".round($var,2)."</td>";
                }
            }
            else{
                echo "<td width='50'></td>";
            }
        }
    echo "</tr>";
    echo "</table>";
//    echo "</td>";
//    echo "<td>";
//    echo "<table>";  
//    echo "</table>";
//    echo "</td>";
//    echo "</table>";
    echo "</div>";


    $annees = array();
    $sql="SELECT contrats.demarrage, contrats.base_sem, contrats.nb_mois FROM contrats WHERE contrats.id='".$contratid."'";
    $date_dem = $db->query($sql);
    $dem = $date_dem->fetch();
    $demarrage = $dem[0];
    $base_sem = $dem[1];
    $nb_mois = $dem[2];
    $annee_dem = intval(date("Y", strtotime($demarrage)));
    $mois_dem = intval(date("m", strtotime($demarrage)));

    $mois_courant = intval(date("m"));

    //si le mois de démarrage est janvier
    if($mois_dem == 1){
        $j=0;
        for($i=date("Y");$i>=$annee_dem;$i--){
            $annees[$j]=$i;
            $j++;
        }
    }
    //si le mois de démarrage est sup. au mois courant (annee N-1 et N)
    elseif($mois_dem > $mois_courant){
        if($nb_mois <> 12){
            $j=0;
            if(($mois_dem+$nb_mois) <= 13){
                for($i=date("Y");$i>=$annee_dem;$i--){
                    $annees[$j]=$i;
                    $j++;
                }
            }
            else{
                for($i=date("Y");$i>=$annee_dem;$i--){
                    $annees[$j]=($i-1)." - ".$i;
                    $j++;
                }
            } 
        }
        else{
            $j=0;
            for($i=date("Y");$i>=$annee_dem;$i--){
                $annees[$j]=($i-1)." - ".$i;
                $j++;
            } 
        }
    }
    //si le mois de démarrage est inf. au mois courant (annee N et N+1)
    else {
        if($nb_mois <> 12){
            $j=0;
            if(($mois_dem+$nb_mois) <= 13){

                for($i=date("Y");$i>=$annee_dem;$i--){
                    $annees[$j]=$i;
                    $j++;
                }
            }
            else{
                for($i=date("Y");$i>=$annee_dem;$i--){
                    $annees[$j]=$i." - ".($i+1);
                    $j++;
                }
            }
        }
        else{
            $j=0;
            for($i=date("Y");$i>=$annee_dem;$i--){
                $annees[$j]=$i." - ".($i+1);
                $j++;
            } 
        }
    }

    var_dump($annees);
    ?>