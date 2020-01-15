<?php
include_once("check_login.php");
include('class/common_settings.php');
include_once("class/Crud.php");
$crud = new Crud();

$category_list = $crud->getData("select id,category from product_category where status=0 order by category");

$where = "";
if (isset($_GET['unset_filter']) && $_GET['unset_filter']==1) {
	$_GET['category_id'] = "";
	$_GET['order_id']="";
} else {
	if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
		$where.=" and p.category_id = ".(int) $_GET['category_id'];
	}
	if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
		$orderid = $crud->escape_string($_GET['order_id']);
		$where.=" and po.order_id like'%".$orderid."%'";
	}
}

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}

$no_of_records_per_page = 50;
$offset = ($pageno-1) * $no_of_records_per_page;
$where .= $_SESSION['is_global']?'':" and p.country_id=".$_SESSION['country_id']."";
$sql="SELECT p.id,co.country,p.name p_name,p.category_id,pc.category,p.product_code,po.name,po.mobile,po.email_id,po.order_date,po.status,po.id po_id,po.order_id as order_id
FROM product_order po left join `products` p on po.product_id=p.id left join product_category pc on p.category_id=pc.id left join country co on p.country_id=co.id
where p.is_deleted=0 $where order by po.id desc";

$total_rows = $crud->number_of_records($sql);
$total_pages = ceil($total_rows / $no_of_records_per_page);

$order_list = $crud->getData("$sql LIMIT $offset, $no_of_records_per_page");

$bread_cums = ['Order List'=>'order_list.php'];

include_once('menu.php');
?>
<div class="m-b-md">
<h3 class="m-b-none">Order List</h3>
			</div>
			<section class="panel panel-default">
				<section class="panel panel-default">
					<header class="panel-heading">
						Product Order List
					</header>
					<div class="row wrapper">
						<form method="get">
							<div class="col-sm-2">
								<select name="category_id" class="input-sm form-control input-s-sm inline v-middle">
									<option value="">Select category</option>
									<?php
									foreach ($category_list as $k => $category) {
										$select_cat='';
										if (isset($_GET['category_id'])) {
											$select_cat = (int) $_GET['category_id'] == $category['id']? 'selected="selected"':"" ;
										}
										echo '<option '.$select_cat.' value="'.$category['id'].'">'.$category['category'].'</option>';
									}
									?>
								</select>
							</div>							
							<div class="col-sm-3">
					<input class="input-sm form-control" value="<?=isset($_GET['order_id'])?$_GET['order_id']:"" ?>" type="text" name="order_id" placeholder="Order ID"/>
							</div>
							<span class="input-group-btn">
								<button class="btn btn-sm btn-default" type="submit">Search</button>
								<button class="btn btn-sm btn-default" value="1" name="unset_filter">Clear</button>
							</span>
						</form>


					</div>
					<div class="table-responsive">
						<table class="table table-striped b-t b-light">
							<thead>
								<tr>
									<th>Country</th>
									<th>Order ID</th>
									<th>Customer Name</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>Product Code</th>
									<th>Product Name</th>
									<th>Category</th>									
									<th>Order Date</th>							
									<th>Order Status</th>						
									<th>Options</th>									
								</tr>
							</thead>
							<tbody>
								<?php
								if ($order_list) {
																	
									foreach ($order_list as $k => $products) {
										//$products['price'] = number_format($products['price'], 2, '.', '');
										//$weight = number_format($products['m_value'], 2, '.', '').' '.$products['m_unit'];
										//$status = ($products['status']==1)?'<span class="label label-success">Active</span>':'<span class="label label-danger">In-Active</span>';
								echo '<tr>
											<td>'.$products['country'].'</td>
											<td>'.$products['order_id'].'</td>
											<td>'.$products['name'].'</td>
											<td>'.$products['mobile'].'</td>
											<td>'.$products['email_id'].'</td>
											<td>'.$products['product_code'].'</td>
											<td>'.$products['p_name'].'</td>
											<td>'.$products['category'].'</td>									
											<td>'.date('d-m-Y',strtotime($products['order_date'])).'</td>
											<td><span class="'.$order_status[$products['status']]['class'].'">'.$order_status[$products['status']]['text'].'</span></td>	
											<td><a href="order_details.php?po_id='.$products['po_id'].'" ><i class="fa fa-edit"></i></a></td>				
									  </tr>';
									}
								}

								?>
							</tbody>
						</table>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-8 text-center">
								<small class="text-muted inline m-t-sm m-b-sm">Total Order : <?=$total_rows ?></small>
							</div>
							<div class="col-sm-4 text-right text-center-xs">
								<?php
								$params=[];
								if (isset($_GET['category_id'])) {
									$params['category_id'] = $_GET['category_id'];
								}

								$url_params = sizeof($params)>0?'&'.http_build_query($params):'';
								?>
								<ul class="pagination">
									<li>
										<a href="?pageno=1<?=$url_params ?>">First</a></li>
									<li class="<?php
									if ($pageno <= 1) {
										echo 'disabled'; } ?>">
										<a href="<?php
										if ($pageno <= 1) {
											echo '#'; } else {
											echo "?pageno=".($pageno - 1)."".$url_params; } ?>"<?=$url_params ?>>Prev</a>
									</li>
									<li class="<?php
									if ($pageno >= $total_pages) {
										echo 'disabled'; } ?>">
										<a href="<?php
										if ($pageno >= $total_pages) {
											echo '#'; } else {
											echo "?pageno=".($pageno + 1)."".$url_params; } ?>">Next</a>
									</li>
									<li>
										<a href="?pageno=<?php echo $total_pages."".$url_params; ?>">Last</a></li>
								</ul>
							</div>
						</div>
					</footer>
				</section>


			</section>
<?php  include_once('footer.php'); ?>

<div class="modal fade" id="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change Order Status</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="prod_id" value="" />
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" for="order_status">Order Status</label>
						<div class="col-sm-4">
							<select name="order_status" id="status" class="form-control m-b">
								<option  value="1">Active</option>
								<option  value="0">In-Active</option>
							</select>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info" data-loading-text="Updating..." id="save_order" >Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>



<script>
	$('.order_modal').click(function() {
		var id=$(this).data('id');
		$('#prod_id').val(id);
	});


	$('#save_order').on('click',function() {
		var order_status = $('select[name="order_status"]').val();
		var prod_id =  $('#prod_id').val();

		$.ajax({
			url: 'dashboard.php',
			type: 'POST',
			data: { 'p_id': prod_id, 'status' : order_status,'action':'update_status' } ,
			contentType: 'json',
			success: function (response) {
				window.location='dashboard.php';
			},
		})

	});

</script>