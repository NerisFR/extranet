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

  $today = date("Y-m-d");
  $myadmin=$_SESSION['auth']['myadmin'];
  $myid = $_SESSION['auth']['myid'];
  if ($myadmin == 1){
    $sql = "SELECT id, nom_usage FROM collaborateurs  ORDER BY nom_usage ";
  }
  else{
    $sql = "SELECT id, nom_usage FROM collaborateurs Where ((collaborateurs.debauche > '$today') OR (collaborateurs.debauche IS NULL)) ORDER BY nom_usage ";
  }
	
    $sth = $db->query($sql);
  $list_collab = $sth->fetchall();

  

  $sql = "SELECT DISTINCT clients.id, clients.nom FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$myid'))";
  $stcli = $db->query($sql);
  $list_cli = $stcli->fetchall();

  $sql = "SELECT date_format(heures.heures, '%H:%i') FROM heures";
  $sth = $db->query($sql);
  $list_h = $sth->fetchall();
?>

<link rel="stylesheet" type="text/css" href="./src/css/app-new.css">
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- <link href="./font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
<link href="./dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />

<!-- DATA TABLES -->
<link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Mes notes de syntheses</h3>
      <div id="ajout-nds">
        <h3 class="col-xs-6 box-title add" id="btn-add" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>
      </div>
    </div><!-- /.box-header -->
</div>


<div class="box box-primary">
    <form role="form" action="#" class="consultNDS" id="consultNDS">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-3">Collaborateur :</div>
                    <div class="col-xs-3">
                        <select name="collab_consult" id="collab_consult" class="collab_consult">
                          <?php
                            $myid = $_SESSION['auth']['myid'];
                            global $list_collab;
                            echo "<option value=0>Tous</option>";
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
                        <select name="contrat_consult" id="contrat_consult" class="contrat_consult" > 
                          <option value="0"> </option>
                        </select>
                    </div>
                </div>    
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-3">Client :</div>
                    <div class="col-xs-3">
                        <select name="client_consult" id="client_consult" class="client_consult">
                        <option value="0">             </option>
                        <?php
                                global $list_cli;
                                foreach($list_cli as $row){
                                      echo "<option value=$row[0]>$row[1]</option>";
                                }
                          ?>
                        </select>
                    </div>
                    <div class="col-xs-3">Type d'heures :</div>
                    <div class="col-xs-3">
                        <select name="type_heure_consult" id="type_heure_consult" class="type_heure_consult">
                            <option>Extra Time</option>
                            <option selected>Normale</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6" style="text-align: right; vertical-align:middle">
                        <div class="col-xs-offset-5 col-xs-4">Comprise entre le </div>
                        <div class="col-xs-3 input-group">
                            <input name="date_debut" class="form-control datepicker date_debut" id="date_debut" value="<?php echo date("d/m/Y", strtotime('-1 month')); ?>"></input>
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6" style="text-align: left">
                        <div class="col-xs-2"> et le </div>
                        <div class="col-xs-3 input-group">
                            <input name="date_fin" class="form-control datepicker date_fin" id="date_fin" value="<?php echo date("d/m/Y"); ?>"></input>
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div  class="col-xs-offset-5 col-xs-2 text-center">
                <a type="button" class="btn btn-block btn-primary" id="bt_affich_consult">Afficher</a>
            </div>
                
                
        </div>
    </form>
</div>

<div class="afficher container-fluid"></div> <!-- /.Affichage du contenu -->

