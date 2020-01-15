<?php
include_once("class/Crud.php");
$crud = new Crud();
$country = $crud->getData("select id,country from country order by id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if((int) $_POST['country_id'] > 0) {
	$crud = new Crud();
	$username = $crud->escape_string($_POST['username']);
	$password = $crud->escape_string($_POST['password']);
	$result = $crud->login($username,hash('sha256', $password), (int) $_POST['country_id']);
	if ($result) {
		header('location:dashboard.php');
	}else{
		header('location:index.php?msg=1');
	}	
	}else{
		header('location:index.php?msg=1');
	}
	
}
?>
<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>Admin Panel</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
    <link rel="stylesheet" href="css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xxl">
      <a class="navbar-brand block" href="javascript:;">Admin Login</a>
      <section class="panel panel-default bg-white m-t-lg">
        <header class="panel-heading text-center">
          <strong>Sign in</strong>
        </header>
        <form method="post" class="panel-body wrapper-lg">
          <div class="form-group">
            <label class="control-label">Username</label>
            <input type="text" placeholder="" name="username" class="form-control input-lg">
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" id="inputPassword" name="password" placeholder="" class="form-control input-lg">
          </div>
           <div class="form-group">
            <label class="control-label">Country</label>
            <select name="country_id" class="form-control input-lg">
            <?php
            	foreach($country as $k => $v){
            		echo '<option value="'.$v['id'].'">'.strtoupper($v['country']).'</option>';
            	}
            ?>            	
            </select>
          </div>                   
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">     
    </div>
  </footer>
  <!-- / footer -->
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script> 
  <?php
	if (isset($_GET['msg'])) {	 ?>
	alert('Wrong User/Password/country');
  <?php }  ?>  		
   </script>
  
</body>
</html>