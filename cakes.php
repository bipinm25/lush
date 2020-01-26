<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();

include_once('header.php');
$products = $crud->getData("SELECT p.id,p.name,p.category_id,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p 
where p.is_deleted=0 and p.status=1 and p.category_id=1 and p.country_id=".$country_id." order by p.id desc limit 11");

?>
<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-8 col-md-offset-2">
<header class="fancy-title text-center mb-50">
<h3 class="font-size-14 ltr-sp-015 mt-50 mb-2"><em>More than just cakes</em></h3>
<h2 class="mt-0 mb-2">CAKE'S</h2>
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
										<ul class="liquid-ig-feed-list">
											<?php											
											foreach ($products as $k=>$cake) {												
													echo '<li>
													<a class="liquid-ig-feed-overlay" target="_blank" href="products_details.php?p_id='.$cake['id'].'">
													<i class="fa fa-birthday-cake"></i>
													</a>
													<img src="admin_panel/'.$cake['image_path'].'" alt="'.$cake['name'].'">
													</li>';												
											}
											?>											
											<li>
												<a class="liquid-ig-feed-overlay" target="_blank" href="#">
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



<br>
<br>
<br>


<?php include_once('footer.php'); ?>