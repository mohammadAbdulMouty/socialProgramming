<?php
if(isset($navTop)){
  $navTop = 'navbar-fixed-top';
}else{
  $navTop = '';
}
$HomeActive = '';
$ProfileActive = '';
if(isset($ActiveHome)){
  $HomeActive = 'active';
}else if(isset($ActiveProfile)){
  $ProfileActive = 'active';
}
?>
<nav class="navbar navbar-default <?php echo $navTop?> bg-info">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><img src="logo.png"></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <form name="myform" method="GET" action="search.php" class="navbar-form navbar-left nav-bar-form-mid">
      <input type="hidden" name="p" value="0">
      <div class="form-group">
        <div class="container-search" onclick="myform.submit()" >
          <i class="fa fa-search"></i>
        </div>
        <input type="text" class="form-control searchinput" placeholder="Search" name="q" autocomplete="off">
        <i class="fa fa-angle-double-down show-check-div"></i>
        
        <div class="box-show">
        <input type="checkbox" id="box-1" name="ty" value="1" >
          <label for="box-1">name</label>
        
          <input type="checkbox" id="box-2" name="ty" value="2">
          <label for="box-2">Group</label>
          <input type="checkbox" id="box-5" name="ty" value="5">
          <label for="box-5">Code</label>
            
        </div><!--end div.box-show-->
      </div>
      
    </form>
    <ul class="nav navbar-nav navbar-left navbar-slid">
      <li class="nav-item <?= $ProfileActive ?>"><a href="#"><span class="glyphicon glyphicon-user" ></span> Profile</a></li>
      <li class="nav-item newGroup"><a href="#"><i class="fa fa-group"></i>New Group</a></li>
      <li class="nav-item "><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>LogOut</a></li>
      
      
    </ul>
  </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
<div class="search-AutoComplete"></div>