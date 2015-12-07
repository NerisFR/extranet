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

  

  $sql = "SELECT DISTINCT clients.id as id_cli, clients.nom, (SELECT colors.ref
          FROM colors INNER JOIN (collaborateurs INNER JOIN (clients INNER JOIN color_client_collab ON clients.id = color_client_collab.id_client) ON collaborateurs.id = color_client_collab.id_collab) ON colors.id = color_client_collab.id_color
          WHERE (((clients.id)=id_cli) AND ((collaborateurs.id)=$myid))) FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)=$myid))";
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
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="//code.jquery.com/qunit/qunit-1.19.0.css">
<!-- Bootstrap 3.3.4 -->
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- FontAwesome 4.3.0 -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons 2.0.0 -->
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="./dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link href="./dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck -->
<link href="./plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
<!-- fullCalendar 2.2.5-->
<link href="./plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<link href="./plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" />

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Mes paramètres</h3>
    </div><!-- /.box-header -->
</div>




<div class="afficher container-fluid">
  <section class="content">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">Mes couleurs clients</h4>
                </div>
                <div class="box-body">
                  <!-- the events -->
                  <div id="external-events">
                    <?php
                      foreach($list_cli as $row){
                        echo "<div id='$row[0]' class='external-event col-xs-5' style='background-color:$row[2]'>$row[1]</div>";
                      }
                    ?>

                  </div>
                </div>
              </div>
             
            </div>
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


</div> <!-- /.Affichage du contenu -->
<!-- jQuery 2.1.4 -->
    <!--<script src="https://code.jquery.com/jquery-2.1.4.js"></script>-->
    <script src="./plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
     <!--Bootstrap 3.3.2 JS--> 
    <script src="./bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="./plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="./plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="./plugins/datatables/extensions/TableTools/js/dataTables.tableTools.js" type="text/javascript"></script>
    <script src="./plugins/datatables/extensions/Responsive/js/dataTables.responsive.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="./plugins/knob/jquery.knob.js" type="text/javascript"></script>
   
    <!-- datepicker -->
    <script src="./plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="./plugins/datepicker/locales/bootstrap-datepicker.fr.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="./plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="./plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="./plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src='./plugins/fullcalendar/lang/fr.js'></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- AdminLTE for demo purposes -->
  

  <script type="text/javascript" src="./forms/myspace/planning/ctrl_gest_planning.js"></script>
  
