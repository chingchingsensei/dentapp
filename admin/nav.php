<!--Navigation bar-->
  <nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">DENT<span>APP</span></a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="profile.php">Unavailable Dates</a></li>
          <li><a href="service.php">Services</a></li>
          <li><a href="patient.php">Clients</a></li>
          
          
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="calendar"><span class="glyphicon glyphicon-calendar"></span>&nbsp;Manage</a></li>
                <li><a href="profiledoc.php?user_id=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;Profile</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
        </ul>
      </div>
    </div>
  </nav>

