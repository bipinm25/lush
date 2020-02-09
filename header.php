<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('admin_panel/class/Crud.php');
$crud = new Crud();
$crud->getCountry();
if(!empty($_SESSION['country_list'])) {
	foreach($_SESSION['country_list'] as $k=>$v){
		$c_ids[]=$v['id'];
	}
}
$country_id=0;
if(isset($_SESSION['country']) && $_SESSION['country'] > 0 ){
	$country_id = (int) $_SESSION['country'];
}
else{
	header("location:location.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#3ed2a7">
	<link rel="shortcut icon" href="favicon.png" />
	<title>LUSH - For the beautifull heart</title>
	<link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff%7cLato&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/vendors/liquid-icon/liquid-icon.min.css" />
	<link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/theme-vendors.min.css" />
	<link rel="stylesheet" href="assets/css/theme.min.css" />
	<link rel="stylesheet" href="assets/css/themes/restaurant.css" />

	<script async src="assets/vendors/modernizr.min.js"> </script>
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function() {
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5dd245abd96992700fc7ebf1/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
	})();
</script>
<!--End of Tawk.to Script-->
<body data-mobile-nav-trigger-alignment="right" data-mobile-nav-align="left" data-mobile-nav-style="classic" data-mobile-nav-shceme="gray" data-mobile-header-scheme="gray" data-mobile-nav-breakpoint="1199">
<div id="wrap">
<header class="main-header main-header-overlay">
	<div class="mainbar-wrap">
		<div class="megamenu-hover-bg"></div>
		<div class="container-fluid mainbar-container">
			<div class="mainbar">
				 <div class="row mainbar-row align-items-lg-stretch px-5">
<div class="col">

</div>
<div class="col-auto">
<div class="collapse navbar-collapse" id="main-header-collapse">
<ul id="primary-nav" class="main-nav nav main-nav-hover-fade-inactive align-items-lg-stretch justify-content-lg-start" data-submenu-options='{ "toggleType":"fade", "handler":"mouse-in-out" }'>
<li>
<a href="index.php"><span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Home
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
<li>
<a href="about_lush.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
About
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
<li>
<a href="flowers.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Flowers<br>
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
</ul>
</div>
<div class="navbar-header">
<a class="navbar-brand" href="index.php" rel="home">
<span class="navbar-brand-inner">
<img class="mobile-logo-default" src="assets/img/logo/restaurant-dark.png" srcset="./assets/img/logo/restaurant-dark@2x.png 2x" alt="LUSH - order gifts online in Kerala, Kannur, Kochi">
<img class="logo-default" src="assets/img/logo/restaurant-light.png" srcset="./assets/img/logo/restaurant-light@2x.png 2x" alt="LUSH - order gifts online in Kerala, Kannur, Kochi"></span></a>
<button type="button" class="navbar-toggle collapsed nav-trigger style-mobile" data-toggle="collapse" data-target="#main-header-collapse" aria-expanded="false" data-changeclassnames='{ "html": "mobile-nav-activated overflow-hidden" }'>
<span class="sr-only">Toggle navigation</span>
<span class="bars">
<span class="bar"></span>
<span class="bar"></span>
<span class="bar"></span></span></button>
</div>
<div class="collapse navbar-collapse" id="main-header-collapse">
<ul id="primary-nav" class="main-nav nav main-nav-hover-fade-inactive align-items-lg-stretch justify-content-lg-start" data-submenu-options='{ "toggleType":"fade", "handler":"mouse-in-out" }'>
<li>
<a href="cakes.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Cakes
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
<li>
<a href="giftboxes.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Gift Box
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
	
	<li>
<a href="chocolates.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Chocolates
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>

	<li>
<a href="contact.php">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
Contact
<span class="submenu-expander">
<i class="fa fa-angle-down"></i></span></span></span></a></li>
	
</ul>
</div>
</div>
<div class="col text-right">
<div class="header-module">
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="padding: 5px;">
    <img src="assets/img/<?=$_SESSION['country_list'][$_SESSION['country']]['flag']?>" style="margin-right: 5px;"></a>
    </button>
    <div class="dropdown-menu" style="padding: 10px;">
    <?php
    	if(isset($_SESSION['country_list'])){
    		foreach($_SESSION['country_list'] as $k => $data){ if($k==1) continue;
    			echo '<a class="dropdown-item" href="index.php?country='.$data['id'].'"><img src="assets/img/'.$data['flag'].'" style="margin-right: 5px;">'.$data['country'].'</a><br>';
    		}
    	}
    ?>   
  </div>
</div>
</div>
	
</div>
</div>
			</div>
		</div>
	</div>
</header>
<main id="content" class="content">
<section class="vc_row lqd-css-sticky bg-cover bg-center halfheight d-flex align-items-center py-5" data-row-bg="true" data-animate-onscroll="true" data-animate-from='{"opacity":1}' data-animate-to='{"opacity":0}' data-slideshow-bg="true" data-slideshow-options='{"effect":"scale","imageArray":["./assets/demo/bg/innerbg2.jpg","./assets/demo/bg/innerbg.jpg"]}'>
	<span class="row-bg-loader"></span>
	<div class="liquid-row-overlay bg-black opacity-03"></div>

</section>
