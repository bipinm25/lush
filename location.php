<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();
$country = $crud->getData("SELECT id,country from country where is_active=1");
?>
<!DOCTYPE html>
<html lang="en">


<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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

<script async src="assets/vendors/modernizr.min.js"></script>
</head>
<body data-mobile-nav-trigger-alignment="right" data-mobile-nav-align="left" data-mobile-nav-style="classic" data-mobile-nav-shceme="gray" data-mobile-header-scheme="gray" data-mobile-nav-breakpoint="1199">
<div id="wrap">
<header class="main-header main-header-overlay">
<div class="mainbar-wrap">
<div class="megamenu-hover-bg"></div>
</div>
</header>
<main id="content" class="content">
<section class="vc_row lqd-css-sticky bg-cover bg-center fullheight d-flex align-items-center py-5" data-row-bg="true" data-animate-onscroll="true" data-animate-from='{"opacity":1}' data-animate-to='{"opacity":0}' data-slideshow-bg="true" data-slideshow-options='{"effect":"scale","imageArray":["./assets/demo/bg/bg-landing.jpg","./assets/demo/bg/bg-81.jpg","./assets/demo/bg/bg-81_2.jpg"]}'>
<span class="row-bg-loader"></span>
<div class="liquid-row-overlay bg-black opacity-03"></div>
<div class="container">
<div class="row">
<div class="lqd-column col-md-10 col-md-offset-1 text-center px-lg-7" data-custom-animations="true" data-ca-options='{"triggerHandler":"inview", "animationTarget":"all-childs", "duration":1600, "delay":250, "easing":"easeOutQuint", "direction":"forward", "initValues":{"opacity":0, "translateY":100}, "animations":{"opacity":1, "translateY":0}}' data-parallax="true" data-parallax-from='{"translateY":1}' data-parallax-to='{"translateY":-220}' data-parallax-options='{"easing":"linear","reverse":true,"triggerHook":"onEnter", "overflowHidden": false}'>
<?php
foreach($country as $k => $coun){
	echo '<a href="index.php?country='.$coun['id'].'" class="btn btn-solid text-uppercase btn-lg border-thin btn-white py-1 px-2" data-localscroll="true" data-localscroll-options=\'{"scrollBelowSection":true}\'>
<span>
<span class="btn-txt">'.$coun['country'].'</span>
</span>
</a>';
}
?>
</div>
</div>
</div>
</section>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCUnWOSK2b5WtvMOAI8j55OHhS_sNv2VfA"></script>
<script src="assets/vendors/jquery.min.js"></script>
<script src="assets/js/theme-vendors.js"></script>
<script src="assets/js/theme.min.js"></script>
<script src="assets/js/liquidAjaxMailchimp.min.js"></script>
</body>
</html>