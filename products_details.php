<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();

include_once('admin_panel/mail/smtp.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$_POST['name'] = $crud->escape_string($_POST['name']);
	$_POST['mobile'] = $crud->escape_string($_POST['mobile']);
	$_POST['address'] = $crud->escape_string($_POST['address']);
	$_POST['note'] = $crud->escape_string($_POST['note']);
	$_POST['email_id'] = $crud->escape_string($_POST['email_id']);

	$order_id = $crud->product_order_request($_POST);

	$to_mail_id = 'info@lushshopee.com';
	$parts = explode("@", $to_mail_id);
	$to_name = $parts[0];
	$subject = 'Product Enquiry Request';


	$body = '<table>
<tr><td colspan="2"><b>Product Enquiry</b></td></tr>
<tr><td>Product Name :</td><td>'.$_POST['p_name'].'</td></tr>
<tr><td>Product Code :</td><td>'.$_POST['p_code'].'</td></tr>
<tr><td>Product Price :</td><td>'.$_POST['p_price'].'</td></tr>
<tr><td>Product Weight :</td><td>'.$_POST['p_weight'].'</td></tr>
<tr><td>Name :</td><td>'.$_POST['name'].'</td></tr>
<tr><td>Mobile :</td><td>'.$_POST['mobile'].'</td></tr>
<tr><td>Address :</td><td>'.$_POST['address'].'</td></tr>
<tr><td>Note :</td><td>'.$_POST['note'].'</td></tr>
<tr><td>Order ID :</td><td>'.$order_id.'</td></tr>
</table>';

	$param = [
		'to_mail' =>$to_mail_id,
		'name' => $to_name,
		'subject' => $subject,
		'body' => $body
	];

	$mail = new send_emails($param);

	if ($mail->send_mail()) {
		$msg='success';
	}else{
		$msg='failed';
	}	
	$orderid =['order_id' => $order_id];
	header("Location:order.php?".http_build_query($orderid));
	exit();
}

if (isset($_GET['p_id']) && (int) $_GET['p_id'] > 0) {
	$products = $crud->getData("SELECT p.id,p.name,p.category_id,pc.category,p.price,p.product_code,p.status,p.description,p.measurement_type m_type,p.measurement_value m_value,p.measurement_unit m_unit,date(p.added_date) added_date,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb,(select image_path from products_images where product_id=p.id order by id desc limit 1 ) as image_path FROM `products` p left join product_category pc on p.category_id=pc.id
	where p.id=".(int) $_GET['p_id']." and p.is_deleted=0 and p.status=1");	
}
$products = (array) $products[0];
$products['price'] = $crud->is_decimal($products['price'])?number_format($products['price'],2,'.',''):(int)$products['price'];
$products['m_value'] = $crud->is_decimal($products['m_value'])?number_format($products['m_value'],2,'.',''):(int)$products['m_value'];

include_once('header.php');
?>
<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-6">
								<img src="admin_panel/<?=$products['image_path'] ?>" alt="<?=$products['name'] ?>">
</div>
<div class="lqd-column col-md-6"><br>
<h4><?=$products['name']?></h4>
								<h9 class="pricen">₹ <?=$products['price'] ?></h9>
								<p><?=$products['description'] ?> 
<br><br>

									Product Code : <?=$products['product_code'] ?><br>
									Weight : <?=$products['m_value'].' '.$products['m_unit'] ?> </p>

<div class="lqd-column">
<form method="post"> 
<input type="hidden" name="p_id" value="<?=$products['id'] ?>"/>
<input type="hidden" name="p_name" value="<?=$products['name'] ?>"/>
<input type="hidden" name="p_code" value="<?=$products['product_code'] ?>"/>
<input type="hidden" name="p_price" value="<?=$products['price'] ?>"/>
<input type="hidden" name="p_weight" value="<?=$products['m_value'].' '.$products['m_unit'] ?>"/>
<input class="lh-25 rmb-4 textareanew" type="text" name="name" aria-required="true" aria-invalid="false" placeholder="Name" required="">
<input class="lh-25 rmb-4 textareanew" type="tel" name="mobile" aria-required="true" aria-invalid="false" placeholder="Mobile No" required="">
<input class="lh-25 rmb-4 textareanewfull"  type="text" style="height: 50px !important;"  name="email_id"  aria-invalid="false" placeholder="Email">
<textarea cols="10" class="rmb-5 textareanewfull" rows="6" name="address" aria-required="true" aria-invalid="false" placeholder="Address" required=""></textarea>
<textarea cols="10" class="rmb-5 textareanewfull" rows="6" name="note" aria-required="true" aria-invalid="false" placeholder="Your Note" required=""></textarea>
<input type="submit"  class="submitnew" value="Send Enquiry" >
</form>
</div>
</div>
</div>
</div>
</section>



<br>
<br>

<?php include_once('footer.php'); ?>

<script>
	<?php
			//if ( isset($_COOKIE['msg']) && $_COOKIE['msg']=='success') {				
				?>
				//alert("Order send Successfully");				
				<?php //} ?>
</script>