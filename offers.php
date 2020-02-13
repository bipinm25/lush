<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();
include_once('header.php');

$products = $crud->getData("SELECT p.id,p.name,p.category_id,pc.category,p.price,p.product_code,p.status,p.measurement_type m_type,p.measurement_value m_value,p.measurement_unit m_unit,date(p.added_date) added_date,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p left join product_category pc on p.category_id=pc.id
where p.is_deleted=0 and p.status=1 and p.country_id=".$country_id." order by p.id desc");

?>
<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-8 col-md-offset-2">
<header class="fancy-title text-center mb-30">
<h3 class="font-size-14 ltr-sp-015 mt-30 mb-2"><em>What we have for you?</em></h3>
<h2 class="mt-0 mb-2">Cake - Chocolates - Gift Box</h2>
<img src="assets/img/misc/wave.svg" alt="online Birthday Gifts">
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
													<img src="admin_panel/'.$cake['thumb'].'" alt="'.$cake['name'].'">
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
													<img src="admin_panel/'.$cake['thumb'].'" alt="'.$cake['name'].'">
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
													<img src="admin_panel/'.$cake['thumb'].'" alt="'.$cake['name'].'">
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


<br>
<br>
<br>
<?php include_once('footer.php'); ?>