<?php
	setlocale(LC_TIME, "fr_FR");
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
	$contratid = $_POST['contrat_id'];
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
echo json_encode($annees);
?>