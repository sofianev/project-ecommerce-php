<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categores.php"><?php echo lang('Categories') ?></a></li>
        <li><a href="item.php"><?php echo lang('ITMES') ?></a></li>
        <li><a href="members.php?"><?php echo lang('MEMBERS') ?></a></li>
        <li><a href="#"><?php echo lang('STATISTICS') ?></a></li>
        <li><a href="#"><?php echo lang('LOGS') ?></a></li>
      </u>
      
        
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">sofiane <span class="caret">
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userID=<?php echo $_SESSION['userID']?>">Edit Profile</a></li>
            <li><a href="#">Settinges</a></li>
            <li><a href="logout.php">Logout</a></li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>