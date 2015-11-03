<?php
    session_start();
    require("../../../auth.php");
    if(Auth::isLogged()){
      
    }
    else{
      header('Location:forms/404.php');
    }

  include '../../functions.php';
  global $db;

	$sql = "SELECT id, nom_usage FROM collaborateurs ORDER BY nom_usage";
	$sth = $db->query($sql);
  $list_collab = $sth->fetchall();

  $myid = $_SESSION['auth']['myid'];

  $sql = "SELECT DISTINCT clients.id, clients.nom FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$myid'))";
  $stcli = $db->query($sql);
  $list_cli = $stcli->fetchall();
?>

    <div class="box box-primary" id="zone-hour">
        <div class="box-header with-border">
            <h3 class="box-title">Paramètres</h3><i class="pull-right fa fa-fw fa-chevron-down" style="cursor:Pointer;text-align: right;" id="icon-hour"/>
        </div><!-- /.box-header -->
    <!--</div> /.box-header -->
<!--    <form role="form" action="#" class="consultNDS" id="consultNDS">-->
    <div class="box-body"  id="table-hour">
        <form role="form" action="#" class="consultNDS" id="consultNDS">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3">Collaborateur :</div>
                <div class="col-xs-3">
                    <select name="collab_consult" id="collab_tdbh" class="collab_tdbh">
                      <?php
                        $myid = $_SESSION['auth']['myid'];
                        global $list_collab;
                        foreach($list_collab as $row){
                          if($row[0]==$myid){
                              echo '<option value='.$row[0].' selected="selected">'.$row[1].'</option>';
                             }
                            else{
                              echo "<option value=$row[0]>$row[1]</option>";
                              }
                            }
                      ?>
                    </select>
                </div>
                <div class="col-xs-3">Contrat :</div>
                <div class="col-xs-3">
                    <select name="contrat" id="contrat_tdbh" class="contrat_tdbh" > 
                      <option value="0"> </option>
                    </select>
                </div>
            </div>    
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3">Client :</div>
                <div class="col-xs-3">
                    <select name="client" id="client_tdbh" class="client_tdbh">
                    <option value="0">             </option>
                    <?php
                        global $list_cli;
                        foreach($list_cli as $row){
                            echo "<option value=$row[0]>$row[1]</option>";
                        }
                      ?>
                    </select>
                </div>
                <div class="col-xs-3">Année :</div>
                <div class="col-xs-3">
                    <select name="annee" id="annee_tdbh" class="annee_tdbh" style="width:195px"> 
                        <option> </option>
                    </select>
                </div>
            </div>
        </div>
        <div  class="col-xs-offset-5 col-xs-2 text-center">
            <a type="button" class="btn btn-block btn-primary" id="bt_affich">Afficher</a>
        </div>
        </form>
    </div>
    </div>

<br></br>

<div class="afficher"></div> <!-- /.Affichage du contenu -->

<script type="text/javascript" src="./forms/tdb/hour/ctrl_tdb_heures.js"></script>
