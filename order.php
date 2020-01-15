<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();

include_once('header.php');
?>

<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-12" style="text-align:center;"><br>
<h4 ><i class="fa fa-gift" style=" font-size:76px;"></i><br>
Thank you for your order!</h4>
				<p>Order confirmation from LUSH! Your order id :
					<strong><?=isset($_GET['order_id'])?$_GET['order_id']:"" ?></strong>
				</p>


</div>
</div>
</div>
</section>



<br>
<br>


<?php include_once('footer.php'); ?>