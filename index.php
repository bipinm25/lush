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
if((isset($_GET['country']) && (int)$_GET['country'] > 0)){

	if(!in_array((int)$_GET['country'], $c_ids)){
		header("location:location.php");
	}

	$_SESSION['country'] = (int)$_GET['country'];
		
	$country_id = (int) $_SESSION['country'];		
}
else if(isset($_SESSION['country']) && $_SESSION['country'] > 0 ){
	$country_id = (int) $_SESSION['country'];
}
else{
	header("location:location.php");
}
$products = $crud->getData("SELECT p.id,p.name,p.category_id,pc.category,p.price,p.product_code,p.status,p.measurement_type m_type,p.measurement_value m_value,p.measurement_unit m_unit,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p left join product_category pc on p.category_id=pc.id
where p.is_deleted=0 and p.status=1 and p.country_id=".$country_id." order by p.id desc");
$uniq_category = array_unique(array_values(array_column($products, 'category_id')));
?>
<!DOCTYPE html>
<html lang="en">


<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="theme-color" content="#3ed2a7">
<link rel="shortcut icon" href="favicon.png" />
<title>LUSH - An easiest way to celebrate..</title>
<link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff%7cLato&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/vendors/liquid-icon/liquid-icon.min.css" />
<link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="assets/css/theme-vendors.min.css" />
<link rel="stylesheet" href="assets/css/theme.min.css" />
<link rel="stylesheet" href="assets/css/themes/restaurant.css" />

<script async src="assets/vendors/modernizr.min.js"></script>
</head>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
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
<div class="header-module">
<ul class="social-icon social-icon-md">
<li><a href="#" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
</ul>
</div>
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
<li class="menu-item-has-children position-applied">
<a href="#">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt">
<?=$_SESSION['country_list'][$_SESSION['country']]['country']?>
<span class="submenu-expander">
<i class="fa fa-angle-down"></i>
</span>
</span>
</span>
</a>
<ul class="nav-item-children" style="display: none; opacity: 1;">
<?php
foreach($_SESSION['country_list'] as $k=>$v){
if($v['is_active'] == 0) continue;
echo '<li>
<a href="index.php?country='.$v['id'].'">
<span class="link-icon"></span>
<span class="link-txt">
<span class="link-ext"></span>
<span class="txt"><img src="assets/img/'.$v['flag'].'" style="margin-right: 5px;">
'.strtoupper($v['country']).'
<span class="submenu-expander">
<i class="fa fa-angle-down"></i>
</span>
</span>
</span>
</a>
</li>';	
}
?>
</ul>
</li>
</ul>
</div>
</div>
<div class="col text-right">
<div class="header-module">
<a href="contact.php" class="btn btn-naked text-uppercase btn-icon-md btn-icon-circle btn-icon-solid">
<span>
<span class="btn-txt">Contact us</span>
<span class="btn-icon">
<i class="fa fa-angle-right"></i></span></span></a></div>
</div>
</div>
</div>
</div>
</div>
</header>
<main id="content" class="content">
<section class="vc_row lqd-css-sticky bg-cover bg-center fullheight d-flex align-items-center py-5" data-row-bg="true" data-animate-onscroll="true" data-animate-from='{"opacity":1}' data-animate-to='{"opacity":0}' data-slideshow-bg="true" data-slideshow-options='{"effect":"scale","imageArray":["./assets/demo/bg/bg-80.jpg","./assets/demo/bg/bg-81.jpg","./assets/demo/bg/bg-81_3.jpg","./assets/demo/bg/bg-81_2.jpg"]}'>
<span class="row-bg-loader"></span>
<div class="liquid-row-overlay bg-black opacity-03"></div>
<div class="container">
<div class="row">
<div class="lqd-space" style="height: 250px;"></div>
<div class="lqd-column col-md-10 col-md-offset-1 text-center px-lg-7" data-custom-animations="true" data-ca-options='{"triggerHandler":"inview", "animationTarget":"all-childs", "duration":1600, "delay":250, "easing":"easeOutQuint", "direction":"forward", "initValues":{"opacity":0, "translateY":100}, "animations":{"opacity":1, "translateY":0}}' data-parallax="true" data-parallax-from='{"translateY":1}' data-parallax-to='{"translateY":-220}' data-parallax-options='{"easing":"linear","reverse":true,"triggerHook":"onEnter", "overflowHidden": false}'>
<h3 class="font-size-12 text-white ltr-sp-015 mt-0 mb-2"><em>LUSH</em></h3>
<h2 class="mt-0 mb-5 text-white lh-115" data-fittext="true" data-fittext-options='{"compressor":0.75,"maxFontSize":"44","minFontSize":"48"}' data-split-text="true" data-split-options='{"type":"lines"}'>
An easiest way to celebrate..</h2>
<a href="cakes.php" class="btn btn-solid text-uppercase btn-lg border-thin btn-white py-1 px-2" data-localscroll="true" data-localscroll-options='{"scrollBelowSection":true}'>
<span>
<span class="btn-txt">ORDER NOW</span>
</span>
</a>
<div class="lqd-space" style="height: 120px;"></div>
<p class="text-uppercase text-white font-size-12 ltr-sp-3" data-split-text="true" data-split-options='{"type":"lines"}'>
FAST DELIVERY - CUSTOME DESIGN - UNBEATABLE PRICE <br>
<a class="text-white" href="contact.php">Order Online or Call Us on +91 9744733676</a>
</p>
</div>
</div>
</div>
</section>
<section class="vc_row bg-no-repeat pt-150 pb-75" style="background-image: url(assets/demo/bg/bg-82.png); background-position: 0% 80%;">
<div class="container">
<div class="row d-flex flex-wrap align-items-center">
<div class="lqd-column col-md-6 pr-md-6">
<header class="fancy-title mb-45">
<h5 class="my-0">For the Perfect</h5>
<h2 class="my-0">Welcome to the beauty of LUSH </h2>
</header>
<p class="mb-40 font-size-18 lh-185">Yes! LUSH is the easiest way to celebrate every moment. We create Surprices for all sorts of occasions, including weddings, birthdays, showers, grand openings, with our Chocolates, Cakes, Special custome gift boxes. Take a look around our site and learn all about our surprices!</p>
<a href="about_lush.php" class="btn btn-naked text-uppercase btn-icon-circle btn-icon-bordered">
<span>
<span class="btn-txt">More about LUSH</span>
<span class="btn-icon"><i class="fa fa-angle-right"></i></span>
</span>
</a>
</div>
<div class="lqd-column col-md-5 col-md-offset-1 visible-md visible-lg">
<div class="lqd-parallax-images-4 lqd-parallax-images-4-alt text-md-right">
<div class="liquid-counter liquid-counter-default mb-0">
<p class="font-size-12 text-uppercase ltr-sp-15 mb-0">Our Happy Customers</p>
<div class="liquid-counter-element font-weight-normal" data-enable-counter="true" data-counter-options='{"targetNumber":"5987","blurEffect":true}'>
<span>5987</span>
</div>
</div>
<div class="liquid-img-group-container">
<div class="liquid-img-group-inner">
<div class="liquid-img-group-single" data-shadow-style="4" data-inview="true" data-animate-shadow="true" data-reveal="true" data-reveal-options='{ "direction":"tb", "bgcolor":"rgb(41, 45, 53)" }'>
<div class="liquid-img-group-img-container">
<div class="liquid-img-container-inner" data-parallax="true" data-parallax-from='{"translateY":50}' data-parallax-to='{"translateY":95}' data-parallax-options='{"overflowHidden":false,"easing":"linear"}'>
<figure>
<img src="assets/demo/misc/fi-9.jpg" alt="About LUSH" />
</figure>
</div>
</div>
</div>
</div>
</div>
<div class="liquid-img-group-container">
<div class="liquid-img-group-inner">
<div class="liquid-img-group-single w-55" data-shadow-style="4" data-inview="true" data-animate-shadow="true" data-reveal="true" data-reveal-options='{"direction":"rl", "bgcolor":"rgb(41, 45, 53)"}'>
<div class="liquid-img-group-img-container">
<div class="liquid-img-container-inner" data-parallax="true" data-parallax-from='{"translateY":46}' data-parallax-to='{"translateY":-81}' data-parallax-options='{"overflowHidden":false,"easing":"linear"}'>
<figure>
<img src="assets/demo/misc/logo_Home.png" alt="Lush Best online gift site in India" />
</figure>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<?php if(in_array(1,$uniq_category)) { ?>
<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-8 col-md-offset-2">
<header class="fancy-title text-center mb-70">
<h3 class="font-size-14 ltr-sp-015 mt-0 mb-2"><em>What we have for you?</em></h3>
<h2 class="mt-0 mb-2">CAKE'S - CHOCOLATES - GIFT BOX</h2>
<img src="assets/img/misc/wave.svg" alt="LUSH online ">
</header>
</div>
</div>
</div>
					<section class="vc_row">
						<div class="container-fluid px-0">
							<div class="row mx-0">
								<div class="lqd-column col-md-12 px-0">
									<div class="liquid-ig-feed liquid-stretch-images mb-0" data-list-columns="6">
										<ul class="liquid-ig-feed-list">
										<?php											
											$i=0;
											foreach ($products as $k=>$cake) {												
												if ($cake['category_id']==1 && $i<5) {
													$i++;
													echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-birthday-cake"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';
												}
											}
										?>
																					
											<li>
												<a class="liquid-ig-feed-overlay" target="_blank" href="cakes.php">
													<i class="fa fa-birthday-cake"></i>
												</a>
												<img src="assets/demo/misc/ig-5.jpg" alt="Instagram Image 1">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
</section>
<?php } if(in_array(3,$uniq_category)) { ?>
<section class="vc_row pt-50 pb-50">
					<section class="vc_row">
						<div class="container-fluid px-0">
							<div class="row mx-0">
								<div class="lqd-column col-md-12 px-0">
									<div class="liquid-ig-feed liquid-stretch-images mb-0" data-list-columns="6">
										<ul class="liquid-ig-feed-list">
											<?php											
											$i=0;
											foreach ($products as $k=>$cake) {
												if ($cake['category_id']==3 && $i<5) {
													$i++;
													echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-gift"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';
												}
											}
											?>									
											<li>
												<a class="liquid-ig-feed-overlay" target="_blank" href="giftboxes.php">
													<i class="fa fa-gift"></i>
												</a>
												<img src="assets/demo/misc/ig-5_2.jpg" alt="Instagram Image 1">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
</section>
<?php } if(in_array(2,$uniq_category)) { ?>
<section class="vc_row pt-50 pb-50">
					<section class="vc_row">
						<div class="container-fluid px-0">
							<div class="row mx-0">
								<div class="lqd-column col-md-12 px-0">
									<div class="liquid-ig-feed liquid-stretch-images mb-0" data-list-columns="6">
										<ul class="liquid-ig-feed-list">
											<?php
											$i=0;
											foreach ($products as $k=>$cake) {
												if ($cake['category_id']==2 && $i<5) {
													$i++;
													echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-th"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';
												}
											}
											?>
											<li>
												<a class="liquid-ig-feed-overlay" target="_blank" href="chocolates.php">
													<i class="fa fa-th"></i>
												</a>
												<img src="assets/demo/misc/ig-5.jpg" alt="Instagram Image 1">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
</section>
<?php } if(in_array(4,$uniq_category)) { ?>
<section class="vc_row pt-50 pb-50">
					<section class="vc_row">
						<div class="container-fluid px-0">
							<div class="row mx-0">
								<div class="lqd-column col-md-12 px-0">
									<div class="liquid-ig-feed liquid-stretch-images mb-0" data-list-columns="6">
										<ul class="liquid-ig-feed-list">
											<?php
											$i=0;
											foreach ($products as $k=>$cake) {
												if ($cake['category_id']==4 && $i<5) {
													$i++;
													echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-th"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';
												}
											}
											?>
											<li>
												<a class="liquid-ig-feed-overlay" target="_blank" href="offers.php">
													<i class="fa fa-th"></i>
												</a>
												<img src="assets/demo/misc/ig-5.jpg" alt="Instagram Image 1">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
</section>
<?php } ?>
<section class="vc_row bg-no-repeat pt-150 pb-150" style="background-image: url(assets/demo/bg/bg-82.png); background-position: 0% 80%;">
<div class="container">
<div class="row d-flex flex-wrap align-items-center">
<div class="lqd-column col-md-6 hidden-xs hidden-sm">
<div class="liquid-img-group-container lqd-parallax-images-10">
<div class="liquid-img-group-inner">
<div class="liquid-img-group-single w-80" data-shadow-style="4" data-inview="true" data-animate-shadow="true" data-reveal="true" data-reveal-options='{ "direction":"tb", "bgcolor":"rgb(41, 45, 53)" }'>
<div class="liquid-img-group-img-container">
<div class="liquid-img-container-inner" data-parallax="true" data-parallax-from='{"translateY":50}' data-parallax-to='{"translateY":95}' data-parallax-options='{"overflowHidden":false,"easing":"linear"}'>
<figure>
<img src="assets/demo/misc/fi-11.jpg" alt="About Ave" />
</figure>
</div>
</div>
</div>
<div class="liquid-img-group-single w-50" data-shadow-style="4" data-inview="true" data-animate-shadow="true" data-reveal="true" data-reveal-options='{"direction":"rl", "bgcolor":"rgb(41, 45, 53)"}'>
<div class="liquid-img-group-img-container">
<div class="liquid-img-container-inner" data-parallax="true" data-parallax-from='{"translateY":46}' data-parallax-to='{"translateY":-81}' data-parallax-options='{"overflowHidden":false,"easing":"linear"}'>
<figure>
<img src="assets/demo/misc/fi-12.jpg" alt="About Ave" />
</figure>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="lqd-column col-md-6">
<header class="fancy-title mb-45">
<h5 class="my-0">Discover</h5>
<h2 class="my-0">We believe in quality.</h2>
</header>
<div class="row">
<div class="lqd-column col-md-10">
<div class="iconbox iconbox-side iconbox-xl iconbox-icon-image">
<div class="iconbox-icon-wrap">
<span class="iconbox-icon-container">
<svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 54 54"><defs xmlns="http://www.w3.org/2000/svg"><linearGradient gradientUnits="userSpaceOnUse" id="grad85624" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#f42958"></stop><stop offset="100%" stop-color="#f42958"></stop></linearGradient></defs> <g fill="none" fill-rule="evenodd" transform="translate(1)"> <ellipse cx="29.043" cy="23.976" fill="#F0EBD5" rx="23.957" ry="23.976"></ellipse> <g stroke="#BB9857" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.216" transform="translate(0 15)"> <path d="M28.7463303,24.9451613 L4.2233945,24.9451613 C-1.16559633,23.1524194 -1.96788991,15.4145161 6.02477064,12.0741935 C6.02477064,7.35483871 9.33990826,4.52016129 13.3211009,3.57016129 C13.4876147,5.17903226 14.85,6.43548387 16.4848624,6.43548387 C18.1045872,6.43548387 19.4518349,5.20967742 19.6334862,3.61612903 C23.5238532,4.61209677 26.7178899,7.41612903 26.7178899,12.058871 C34.9527523,15.3991935 34.2412844,23.1830645 28.7463303,24.9451613 Z"></path> <polygon points="14.487 38 10.506 38 9.355 24.945 14.275 24.945 14.305 26.876"></polygon> <polygon points="10.506 38 6.403 38 4.223 24.945 9.355 24.945"></polygon> <polygon points="18.967 24.945 18.937 26.799 18.756 38 14.487 38 14.305 26.876 14.275 24.945"></polygon> <polygon points="23.63 24.945 22.903 38 18.756 38 18.937 26.799 18.967 24.945"></polygon> <polygon points="28.746 24.945 26.672 38 22.903 38 23.63 24.945"></polygon> <path d="M4.73807339 17.9427419L7.53853211 20.5169355M13.4724771 9.69919355L11.156422 13.0241935M20.6931193 12.3193548L23.8720183 14.0201613M18.1045872 17.9427419L15.1981651 20.5169355M27.4899083 18.816129L25.0527523 20.7927419M19.6637615 3.21774194C19.6637615 3.35564516 19.6486239 3.49354839 19.6334862 3.61612903 19.4366972 5.20967742 18.1045872 6.43548387 16.4848624 6.43548387 14.85 6.43548387 13.5027523 5.17903226 13.3211009 3.57016129 13.3059633 3.46290323 13.3059633 3.34032258 13.3059633 3.21774194 13.3059633 1.44032258 14.7288991 0 16.4848624 0 18.2408257 0 19.6637615 1.44032258 19.6637615 3.21774194z"></path> </g> </g> </svg>
</span>
</div>
<div class="contents">
<p>LUSH always with customers with both quality and its beauty. its hard to unite both beauty and quality together but we will give you the BEST!</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>


<section class="vc_row pt-70 pb-45" style="background-color: #FFF;">
<div class="container">
<div class="row">
<div class="lqd-column col-md-8 col-md-offset-2">
<header class="fancy-title text-center mb-70">
<h3 class="text-primary font-size-14 ltr-sp-015 mt-0 mb-2"><em>Just Arrived</em></h3>
<h2 class="text-white mt-0 mb-2">Beautiful Experience.</h2>
<img src="assets/img/misc/wave.svg" alt="Wave shape">
</header>
</div>
</div>
</div>
<div class="container-fluid">
						<div class="row">
							<div class="lqd-column col-md-12 px-md-4">
								<div class="ld-media-row row d-flex" data-liquid-masonry="true" data-custom-animations="true" data-ca-options='{"triggerHandler":"inview", "animationTarget":".ld-media-item", "duration":"1600", "startDelay":"160", "delay":100, "easing":"easeOutQuint", "initValues":{"scaleX":0.75, "scaleY":0.75, "opacity":0}, "animations":{"scaleX":1, "scaleY":1, "opacity":1}}'>
									<?php
									$i=0;
									foreach ($products as $k=>$v) {
										if ($v['category_id']==4 && $i<5) {
											$i++;
											echo'<div class="lqd-column col-sm-3 col-xs-6 masonry-item">
										<div class="ld-media-item">
											<figure data-responsive-bg="true">
												<img src="admin_panel/'.$v['image_path'].'" alt="'.$v['name'].'">
											</figure>
											<div class="ld-media-item-overlay d-flex flex-column align-items-center text-center justify-content-center">
												<div class="ld-media-bg"></div>
												<div class="ld-media-content">
													<span class="ld-media-icon">
														<span class="ld-media-icon-inner">
															<i class="icon-ld-search"></i>
														</span>
													</span>
												</div>
											</div>
											<a href="admin_panel/'.$v['image_path'] .'" class="liquid-overlay-link fresco" data-fresco-group="restaurant-photo-gallery"></a>
										</div>
										</div>';										
										}										
									}
									?>								
								</div>
							</div>
						</div>
</div>
</section>

</main>
<footer class="main-footer pt-80 pb-80" data-sticky-footer="true">
<section class="vc_row">
<div class="container">
<div class="row d-flex flex-wrap">
<div class="lqd-column col-md-3 col-xs-12 mb-30">
<figure>
<img width="210" height="208" src="assets/img/logo/restaurant-dark%402x.png" alt="Ave Logo">
</figure>
</div>
<div class="lqd-column col-md-3 col-sm-6 col-xs-12 mb-30">
<h3 class="widget_title">Contact us</h3>
<p class="font-size-16 lh-175">
Marine Drive, Broadway South End, Ernakulam, Cochin, 682031, Kerala, India<br>
Call : +91 9744733676 <br>
Email : info@lushshopee.com
</p>
</div>
<div class="lqd-column col-md-3 col-sm-6 col-xs-12 mb-30">
<h3 class="widget_title">Quick Links</h3>
<ul class="lqd-custom-menu reset-ul font-size-16 lh-175">
<li><a href="cakes.php">Order Online</a></li>
<li><a href="contact.php">Custome Enquiry</a></li>
<li><a href="contact.php">Contact Us</a></li>
<li><a href="about_lush.php">About LUSH</a></li>
<li><a href="cakes.php">Best Seller</a></li>
</ul>
</div>
<div class="lqd-column col-md-3 col-xs-12 mb-30">
<h3 class="widget_title">Keep in touch</h3>
<ul class="social-icon circle social-icon-md">
<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
<li><a href="#" target="_blank"><i class="fa fa-flickr"></i></a></li>
<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
</ul>
</div>
</div>
</div>
</section>
</footer>
</div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCUnWOSK2b5WtvMOAI8j55OHhS_sNv2VfA"></script>
<script src="assets/vendors/jquery.min.js"></script>
<script src="assets/js/theme-vendors.js"></script>
<script src="assets/js/theme.min.js"></script>
<script src="assets/js/liquidAjaxMailchimp.min.js"></script>
</body>
</html>