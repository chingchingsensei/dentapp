 <?php
 session_start();  
 
 
if( !isset($_SESSION['username']) ) {
    header("Location: ../../");
    exit;
}
  
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Tibiao-Dental</title>
  <link rel="icon" href="../../img/logo.png">
  <link rel="stylesheet" href="css/fullcalendar.css" />
  <link rel="stylesheet" href="css/bootstrap.css" />
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/fullcalendar.min.js"></script> 

  <link rel="stylesheet" href="css/style.css" />

  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    
    editable:true,
    header:{
     left:'$(".fc-button").html("<a href=../index.php>BACK</a>")',
     center:'title',
     right:'prev,next,today' //month,agendaWeek,agendaDay
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    displayEventTime: true,
    selectConstraint: {
        start: $.fullCalendar.moment().subtract(1, 'days'),
        end: $.fullCalendar.moment().startOf('month').add(1, 'month'),
    },
     defaultView: 'month',

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
   
/*
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
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
  
  </nav>
  <h2 align="center">
   
</h2>
  <div class="container">
    <nav class="navbar navbar-default">
    <div class="navbar-header">
         <a href="../index.php" class="navbar-brand">DENT<span>APP</span></a>
    </div>
  </nav>
   <div id="calendar"></div>
  </div>
 </body>
</html>