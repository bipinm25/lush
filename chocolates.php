<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();

if(isset($_GET['fetch_prod']) && $_GET['fetch_prod']==1 && isset($_GET['country_id']) ){

$_GET['country_id'] = (int) $_GET['country_id'];
$showPostFrom = $_POST["showPostFrom"];
$showPostCount = $_POST["showPostCount"];

	$fetch_prod = $crud->getData("SELECT p.id,p.name,p.category_id,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p
where p.is_deleted=0 and p.status=1 and p.category_id=2 and p.country_id=".$_GET['country_id']." order by p.id desc limit {$showPostFrom},{$showPostCount}");
$html='';
		foreach($fetch_prod as $k => $v){
			$html.='<li><a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$v['id'].'">
					<i class="fa fa-th"></i></a>
					<img src="admin_panel/'.$v['image_path'].'" alt="'.$v['name'].'"></li>';
		}
	
	echo $html;
	exit;
}
include_once('header.php');

$products = $crud->getData("SELECT p.id,p.name,p.category_id,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p
where p.is_deleted=0 and p.status=1 and p.category_id=2 and p.country_id=".$country_id." order by p.id desc limit 0,8");

$totalRecord = $crud->number_of_records("SELECT id from products p where p.is_deleted=0 and p.status=1 and p.category_id=2 and p.country_id=".$country_id."");

?>
<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-8 col-md-offset-2">
<header class="fancy-title text-center mb-50">
<h3 class="font-size-14 ltr-sp-015 mt-50 mb-2"><em>Something sweet we have for you!</em></h3>
<h2 class="mt-0 mb-2">Chocolates</h2>
<img src="assets/img/misc/wave.svg" alt="Wave shape">
</header>
</div>
</div>
</div>
					<section class="vc_row">
						<div class="container">
							<div class="row mx-0">
								<div class="lqd-column col-md-12 px-0">
									<div class="liquid-ig-feed liquid-stretch-images mb-0" data-list-columns="4">
										<ul class="liquid-ig-feed-list" id="prod_list">
											<?php
										foreach ($products as $k=>$cake) {
											echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-th"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';
												}
												?>											
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
</section>



<br>
<br>
<br>

<?php include_once('footer.php'); ?>


<script>
var process;

var country_id = <?=$country_id?>

$showPostFrom = 4;
$showPostCount = 4;
$totalRecord = <?=$totalRecord?>;


$(document).scroll(function(e){

if(process) return false;

    // grab the scroll amount and the window height
    var scrollAmount = $(window).scrollTop();
    var documentHeight = $(document).height();

    // calculate the percentage the user has scrolled down the page
    var scrollPercent = (scrollAmount / documentHeight) * 100;

    if(scrollPercent > 30) {
        // run a function called doSomething
       doSomething();
    }

    function doSomething() {
    	process=true;
    	$showPostFrom += $showPostCount
    	if($showPostFrom > $totalRecord) return false;
    	

       $.ajax({
                type: "POST",
                url: "chocolates.php?fetch_prod=1&country_id="+country_id+"",              
                data:{'showPostFrom':$showPostFrom, 'showPostCount':$showPostCount },
                cache: false,
                success: function(html){               
                	$('#prod_list').append(html);
                process=false;

                }
            });

    }

});
</script>