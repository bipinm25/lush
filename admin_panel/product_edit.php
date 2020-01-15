<?php
include_once("check_login.php");
include_once('class/common_settings.php');
include_once("class/Crud.php");
include_once("class/Validation.php");

$crud = new Crud();
$validation = new Validation();

if (isset($_GET['del_img_id']) && (int) $_GET['del_img_id']>0) {
	
	$p_id = $crud->delete_product_image((int) $_GET['del_img_id']);
	header("Location:product_edit.php?edit_id=".$p_id);
	exit();
}

$common_settings = $crud->getSettings();
$country = $crud->getData("select id,country,currency from country order by id");


if (isset($_GET['get_m_units']) && !empty($_GET['m_type'])) {
	echo json_encode($measurement_array[$_GET['m_type']]);
	exit;
}

$category_list = $crud->getData("select id,category from product_category where status=0 order by category");

if (isset($_GET['edit_id']) && (int) $_GET['edit_id'] > 0){
	$edit = true;
	$where_country = $_SESSION['is_global']?'':" and p.country_id=".$_SESSION['country_id']."";
	$get_product = $crud->getData("select p.name,p.country_id,p.category_id,p.description,p.price,p.product_code,p.measurement_type,p.measurement_value,p.measurement_unit,p.status,pi.id img_id,pi.thumb_path,pi.image_path from products p left join products_images pi on p.id=pi.product_id where p.id = ". (int) $_GET['edit_id']." and p.is_deleted=0 $where_country");
foreach ($get_product  as $k => $v) {
		if (!empty($v['thumb_path'])) {
			$image_path[$k]['org'] = $v['image_path'];
			$image_path[$k]['thumb'] = $v['thumb_path'];
			$image_path[$k]['img_id'] = $v['img_id'];
		}			
	}
	$get_product = isset($get_product[0])?$get_product[0]:'';
}else{
	$edit=false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$product_name = $crud->escape_string($_POST['product_name']);
	$product_code = $crud->escape_string($_POST['product_code']);
	$description = $crud->escape_string($_POST['description']);
	$_POST['product_price'] = $crud->escape_string($_POST['product_price']);
	$_POST['measurement_type'] = $crud->escape_string($_POST['measurement_type']);
	$_POST['measurement_value'] = $crud->escape_string($_POST['measurement_value']);
	$_POST['measurement_unit'] = $crud->escape_string($_POST['measurement_unit']);
	
	//@TODO
	//$msg = $validation->check_empty($_POST, array('product_name', 'product_category_id', 'product_price'));
	
	//$_POST['product_price']=number_format($_POST['product_price'], 2, '.', '');
	if ((int) $_POST['p_id'] == 0) {
		$updated="added=added";
		$last_insert_id = $crud->execute("INSERT INTO products(country_id,name,category_id,description,price,product_code,measurement_type,measurement_value,measurement_unit,status,added_date,added_by) VALUES(".$_POST['product_country_id'].",'$product_name',".$_POST['product_category_id'].",'$description',".$_POST['product_price'].",'$product_code','".$_POST['measurement_type']."',".$_POST['measurement_value'].",'".$_POST['measurement_unit']."',".$_POST['status'].",NOW(),'admin')");
	}
 else if ((int) $_POST['p_id'] > 0) {
	 $updated="added=updated";
	 $last_insert_id = (int) $_POST['p_id'];
	 $crud->execute("update products set country_id=".$_POST['product_country_id'].",name ='$product_name',
	 category_id = ".$_POST['product_category_id']." ,description ='$description' ,price = ".$_POST['product_price']." ,product_code ='$product_code' ,measurement_type ='".$_POST['measurement_type']."' ,measurement_value =".$_POST['measurement_value']." ,measurement_unit ='".$_POST['measurement_unit']."' ,status = ".$_POST['status']." ,update_date=NOW(),updated_by='admin' where id =$last_insert_id");
	}
	
	   if (sizeof($_FILES['upload_files']) > 0) {
	   
		   $crud->files_upload($last_insert_id, $_FILES['upload_files']);
		}
		
		header("Location:product_list.php?".$updated);
		exit();
	
	
	
 //@TODO
  //error_log(print_r($_FILES['upload_files'],1));

  
	
}
$bread_cums = ['Product List'=>'product_list.php','Product Add/Edit'=>''];

include_once('menu.php');
?>
<style>
	.img-wrap {
position: relative;
display: inline-block;
border: 1px #cac0c0 solid;
font-size: 0;
}
.img-wrap .close {
position: absolute;
top: 2px;
right: 2px;
z-index: 100;
background-color: #FFF;
padding: 5px 2px 2px;
color: #000;
font-weight: bold;
cursor: pointer;
opacity: .2;
text-align: center;
font-size: 18px;
line-height: 10px;
border-radius: 50%;
}
.img-wrap:hover .close {
opacity: 1;
}
</style>
              <div class="m-b-md">
                <h3 class="m-b-none">Mangae Products</h3>
              </div>
              <section class="panel panel-default">
                <header class="panel-heading font-bold">
                  Add/Edit Product
                </header>
                <div class="panel-body">
                  <form action="" class="form-horizontal" id="product_form" enctype="multipart/form-data" method="post">
						<input type="hidden" name="p_id" value="<?=$edit?(int) $_GET['edit_id']:0 ?>" />
						      <div class="form-group">
                      <label class="col-sm-2 control-label">Product Country</label>
                      <div class="col-sm-10">
                      <?=$_SESSION['is_global']?'':'<input type="hidden" name="product_country_id" value="'.$_SESSION['country_id'].'" />'?>
						<select name="product_country_id"  <?=$_SESSION['is_global']?'':'disabled="true"'?> class="form-control m-b">                     
                          <?php
							$select_country='';
							foreach ($country as $k => $countrys) {
								if ($edit) {
									$select_country = $get_product['country_id'] == $countrys['id']? 'selected="selected"':"" ;
								}else{
									$select_country = ($_SESSION['is_global']?'':$_SESSION['country_id']) == $countrys['id']? 'selected="selected"':"" ;
								}
								echo '<option '.$select_country.' data-currency="'.$countrys['currency'].'" value="'.$countrys['id'].'">'.$countrys['country'].'</option>';
						}
                          ?>                         
                        </select>
                      </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>
					<div class="form-group">
							<label class="col-sm-2 control-label" for="product_name">Product Name*</label>
						<div class="col-sm-10">
								<input type="text" placeholder="Required" name="product_name" value="<?=$edit?$get_product['name']:"" ?>" class="form-control required_field" id="product_name">
						</div>
					</div>
                    <div class="line line-dashed line-lg pull-in"></div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Product Category</label>
                      <div class="col-sm-10">
								<select name="product_category_id" class="form-control m-b required_field">
                          <option value="">--SELECT--</option>
                          <?php
							$select_cat='';
							foreach ($category_list as $k => $category) {
								if ($edit) {
									$select_cat = $get_product['category_id'] ==$category['id']? 'selected="selected"':"" ;
								}
								echo '<option '.$select_cat.' value="'.$category['id'].'">'.$category['category'].'</option>';
						}
                          ?>                         
                        </select>
                      </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_code">Product Code*</label>
							<div class="col-sm-10">
								<input type="text" placeholder="Required" name="product_code" value="<?=$edit?$get_product['product_code']:"" ?>" class="form-control required_field" id="product_code">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="product_price">Price <span id="currency"></span></label>
							<div class="col-sm-10">
								<input type="text" placeholder="Required" name="product_price" value="<?=$edit?number_format($get_product['price'],2,".",""):"" ?>" class="form-control required_field" id="product_price">
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
					<label class="col-sm-2 control-label" for="measurement_type">Measurement*</label>
							<div class="col-sm-3">						
								<select name="measurement_type" id="measurement_type" class="form-control m-b">
								<?php
									foreach ($measurement_array as $m_type => $m_unit) {										
										echo'<option value="'.$m_type.'">'.$m_type.'</option>';
									}
								?>
								</select>					
							</div>
							<div class="col-sm-3">
								<input type="text" placeholder="Required" name="measurement_value" value="<?=$edit?number_format($get_product['measurement_value'],1,'.',''):"" ?>" class="form-control required_field" id="measurement_value">
							</div>
							<div class="col-sm-3">						
								<select name="measurement_unit" data-m_unit="<?=$edit?$get_product['measurement_unit']:"" ?>" id="measurement_unit" class="form-control m-b">									
								</select>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="5" name="description" class="form-control"><?=$edit?$get_product['description']:"" ?></textarea>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">Status</label>
							<div class="col-sm-10">
								<select name="status" id="status" class="form-control m-b">
									<option <?= $edit?($get_product['status']==1?'selected="selected"':''):'' ?> value="1">Active</option>
									<option <?= $edit?($get_product['status']==0?'selected="selected"':''):'' ?> value="0">In-Active</option>
								</select>
							</div>
						</div>
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
						<label class="col-sm-2 control-label">Product Image</label>
						<div class="col-sm-10">					
						<?php								
						if ($edit && !empty($image_path)) {							
							foreach ($image_path as $k => $img) {
								echo '<div class="img-wrap">
								<span class="close"><i class="fa fa-trash-o"></i></span>
											<img src="'.$img['thumb'].'" data-id="'.$img['img_id'].'">
											</div>&nbsp;';
																	
								//echo '<a href="Javascript:;" data-id="'.$img['img_id'].'"><img src="'.$img['thumb'].'" alt=""></a>&nbsp;';
							}
						}else{?>								
								<input type="file" name="upload_files[]" <?=$common_settings['is_multiple_upload']==1?'multiple':'' ?> class="filestyle required_field" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s"> 					
					<?php }	?>
								
                      </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>                    
                    <div class="form-group">
                      <div class="col-sm-4 col-sm-offset-2">                        
						<input type="submit" id="submit" value="<?= $edit?"Update":"Save" ?> Product" class="btn btn-primary">
                      </div>
                    </div>
                  </form>
                </div>
              </section>

  <?php
    include_once('footer.php');
   ?>
 <script>
	 $(function() {		 
		 var m_type = $('#measurement_type').val();
		 var m_unit=$("#measurement_unit").data('m_unit');
		 $.getJSON("?get_m_units=1&m_type="+m_type,function(data) {
			 $.each(data,function(k, v) {
				 if (m_unit==v) {
					 var selected='selected="selected"';
				 }
				 $("#measurement_unit").append('<option '+selected+' value="'+v+'">'+v+'</option>');
			 });
		 });
		 
	 });
	 
	 $('#submit').on('click',function(event) {
		
		 msg='';
		 $('.required_field').each(function(){			 
			if ($(this).val()=='') {				
				$(this).parent().parent().addClass('has-error');
				msg+=$(this).parent().parent().find('label').text()+' is required \n';			
			}else{
				$(this).parent().parent().removeClass('has-error');
			}
		 });
		 
		 if (msg.length>0) {
			 alert(msg);
			 event.preventDefault();
		 }else{
		 
			// $('#product_form').submit();
		 }
		 
		 
		
	 });
	 
	 $('INPUT[type="file"]').change(function () {
	 
		 var ext,f_size;
		 var l_file=[];
		 $.each(this.files,function(k,v){			 
			 ext = v.name.split('.').pop().toLowerCase();
			 f_size=(parseInt(v.size)/1024/1024).toFixed(2);
			 if (f_size>9) {
				 l_file.push(v.name);
			 }
		 });
		 
		 
		 if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
			 $('.bootstrap-filestyle').find('input').val('');
			 this.value = '';
			 alert('This is not an allowed file type!. Allowed types are jpg, jpeg, png');
			 return false;
		 }else{
			 if (l_file.length>0) {
				 $('.bootstrap-filestyle').find('input').val('');
				 this.value = '';
				 alert("File size is more than 9MB");
				 return false;
			 }
		 }	
		
	 });
	 
	 $('.img-wrap .close').on('click', function() {
		 var id = $(this).closest('.img-wrap').find('img').data('id');
		 if (confirm("Do you want to remove the image?")) {
			 location.href="product_edit.php?del_img_id="+id;
		 }
		
	 });
	 
	 $('select[name="product_country_id"]').on('change',function(){
	    var element = $(this).find('option:selected'); 
        var curr = element.data("currency");
        $("#currency").text('');
	 	if(curr.length>0) $("#currency").text(`(`+curr+`)`);
	 	
	 });
	 $(function(){
	 	$('select[name="product_country_id"]').trigger('change');
	 });
	 
 </script>