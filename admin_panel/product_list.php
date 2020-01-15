<?php
include_once("check_login.php");
include_once('class/common_settings.php');
include_once("class/Crud.php");
$crud = new Crud();

if (isset($_GET['del_id']) && (int) $_GET['del_id']>0) {

	$crud->delete_file((int) $_GET['del_id']);
	
	$crud->execute("update products set is_deleted=1,deleted_by='admin',deleted_date=NOW() where id=".(int) $_GET['del_id']."");
	header("Location: product_list.php");
	exit();
}

$category_list = $crud->getData("select id,category from product_category where status=0 order by category");

$country = $crud->getData("select id,country from country order by id");

$where = "";
if (isset($_GET['unset_filter']) && $_GET['unset_filter']==1) {
	$_GET['category_id'] = "";
	$_GET['country_id'] = "";
	$_GET['p_name'] = "";
}else{
	if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
		$where.=" and p.category_id = ".(int) $_GET['category_id'];
	}
	if (isset($_GET['country_id']) && !empty($_GET['country_id'])) {
		$where.=" and p.country_id = ".(int) $_GET['country_id'];
	}
	if (isset($_GET['p_name']) && !empty($_GET['p_name'])) {
		$where.=" and p.name like '%".$crud->escape_string($_GET['p_name'])."%'";
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

$sql="SELECT p.id,p.name,co.country,co.currency,p.category_id,pc.category,p.price,p.product_code,p.status,p.measurement_type m_type,p.measurement_value m_value,p.measurement_unit m_unit,date(p.added_date) added_date,(select thumb_path from products_images where product_id=p.id order by id desc limit 1 ) as thumb FROM `products` p left join product_category pc on p.category_id=pc.id left join country co on p.country_id=co.id
where p.is_deleted=0 $where order by p.id desc ";

$total_rows = $crud->number_of_records($sql);
$total_pages = ceil($total_rows / $no_of_records_per_page);

$products_list = $crud->getData("$sql LIMIT $offset, $no_of_records_per_page");

$bread_cums = ['Product'=>'product_list.php'];

include_once('menu.php');
?>
<div class="m-b-md">
	<h3 class="m-b-none">Mangae Products</h3>
</div>

			<?php
			if (isset($_GET['added']) && !empty($_GET['added']) ) {
				echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="fa fa-ok-sign"></i>
				<strong>Done!</strong> You successfully '.$_GET['added'].' the product
				</div>';
			}	?>
			
<section class="panel panel-default">
	<header class="panel-heading">
		Product List
	</header>
	<div class="row wrapper">
	<form method="get">
			<div class="col-lg-2">
			<select name="category_id" class="input-sm form-control input-s-sm inline v-middle">
			<option value="">Select category</option>
				<?php foreach ($category_list as $k => $category) {
					$select_cat='';
					if (isset($_GET['category_id'])) {
						$select_cat = (int) $_GET['category_id'] == $category['id']? 'selected="selected"':"" ;
					}						
					echo '<option '.$select_cat.' value="'.$category['id'].'">'.$category['category'].'</option>';
					}
				?>				
			</select>
						
		</div>
		<?php 
		if($_SESSION['is_global']){ ?>
			<div class="col-lg-2">
			<select name="country_id" class="input-sm form-control input-s-sm inline v-middle">
			<option value="">Select Country</option>
				<?php 
				$select_country='';
				foreach ($country as $k => $countrys) {
								if (isset($_GET['category_id'])) {
									$select_country = (int) $_GET['country_id'] == $countrys['id']? 'selected="selected"':"" ;
								}
								echo '<option '.$select_country.' value="'.$countrys['id'].'">'.$countrys['country'].'</option>';
						}
				?>				
			</select>
						
		</div>
		<?php } ?>
		
					<div class="col-lg-4">
						<div class="input-group">
								<input type="text" name="p_name" value="<?=isset($_GET['p_name'])?$_GET['p_name']:"" ?>" class="input-sm form-control" placeholder="Product name">
							<span class="input-group-btn">
								<button class="btn btn-sm btn-default" type="submit">Search</button>
								<button class="btn btn-sm btn-default" value="1" name="unset_filter">Clear</button>
							</span>
						</div>
					</div>					
					<div class="col-lg-2-4"></div>
					</form>
					
					
					<div class="col-lg-2">
						<a href="product_edit.php" class="btn btn-s-md btn-primary">Add Product</a>
			
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped b-t b-light">
			<thead>
				<tr>
				    <th>Country</th>				
					<th>Product Name</th>
					<th>Category</th>
					<th>Product Code</th>
					<th>Price</th>
					<th>Weight</th>
					<th>Status</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
							<?php							
							if ($products_list){
								foreach ($products_list as $k => $products) {
									$products['price'] = number_format($products['price'], 2, '.', '');
									$weight = number_format($products['m_value'], 2, '.', '').' '.$products['m_unit'];
									$status = ($products['status']==1)?'<span class="label label-success">Active</span>':'<span class="label label-danger">In-Active</span>';
									echo '<tr>
								<td>'.$products['country'].'</td>
								<td>'.$products['name'].'</td>
								<td>'.$products['category'].'</td>
								<td>'.$products['product_code'].'</td>
								<td>'.$products['currency'].' '.$products['price'].'</td>
								<td>'.$weight.'</td>
								<td>'.$status.'</td>
								<td><a href="product_edit.php?edit_id='.$products['id'].'"><i class="fa fa-edit"></i></a>
								<a onclick="delete_product('.$products['id'].')" href="javascript:;"><i class="fa fa-trash-o"></i></a></td>
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
							<small class="text-muted inline m-t-sm m-b-sm">Total Products : <?=$total_rows?></small>							
			</div>
			<div class="col-sm-4 text-right text-center-xs">
			<?php	
							$params=[];
							if(isset($_GET['category_id'])) {
								$params['category_id'] = (int) $_GET['category_id'];
							}
							if(isset($_GET['country_id'])) {
								$params['country_id'] = (int) $_GET['country_id'];
							}
							if (isset($_GET['p_name'])) {
								$params['p_name'] = $_GET['p_name'];
							}				

							$url_params = sizeof($params)>0?'&'.http_build_query($params):'';			
						?>
							<ul class="pagination">
								<li>
									<a href="?pageno=1<?=$url_params?>">First</a></li>
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
<?php  include_once('footer.php'); ?>
 <script>
 	function delete_product(id){
		if (confirm("Do you want to delete this product?")) {
			window.location.href ='product_list.php?del_id='+id;
		}
 	}
 </script>