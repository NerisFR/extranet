<?php
session_start();
$myid=$_SESSION['auth']['myid'];
$myadmin=$_SESSION['auth']['myadmin'];
$myusage=$_SESSION['auth']['nom_usage'];
$mynds=$_SESSION['auth']['nds'];
$mytdbhour=$_SESSION['auth']['tdbhour'];
$mytdbtask=$_SESSION['auth']['tdbtask'];
$myclient=$_SESSION['auth']['client'];
$mycontrat=$_SESSION['auth']['contrat'];
$mycollab=$_SESSION['auth']['collaborateur'];
$myaffect=$_SESSION['auth']['affectation'];
$mygprofil=$_SESSION['auth']['gest_profils'];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">

    <title>Extranet Neris | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="stylesheet" href="//code.jquery.com/qunit/qunit-1.19.0.css">
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <!--<link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />-->
    <!-- jvectormap -->
    <!--<link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />-->
    <!-- Date Picker -->
    <!--<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />-->
    <!-- Daterange picker -->
    <!--<link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />-->
    <!-- bootstrap wysihtml5 - text editor -->
    <!--<link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
    <link href="./plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- <link href="./font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
<link href="./dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <script type="text/javascript">
    var myid = "<?php print($myid);?>";
    var myadmin = "<?php print($myadmin);?>";
    var mynds="<?php print($mynds);?>";
    var mytdbhour="<?php print($mytdbhour);?>";
    var mytdbtask="<?php print($mytdbtask);?>";
    var myclient="<?php print($myclient);?>";
    var mycontrat="<?php print($mycontrat);?>";
    var mycollab="<?php print($mycollab);?>";
    var myaffect="<?php print($myaffect);?>";
    var mygprofil="<?php print($mygprofil);?>";
    
  </script>
  <body class="skin-blue fixed sidebar-mini">
    
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>N</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Neris</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- Tasks: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/user9-160x160.jpg" class="user-image" alt="User Image" />
                  <span class="hidden-xs"><?php echo $myusage ?></span>
                </a>
                <ul class="dropdown-menu user-options">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/user9-160x160.jpg" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $myusage ?>
                      <small>Membre depuis Nov. 2012</small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="myspace/options/gest_options.php" id='myoptions' class="btn btn-default btn-flat myoptions">Profil</a>
                    </div>
                    <div class="pull-right">
                      <a href="./forms/logout.php" class="btn btn-default btn-flat">Se deconnecter</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user9-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $myusage ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <!-- <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..." />
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div> -->
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <li class="active">
              <a href="dash.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="pull-right"></i>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Mon espace</span>
                <span class="fa fa-angle-left pull-right"></span>
              </a>
              <ul class="treeview-menu">
                <li><a class="subcontent" id="subcontent" href="nds/consult/consult.php"><i class="fa fa-circle-o"></i> Mes notes de synthèse</a></li>
                <li><a class="subcontent" id="subcontent" href="myspace/planning/gest_planning.php"><i class="fa fa-circle-o"></i> Mon planning</a></li>
                <!-- <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Mon véhicule</a></li> -->
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Tableaux de bord</span>
                <span class="fa fa-angle-left pull-right"></span>
              </a>
              <ul class="treeview-menu">
                <li><a class="subcontent" id="subcontent_tdbhour" href="tdb/hour/tdb_heures.php"><i class="fa fa-circle-o"></i> Suivi des heures</a></li>
                <li><a class="subcontent" id="subcontent_tdbtask" href="tdb/task/tdb_task.php"><i class="fa fa-circle-o"></i> Suivi des taches</a></li>
              </ul>
            </li>
            <li class="treeview"  id="myadmin">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Administration</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a class="subcontent" id="myclient" href="admin/client/gest_clients.php"><i class="fa fa-circle-o"></i> Gest. des clients</a></li>
                <li><a class="subcontent" id="mycontrat" href="admin/contrat/gest_contrats.php"><i class="fa fa-circle-o"></i> Gest. des contrats</a></li>
                <li><a class="subcontent" id="mycollab" href="admin/collab/gest_collab.php"><i class="fa fa-circle-o"></i> Gest. des collaborateurs</a></li>
                <li><a class="subcontent" id="myaffect" href="admin/affect/gest_affect.php"><i class="fa fa-circle-o"></i> Gest. des affectations</a></li>
                <li><a class="subcontent" id="myprofils" href="admin/profils/gest_profils.php"><i class="fa fa-circle-o"></i> Gest. des profils</a></li>
              </ul>
            </li>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Extranet
          </h1>
          <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content" id="content">
          
          <?php
            //session_start();
            require("auth.php");
            if(Auth::isLogged()){
              
            }
            else{
              header('Location:forms/404.php');
            }


            if(isset($_GET['p']) && preg_match("/^[a-z0-9]+$/i",$_GET['p'])){
              $p=$_GET['p'];
              if (file_exists("forms/$p.php")){
              include "forms/$p.php";
              }
              else{
              include "forms/404.php";
                }
              }
            else{
              include "forms/accueil.php";
            } 

          ?>

        </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            
        
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.2.0
        </div>
        <strong>Copyright &copy; 2015 <a href="http://www.neris.fr">Nérée Ingénierie Service</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <!-- <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">

          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <div class="modal fade" id="myspace" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-md">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h3 class="modal-title">Paramétrage</h3>
                      </div>
                      <div class="modal-body">
                                          
                      </div>
                  </div>
              </div>       
          </div>

<!--  -->

          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right" />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    
    <!-- jQuery 2.1.4 -->
    <!--<script src="https://code.jquery.com/jquery-2.1.4.js"></script>-->
    <script src="./plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="./plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
     <!--Bootstrap 3.3.2 JS--> 
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="plugins/datatables/extensions/TableTools/js/dataTables.tableTools.js" type="text/javascript"></script>
    <script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script>
   
    <!-- datepicker -->
    <script src="./plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="./plugins/datepicker/locales/bootstrap-datepicker.fr.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="./src/js/app.js"></script>
    <!-- fullCalendar 2.2.5 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
  <script src="./plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- AdminLTE for demo purposes -->
    
    <script type="text/javascript">
      $.widget.bridge('uibutton', $.ui.button);
    </script>
  </body>
</html>
