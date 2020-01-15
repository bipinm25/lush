<?php
include_once("check_login.php");
include('class/common_settings.php');
include_once("class/Crud.php");
$crud = new Crud();

include_once('mail/smtp.php');

$category_list = $crud->getData("select id,category from product_category where status=0 order by category");

if (isset($_GET['po_id']) && (int) $_GET['po_id'] > 0) {
	$sql = "SELECT p.id product_id,p.name product_name,p.description,p.category_id,pc.category,p.product_code,p.price,po.name customer_name,po.mobile,po.email_id,po.order_date,
			po.note,po.address,po.status order_status,p.measurement_type m_type,p.measurement_value m_value,p.measurement_unit m_unit,po.id po_id,po.order_id as order_id,
		(select image_path from products_images pi where pi.product_id=po.product_id order by pi.id desc limit 1) image_path,
		(select thumb_path from products_images pi where pi.product_id=po.product_id order by pi.id desc limit 1) thumb_path
		FROM product_order po 
		left join products p on po.product_id=p.id
		left join product_category pc on p.category_id=pc.id
		where p.is_deleted=0 and po.id=".(int) $_GET['po_id']." ";
	$get_product = $crud->getData($sql);
	$get_product = $get_product[0];
	
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['send_to_customer']) && $_POST['send_to_customer']==1) {

		$body = '<table>
				<tr><td colspan="2"><b>Your Order Status</b></td></tr>
				<tr><td>Order ID :</td><td>'.$_POST['order_number'].'</td></tr>
				<tr><td>Status :</td><td>'.$order_status[$_POST['order_status']]['text'].'</td></tr>				
				</table>';

		$param = [
		'to_mail' =>$_POST['customer_email'],
			'name' => 'Customer',
			'subject' => 'LUSH - Product order status change notification',
			'body' => $body
		];

		$mail = new send_emails($param);
		$mail->send_mail();		
	}
		
	if ((int) $_POST['po_id'] >0) {
		$crud->execute("update product_order set status=".$_POST['order_status']." where id=".(int) $_POST['po_id']." ");
	} 

	header("Location:order_list.php");
	exit();
}
$bread_cums = ['Order List'=>'order_list.php','Order Details'=>''];

include_once('menu.php');
?>

			<div class="m-b-md">
				<h3 class="m-b-none">Mangae Orders</h3>
			</div>
			<section class="panel panel-default">
				<header class="panel-heading font-bold">
					Order Details
				</header>
				<div class="panel-body">
					<form action="" class="form-horizontal" id="product_form" enctype="multipart/form-data" method="post">
						<input type="hidden" name="po_id" value="<?=isset($_GET['po_id'])? (int) $_GET['po_id']:0 ?>" />
			<input type="hidden" name="order_number" value="<?=$get_product['order_id'] ?>" />
						<div class="form-group">
							<label class="col-sm-2 control-label">Order ID</label>
							<div class="col-sm-10">
								<label class="col-sm-1 control-label">
									<b><?=$get_product['order_id'] ?></b>
								</label>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="order_status">Order Status</label>
							<div class="col-sm-10">
							
								<select name="order_status" id="order_status" class="form-control m-b">
									<?php									
									foreach ($order_status as $k => $v) {
										$select = ($k==$get_product['order_status'])?'selected="selected"':"";
										echo '<option '.$select.'  value="'.$k.'" >'.$v['text'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Order Date</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=date('d-M-Y',strtotime($get_product['order_date'])) ?>" class="form-control">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Customer Name</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=$get_product['customer_name'] ?>" class="form-control" >
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Customer Mobile</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=$get_product['mobile'] ?>" class="form-control">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Customer Email</label>
							<div class="col-sm-10">
					<input type="text" readonly="readonly" name="customer_email" value="<?=$get_product['email_id'] ?>" class="form-control">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Customer Notes</label>
							<div class="col-sm-10">
								<textarea rows="3" disabled="disabled" class="form-control" ><?=$get_product['note'] ?></textarea>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Customer Address</label>
							<div class="col-sm-10">
								<textarea rows="3" disabled="disabled" class="form-control" ><?=$get_product['address'] ?></textarea>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Product Name</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=$get_product['product_name'] ?>" class="form-control" id="product_name">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Product Category</label>
							<div class="col-sm-10">
								<select disabled="disabled"  class="form-control m-b required_field">									
									<?php
									$select_cat='';
									foreach ($category_list as $k => $category) {										
									   $select_cat = $get_product['category_id'] == $category['id']? 'selected="selected"':"" ;										
										echo '<option '.$select_cat.' value="'.$category['id'].'">'.$category['category'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_code">Product Code</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=$get_product['product_code']?>" class="form-control required_field" id="product_code">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_price">Price</label>
							<div class="col-sm-10">
								<input type="text" disabled="disabled" value="<?=number_format($get_product['price'],2,".","")?>" class="form-control required_field" id="product_price">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="measurement_type"><?=$get_product['m_type']?></label>
							<div class="col-sm-3">
								<input type="text"  disabled="disabled" value="<?=number_format($get_product['m_value'],1,'.','').' '.$get_product['m_unit'] ?>" class="form-control required_field" id="measurement_value">								
							</div>							
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Product Description</label>
							<div class="col-sm-10">
								<textarea rows="5" disabled="disabled" class="form-control"><?=$get_product['description'] ?></textarea>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>						
						<div class="form-group">
							<label class="col-sm-2 control-label">Product Image</label>
							<div class="col-sm-10">												
								<img src="<?=$get_product['thumb_path']?>" alt="">
							</div>
						</div>
						<?php
						if (!empty(trim($get_product['email_id']))) { ?>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" value="1" name="send_to_customer"/> Send email notification to customer
							</div>
						</div>
						<?php } ?>
					
						
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<input type="submit" id="submit" value="Update" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>
			</section>		

<?php
include_once('footer.php');
?>
<script>	

	
</script>