<div class="modal fade" id="saisie" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Nouvelle note de synthese</h3>
        </div>
        <div class="modal-body">
            <form id="saisie_nds" class="saisie_nds" data-ajax="false">
              <!-- <div class="reussi" id="reussi" style='width:700px'></div> -->
              <div class="col-xs-12">
                <h4 class="modal-title">Renseignement administratif</h4>
                <span style='opacity:0'><input id="num_id"></input></span>
              </div>

              <div class="col-xs-6">
                <span>Collab. : </span>
                <span><select required name="collab" id="collab" class="form-control collab">
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
                  </select></span>
              </div>
              <div class="col-xs-6">
                  <span>Date : </span>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control datepicker pull-right" id="jour" value="<?php echo date("d/m/Y"); ?>" />
                  </div>
              </div>
                 

              <div class="col-xs-6">
                <span>Client :</span>
                <span><select name="client" id="client" class="form-control client" required>
                  <option value="">             </option>
                  <?php
                        global $list_cli;
                        foreach($list_cli as $row){
                            echo "<option value=$row[0]>$row[1]</option>";
                        }
                    ?>
                  </select></span>
              </div>
              <div class="col-xs-6">
                <span>Heure d'arrivée :</span>
                <span><select name="h_debut" id="h_debut" class="form-control h_debut">
                  <?php
                        global $list_h;
                        foreach($list_h as $row){
                          if ($row[0]=="09:00") {
                            echo "<option selected value=$row[0]>$row[0]</option>";
                          }
                              else {
                                echo "<option value=$row[0]>$row[0]</option>";
                              }
                        }
                    ?>
                  </select></span>
              </div>

              <div class="col-xs-6">
                <span>Contrat :</span>
                <span><select name="contrat" id="contrat" class="form-control contrat" required>
                  <option>             </option>
                  </select>
                </span>
              </div>
              <div class="col-xs-6">
                <span>Heure de départ :</span>
                <span><select name="h_fin" id="h_fin" class="form-control h_fin">
                  <?php
                        global $list_h;
                        foreach($list_h as $row){
                          if ($row[0]=="17:00") {
                            echo "<option selected value=$row[0]>$row[0]</option>";
                          }
                              else {
                                echo "<option value=$row[0]>$row[0]</option>";
                              }
                        }
                    ?>
                  </select>
                </span>
              </div>

              <div class="col-xs-6">
                <span>Type d'heure :</span>
                <span><select required name="type_heure" id="type_heure" class="form-control type_heure">
                  <option>Extra Time</option>
                  <option selected>Normale</option>
                  </select></span>
              </div>
              <div class="col-xs-6">
                <span>&nbsp;</span>
                <span>&nbsp;</span>
              </div>

              <div class="col-xs-12">
                <h4 align="center" class="col-xs-6">Actions réalisées</h4>
                <h4 align="center" class="col-xs-6">Maintenance technique</h4>
              </div>

              <div  class="row">
                <div class="col-xs-2">
                  <span>Admin. syst. :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_ADM" type="numeric" id="TPS_ADM" class="TPS_ADM" size="4" placeholder="0,00" pattern="\d+(.\d{2})?" required/></span>
                </div>
                <div class="col-xs-2">
                  <span>Suivi de projet :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_PROJ" type="text" id="TPS_PROJ" class="TPS_PROJ" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div align="center" class="col-xs-6">
                  <span>Serveur</span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Maintenance : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_MAINT" type="text" id="TPS_MAINT" class="TPS_MAINT" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-2">
                  <span>Etude &amp; dev. :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_DEV" type="text" id="TPS_DEV" class="TPS_DEV" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-3">
                  <!-- <span style='width:20px'>&nbsp;</span> -->
                  <span><input type="checkbox" name="CTRL_LOG" id="CTRL_LOG" class="CTRL_LOG" value="true" />
                    <label for="CTRL_LOG">Contrôle Log </label></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_MAJ_OS" id="CTRL_MAJ_OS" class="CTRL_MAJ_OS" value="true"/>
                    <label for="CTRL_LOG">MAJ OS</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Suivi de parc :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_PARC" type="text" id="TPS_PARC" class="TPS_PARC" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-2">
                  <span>Réunion :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_REUNION" type="text" id="TPS_REUNION" class="TPS_REUNION" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_HDD" id="CTRL_HDD" class="CTRL_HDD" value="true"/>
                    <label for="CTRL_LOG2">Disques</label></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_MAJ_HARD" id="CTRL_MAJ_HARD" class="CTRL_MAJ_HARD" value="true"/>
                    <label for="CTRL_LOG5">MAJ Hard</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Etudes de prix : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_PRIX" type="text" id="TPS_PRIX" class="TPS_PRIX" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-2">
                  <span>Déplacement : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_DEP" type="text" id="TPS_DEP" class="TPS_DEP" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_RAID" id="CTRL_RAID" class="CTRL_RAID" value="true"/>
                    <label for="CTRL_LOG3">RAID</label></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_MAJ_SOFT" id="CTRL_MAJ_SOFT" class="CTRL_MAJ_SOFT" value="true"/>
                    <label for="CTRL_LOG6">MAJ Logiciel</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Inst. / param. : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_INST" type="text" id="TPS_INST" class="TPS_INST" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-2">
                  <span>Ctrl journalier : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_CTRL" type="text" id="TPS_CTRL" class="TPS_CTRL" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div align="center" class="col-xs-3">
                  <span align="center">Sauvegarde</span>
                </div>
                <div align="center" class="col-xs-3">
                  <span >Antivirus</span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Assist. utilisat. :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_ASSIST" type="text" id="TPS_ASSIST" class="TPS_ASSIST" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-2">
                  <span>Autre : </span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_AUTRE" type="text" id="TPS_AUTRE" class="TPS_AUTRE" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_BACKUP" id="CTRL_BACKUP" class="CTRL_BACKUP" value="true"/>
                    <label for="CTRL_LOG7">Vérification</label></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="CTRL_ANTIVIRUS" id="CTRL_ANTIVIRUS" class="CTRL_ANTIVIRUS" value="true" />
                    <label for="CTRL_LOG10">Vérification</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <span>Formation :</span>
                </div>
                <div class="col-xs-1">
                  <span><input name="TPS_FORM" type="text" id="TPS_FORM" class="TPS_FORM" size="4" placeholder="0,00" pattern="\d+(.\d{2})?"/></span>
                </div>
                <div class="col-xs-3 col-xs-offset-3">
                  <span><input type="checkbox" name="VOLUM_BACKUP" id="VOLUM_BACKUP" class="VOLUM_BACKUP" value="true" />
                  <label for="CTRL_LOG8">Volumétrie</label></span>
                </div>
                <div class="col-xs-3">
                  <span><input type="checkbox" name="MAJ_ANTIVIRUS" id="MAJ_ANTIVIRUS" class="MAJ_ANTIVIRUS" value="true" />
                  <label for="CTRL_LOG11">Mise à jour</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-offset-6">
                </div>
                <div class="col-xs-3 col-xs-offset-6">
                  <span><input type="checkbox" name="MAJ_BACKUP" id="MAJ_BACKUP" class="MAJ_BACKUP" value="true"/>
                  <label for="CTRL_LOG9">Mise à jour</label></span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-3">
                  <span>Commentaires</span>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <span align="center"><textarea name="comment" id="comment" class="comment col-xs-12" style="color:#000" rows="3"></textarea></span>
                </div>
              </div>
                <!-- <div align="center" style='line-height:20px;vertical-align:center'>
                    <input type="submit" width="50" height="20" id="bt_modif" class="bt_modif" style="border:3px solid;border-radius : 24px;" value="Mettre à jour"></input>
                </div> -->
            
            <!-- </div> -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" id="bt_annul" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" id="bt_impr">Imprimer</button>
            <button type="submit" class="btn btn-primary" id="bt_modif">Enregistrer</button>
            <button type="submit" style="opacity:0" class="btn btn-primary" id="bt_del">Supprimer</button>
          </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.example-modal -->

<div class="modal fade" id="alert" tabindex="-1" role="dialog">
    <div class="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Attention</h4>
          </div>
          <div class="modal-body">
            <p id="text_suppr">One fine body&hellip;</p>
            <span style='opacity:0'><input id="id_suppr"></input></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="bt_alert_annul">Annuler</button>
            <button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<div class="modal fade" id="success" tabindex="-1" role="dialog">
    <div class="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Opération réussie</h4>
          </div>
          <div class="modal-body">
            <p id="text_success">One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="bt_alert_annul">Ok</button>
            <!--<button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

  
  <script type="text/javascript" src="./forms/nds/consult/ctrl.js"></script>
  
  


<script type="text/javascript">
    $(function () {

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            endDate: "today",
            language: 'fr',
            autoclose: true
        });
      });
      
    
</script>
