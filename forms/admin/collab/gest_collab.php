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

    $sql = "SELECT id, num, nom FROM departement ORDER BY num";
    $sth = $db->query($sql);
    $list_dep = $sth->fetchall();

    $myid = $_SESSION['auth']['myid'];

    $sql = "SELECT id, region FROM region ORDER BY region";
    $str = $db->query($sql);
    $list_reg = $str->fetchall();

    $sql = "SELECT id, profils FROM profils ORDER BY profils";
    $str = $db->query($sql);
    $list_profil = $str->fetchall();
?>
<!-- DATA TABLES -->
<link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Gestions des collaborateurs</h3>
      <h3 class="col-xs-6 box-title add" id="btn-add-collab" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>
    </div><!-- /.box-header -->
</div>

<!-- <div class="box box-primary">
    <form role="form" action="#" class="clients" id="clients">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <table align="center">
                        <tr>
                            <td width="90">Département</td>
                            <td width="100"><select name="departement" id="departement" class="departement">
                                <?php
                                global $list_dep;
                                echo "<option selected value='0'></option>";
                                foreach($list_dep as $row){
                                    echo "<option value=$row[0]>$row[1] - $row[2]</option>";
                                }
                                ?>
                                </select>
                            </td>
                            <td width="50"></td>
                            <td width="60">Région</td>
                            <td width="100"><select name="region" id="region" class="region">
                                <?php
                                global $list_reg;
                                echo "<option selected value='0'></option>";
                                foreach($list_reg as $row){
                                                echo "<option value=$row[0]>$row[1]</option>";
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div> -->


<div class="afficher container-fluid"></div>


<div class="modal fade" id="collab" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Nouveau collaborateur</h3>
            </div>
            <div class="modal-body">
                <form data-ajax="false">
                    <div class="col-xs-6">
                        <span>Civilité : </span>
                        <span><select class="form-control" name="civ" id="civ" type="civ">
                                <option></option>
                                <option>Mme</option>
                                <option>Melle</option>
                                <option>Mr</option>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span style='opacity:0'>
                            <input style='opacity:0' class="form-control" id="collab_id"></input>
                        </span>
                    </div>

                    <div class="col-xs-6">
                        <span>Nom : </span>
                        <span>
                            <input class="form-control" name="nom" id="nom" type="nom"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Prénom : </span>
                        <span>
                            <input class="form-control" name="prenom" id="prenom" type="prenom"></input>
                        </span>
                    </div>
                    
                    
                    <div class="col-xs-6">
                        <span>Fonction : </span>
                        <span>
                            <input class="form-control" name="fonction" id="fonction" type="fonction"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span style='opacity:0'>
                            <input style='opacity:0' class="form-control" id="collab_id"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Date d'embauche : </span>
                        <span>
                            <input class="form-control datepicker" name="arrivee" id="arrivee" value=""></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Date de sortie : </span>
                        <span>
                            <input class="form-control datepicker" id="depart" name="depart" value=""></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Loggin : </span>
                        <span>
                            <input class="form-control" name="loggin" id="loggin" type="loggin"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Mot de passe : </span>
                        <span>
                            <input class="form-control" name="passwd" id="passwd"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Profil d'accès :</span>
                        <span>
                            <select name="profil" id="profil" class="form-control profil">
                                <?php
                                global $list_profil;
                                echo "<option selected value='0'></option>";
                                foreach($list_profil as $row){
                                    echo "<option value=$row[0]>$row[1]</option>";
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span >
                            <input style='opacity:0' class="form-control" name="test"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-12">
                        <span>&nbsp;</span>
                    </div>
                    
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="bt_annul_collab" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary pull-right" id="bt_modif_collab">Enregistrer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.example-modal -->        
</div>    

<div class="modal fade" id="alert_collab" tabindex="-1" role="dialog">
    <div class="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Attention</h4>
          </div>
          <div class="modal-body">
            <p id="text_suppr_cli">One fine body&hellip;</p>
            <span style='opacity:0'><input id="id_suppr"></input></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="bt_alert_annul_collab">Annuler</button>
            <button type="button" class="btn btn-outline" id="bt_alert_suppr_collab">Suppr.</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<div class="modal fade" id="success_collab" tabindex="-1" role="dialog">
    <div class="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Opération réussie</h4>
          </div>
          <div class="modal-body">
            <p id="text_success_collab">One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="bt_success_collab">Ok</button>
            <!--<button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<script type="text/javascript" src="./forms/admin/collab/ctrl_gest_collab.js"></script>

<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'fr',
            autoclose: true
        });
      });
      
    
</script>


