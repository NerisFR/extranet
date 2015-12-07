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
      <h3 class="col-xs-6 box-title">Mon planning</h3>
      <div id="ajout-nds">
        <h3 class="col-xs-6 box-title add" id="btn-add" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>
      </div>
    </div><!-- /.box-header -->
</div>




<div class="afficher container-fluid">
  <section class="content">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">Mes clients</h4>
                </div>
                <div class="box-body">
                  <!-- the events -->
                  <div id="external-events">
                    <?php
                      foreach($list_cli as $row){
                        echo "<div id='$row[0]' class='external-event' style='background-color:$row[2]'>$row[1]</div>";
                      }
                    ?>

                  </div>
                </div>
              </div>
             
            </div>
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
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
  



<script type="text/javascript">
      $(function () {
        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();

        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar(
      {
        /*
          header option will define our calendar header.
          left define what will be at left position in calendar
          center define what will be at center position in calendar
          right define what will be at right position in calendar
        */
        header:
        {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        /*
          defaultView option used to define which view to show by default,
          for example we have used agendaWeek.
        */
        defaultView: 'agendaWeek',

        /*
          selectable:true will enable user to select datetime slot
          selectHelper will add helpers for selectable.
        */
        selectable: true,
        selectHelper: true,
        firstDay: 1,
        weekends: true,
        businessHours:
        {
          start: '08:00', // a start time (10am in this example)
          end: '19:00',
          dow: [ 1, 2, 3, 4, 5]
        },

        /*
          when user select timeslot this option code will execute.
          It has three arguments. Start,end and allDay.
          Start means starting time of event.
          End means ending time of event.
          allDay means if events is for entire day or not.
        */
        select: function(start, end, allDay)
        {
          /*
            after selection user will be promted for enter title for event.
          */
          var title = prompt('Event Title:');
          /*
            if title is enterd calendar will add title and event into fullCalendar.
          */
          if (title)
          {
              start = start.format("YYYY-MM-D HH:mm:ss");
              end = end.format("YYYY-MM-D HH:mm:ss");
              alert(start);
              $.ajax({
                url: 'forms/myspace/planning/add_event.php',
                data: 'id_collab='+ myid+'&start='+ start +'&end='+ end ,
                type: "POST",
                datatype: "html",
                success: function(json) {
                  
                }
              });
            calendar.fullCalendar('renderEvent',
              {
                title: title,
                start: start,
                end: end,
                allDay: allDay
              },
              true // make the event "stick"
            );
          }
          calendar.fullCalendar('unselect');
        },
        /*
          events is the main option for calendar.
          for demo we have added predefined events in json object.
        */
        // events: "forms/myspace/planning/events.php",

        eventSources: [

        // your event source
          {
            url: 'forms/myspace/planning/events.php',
            type: 'POST',
            data: {
                custom_param1: 'id_client'
            },
            error: function() {
                alert('there was an error while fetching events!');
            }
          }
        ],

        // events: [
          // {
          //   title: 'All Day Event',
          //   start: new Date(y, m, 1)
          // },
          // {
          //   title: 'Long Event',
          //   start: new Date(y, m, d-5),
          //   end: new Date(y, m, d-2)
          // },
        // ],
        /*
          editable: true allow user to edit events.
        */
        editable: true,
        droppable: true,
        drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            var edate = $.fullCalendar.moment(date.format()).add('hours',3);
            copiedEventObject.end = edate;
            // copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");
            id_client = $(this).attr('id');
            // copiedEventObject.append( "<span class='closeon'>X</span>" );
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            
              start = date.format("YYYY-MM-D HH:mm:ss");
              end = edate.format("YYYY-MM-D HH:mm:ss");
              $.ajax({
                url: 'forms/myspace/planning/add_event.php',
                data: 'id_collab='+ myid+'&start='+ start +'&end='+ end +'&id_client='+ id_client ,
                type: "POST",
                datatype: "html",
                success: function(json) {
                  
                }
              });

            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
        },
        eventResize: function(event) {
          start = event.start.format("YYYY-MM-D HH:mm:ss");
          ends = event.end.format("YYYY-MM-D HH:mm:ss");
          $.ajax({
                url: 'forms/myspace/planning/update_event.php',
                data: 'id='+ event.id+'&start='+ start +'&end='+ ends,
                type: "POST",
                datatype: "html",
                success: function(json) {
                  alert(ends);
                }
              });

        },
        eventRender: function(event, element) {
            element.append( "<span  class='suppr_event btn-xs' style='background-color:#000; position:absolute; top:0; right:0'>X</span>" );
            element.find(".suppr_event").click(function() {
               $('#calendar').fullCalendar('removeEvents',event._id);
               $.ajax({
                  url: 'forms/myspace/planning/delete_event.php',
                  data: 'id='+ event.id ,
                  type: "POST",
                  datatype: "html",
                  success: function(json) {
                  }
              });
            });
            element.dblclick(function() {
               $('#calendar').fullCalendar('removeEvents',event._id);
               $.ajax({
                  url: 'forms/myspace/planning/delete_event.php',
                  data: 'id='+ event.id ,
                  type: "POST",
                  datatype: "html",
                  success: function(json) {
                  }
              });
            });
        }
    });

        // /* ADDING EVENTS */
        // var currColor = "#3c8dbc"; //Red by default
        // //Color chooser button
        // var colorChooser = $("#color-chooser-btn");
        // $("#color-chooser > li > a").click(function (e) {
        //   e.preventDefault();
        //   //Save color
        //   currColor = $(this).css("color");
        //   //Add color effect to button
        //   $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        // });
        // $("#add-new-event").click(function (e) {
        //   e.preventDefault();
        //   //Get value and make sure it is not null
        //   var val = $("#new-event").val();
        //   if (val.length == 0) {
        //     return;
        //   }

        //   //Create events
        //   var event = $("<div />");
        //   event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
        //   event.html(val);
        //   $('#external-events').prepend(event);

        //   //Add draggable funtionality
        //   ini_events(event);

        //   //Remove event from text input
        //   $("#new-event").val("");
        // });
        
      });
    </script>