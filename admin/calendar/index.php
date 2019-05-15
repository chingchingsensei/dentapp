<?php
session_start();
  
  require_once '../class.user.php';
  $session = new USER();
  
  // if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
  // put this file within secured pages that users (users can't access without login)
  
  if(!$session->is_loggedin())
  {
    // session no set redirects to login page
    $session->redirect('../home.php');
  }

  $auth_user = new USER();
  
  
  $user_id = $_SESSION['user_session'];
  
  $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
  $stmt->execute(array(":user_id"=>$user_id));
  
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Tibiao-Dental</title>
  <link rel="stylesheet" href="css/fullcalendar.css" />
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/fullcalendar.min.js"></script>
  <link rel="icon" href="../../img/logo.png">
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    
    editable:true,
    header:{
     left:'prev,next,today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    displayEventTime: true,
    selectConstraint: {
        start: $.fullCalendar.moment().subtract(1, 'days'),
        end: $.fullCalendar.moment().startOf('month').add(1, 'month'),
    },

    defaultView: 'agendaWeek',

    viewRender: function(currentView){
    var minDate = moment(),
    maxDate = moment().add(2,'weeks');
    // Past
    if (minDate >= currentView.start && minDate <= currentView.end) {
      $(".fc-prev-button").prop('disabled', true); 
      $(".fc-prev-button").addClass('fc-state-disabled'); 
    }
    else {
      $(".fc-prev-button").removeClass('fc-state-disabled'); 
      $(".fc-prev-button").prop('disabled', false); 
    }
  },
    /*
    if (maxDate >= currentView.start && maxDate <= currentView.end) {
      $(".fc-next-button").prop('disabled', true); 
      $(".fc-next-button").addClass('fc-state-disabled'); 
    } else {
      $(".fc-next-button").removeClass('fc-state-disabled'); 
      $(".fc-next-button").prop('disabled', false); 
    } 
    },
*/
   

    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     var dates = $.fullCalendar.formatDate(start, "Y-MM-DD");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end, dates:start},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })
     }
    },

 

    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },
/*
    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    }, */
   });
  });
   
  </script>
 </head>
 <body>
  
  <h2 align="center"></h2>
  
  <div class="container">
    <a href="../" class="btn btn-green get-quote">Back to Home</a>
   <div id="calendar"></div>
  </div>
 </body>
</html>