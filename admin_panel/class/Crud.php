<?php
include_once 'DbConfig.php';

class Crud extends DbConfig
{
	public function __construct()
	{
		parent::__construct();		
		/*if (!$this->is_loggedin()) {
			header('location:index.php');
		}*/
	}
	
	public function getData($query)
	{		
		$result = $this->connection->query($query);
		
		if ($result == false) {
			return false;
		} 
		
		$rows = array();
		
		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}
		
		return $rows;
	}
		
	public function execute($query) 
	{
		$result = $this->connection->query($query);
		
		if ($result == false) {
			error_log('Error: ' . $query . '<br>' . $this->connection->error);
			return false;
		} else {
			return $this->connection->insert_id;
		}		
	}
	
	public function number_of_records($query)
	{	
		$result = $this->connection->query($query);		
		return $result->num_rows;
	}
	
	public function delete($id, $table, $column_name = "") 
	{ 
		$query = "DELETE FROM $table WHERE $column_name = $id";
		
		$result = $this->connection->query($query);
	
		if ($result == false) {
			echo 'Error: cannot delete '.$column_name.' ' . $id . ' from table ' . $table;
			return false;
		} else {
			return true;
		}
	}
	
	public function escape_string($value)
	{
		return $this->connection->real_escape_string($value);
	}
	
	public function files_upload($table_id, $files)
	{	
		$thumb_width = 100;
		$thumb_height = 90;
		$upload_dir = 'front_end/gallery/';
		$upload_dir_thumbs = 'front_end/gallery/thumb/';		
			
		foreach ($files['name'] as $key=>$val) {
			$filename = $files['name'][$key];
			$path_parts = pathinfo($filename);
			$temp = explode(".", $filename);
			$newfilename = round(microtime(true)).'_'.$path_parts['filename'] . '.' . end($temp);			
			$upload_file = $upload_dir.$newfilename;
			
			if (move_uploaded_file($files['tmp_name'][$key],$upload_file)) {
				$this->createThumbnail($newfilename, $thumb_width, $thumb_height, $upload_dir, $upload_dir_thumbs);
				$this->execute("insert into products_images(product_id,image_path,thumb_path,added_date,added_by) VALUES($table_id,'$upload_file' ,'".$upload_dir_thumbs.$newfilename."' ,NOW(),'admin')");
			}
		}		
		
	}
	
	public function createThumbnail($filename, $thumb_width, $thumb_height, $upload_dir, $upload_dir_thumbs)
	{
		$upload_image = $upload_dir.$filename;
		$thumbnail_image = $upload_dir_thumbs.$filename;
		
		list($width,$height) = getimagesize($upload_image);
		$thumb = imagecreatetruecolor($thumb_width,$thumb_height);
		
		if (preg_match('/[.](jpg|jpeg)$/i', $filename)) {
			$image_source = imagecreatefromjpeg($upload_image);
		} else if (preg_match('/[.](gif)$/i', $filename)) {
			$image_source = imagecreatefromgif($upload_image);
		} else if (preg_match('/[.](png)$/i', $filename)) {
			$image_source = imagecreatefrompng($upload_image);
		} else {
			$image_source = imagecreatefromjpeg($upload_image);
		}
		imagecopyresized($thumb,$image_source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
		if (preg_match('/[.](jpg|jpeg)$/i', $filename)) {
			imagejpeg($thumb,$thumbnail_image,100);
		} else if (preg_match('/[.](gif)$/i', $filename)) {
			imagegif($thumb,$thumbnail_image,100);
		} else if (preg_match('/[.](png)$/i', $filename)) {
			imagepng($thumb,$thumbnail_image,100);
		} else {
			imagejpeg($thumb,$thumbnail_image,100);
		}
	}
	
	public function delete_file($_id){
		
		$list_date = $this->getData("select image_path,thumb_path from products_images where product_id=$_id");
				
		foreach ($list_date as $k=>$path) {
			if (file_exists($path['thumb_path'])) {
				unlink($path['thumb_path']);
			}
			if (file_exists($path['image_path'])) {
				unlink($path['image_path']);
			}			
		}
		
		return $this->delete($_id,"products_images","product_id");		
		
	}
	
	public function delete_product_image($img_id)
	{
		$img_details = $this->getData("select product_id,image_path,thumb_path from products_images where id='".$img_id."'");
		$img_details = $img_details[0];
		$prod_id = $img_details['product_id'];
		
		if (file_exists($img_details['thumb_path'])) {
			unlink($img_details['thumb_path']);
		}
		if (file_exists($img_details['image_path'])) {
			unlink($img_details['image_path']);
		}
		
		$this->delete($img_id,"products_images","id");
		
		return $prod_id;
	}
	
	public function getSettings(){
		
		$settings = $this->getData("select * from common_settings LIMIT 1");
		
		return (array) $settings[0];
	}
	
	public function login($user, $pass, $country){
		
		$result = $this->getData("select id,username,country_id from users WHERE username='$user' and password='$pass' and country_id=$country LIMIT 1");
		if (!empty($result) && sizeof($result[0])>0 ) {
			session_start();
			$_SESSION['user_id'] = $result[0]['id'];
			$_SESSION['user_name'] = $result[0]['username'];
			$_SESSION['country_id'] = $result[0]['country_id'];
			$_SESSION['is_global'] = $result[0]['country_id']==1?true:false;			
			$_SESSION['login'] = true;
			$this->getCountry();
			return true;			
		}else{
			return false;
		}	
		
	}
	
	public function getCountry(){
		if(!isset($_SESSION['country'])){
			$country = $this->getData("select id,country,currency from country order by id");
			foreach ($country as $k => $countrys) {
				$_SESSION['country'][$k]=['id' => $countrys['id'],'country' => $countrys['country'], 'currency' => $countrys['currency'] ];			
			}
		}
		
	}
	
	public function dashboard_data()
	{
		$where = $_SESSION['is_global']?'':" and p.country_id=".$_SESSION['country_id']."";
		
		$total_orders = $this->number_of_records("select po.id from product_order po left join products p on po.product_id=p.id where 1=1 $where");
		
		$today = $this->number_of_records("select po.id from product_order po left join products p on po.product_id=p.id where 1=1 $where and date(po.order_date)='".date('Y-m-d')."'");
		
		list($w_start,$w_end) = $this->x_week_range(date('Y-m-d'));
		
		$week = $this->number_of_records("select po.id from product_order po left join products p on po.product_id=p.id where 1=1 $where and date(po.order_date) between '".$w_start."' and '".$w_end."' ");
		
		$month = $this->number_of_records("select po.id from product_order po left join products p on po.product_id=p.id where 1=1 $where and date(po.order_date) between '".date('Y-m-1')."' and '".date('Y-m-t')."' ");
		
		$category_total = $this->getData("select pc.category,case when t.tot is null then 0 else t.tot end total  from (
											SELECT p.category_id,COUNT(po.id) tot FROM `product_order` po
											left join products p on po.product_id=p.id where 1=1 $where
											group by p.category_id) t right join product_category pc on t.category_id=pc.id");
											
		foreach ($category_total as $k => $val) {
			$category[$val['category']]	= $val['total'];
		}
		
		for ($i = 1; $i < 6; $i++) {
			if ($i==5) {
				$month_start = date('Y-m-1', strtotime("-$i month")); //last 6 month
			}
		}
		$month_end = date('Y-m-t');
		
		$chart_data = $this->getData("SELECT pc.category,month(order_date) month,count(p.category_id) total FROM  product_order po
										left join products p on po.product_id=p.id
										right join product_category pc on p.category_id=pc.id
										where  date(po.order_date) between '".$month_start."' and '".$month_end."' $where
										group by p.category_id,month(order_date)");
										
										$category_color_Chart =[ 'cakes' =>'#f73b3b', 'chocolate'=>'#3abf9a', 'gift box' => '#3471e0', 'offers' =>'#c836ec'];
										$chart_data_new=[];
										foreach ($chart_data as $k=>$chart) {
											if (!empty($chart['month'])) {
												$chart_data_new[$chart['category']][$chart['month']] = $chart['total'];
												$chart_data_new[$chart['category']]['color'] = $category_color_Chart[$chart['category']];										
											}
										}									
		
		$data = ['orders' => ['total' => $total_orders, 'today' => $today, 'week' => $week, 'month' => $month  ],
				 'category' =>$category,
				 'chart' =>$chart_data_new ];
				 
		 return $data;			
	}
	
	public function product_order_request($post_data){
		
		$order_number = $this->getData("select case when max(order_number) is null then 100 else max(order_number)+1 end max_num from product_order");
		
		$order_id = '#LU'.$order_number[0]['max_num'];
		
		
		$sql = "insert into product_order(order_number,order_id,product_id,name,mobile,email_id,status,address,note,order_date) values(".$order_number[0]['max_num'].",'".$order_id."',".$post_data['p_id'].",'".$post_data['name']."','".$post_data['mobile']."','".$post_data['email_id']."',1,'".$post_data['address']."','".$post_data['note']."',NOW())";
		
		$this->execute($sql);
			
		return $order_id;		
	}
	
	public function x_week_range($date)
	{
		$ts = strtotime($date);
		$start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
		return array(date('Y-m-d', $start),
		date('Y-m-d', strtotime('next saturday', $start)));
	}

	
	public function is_loggedin(){
		
		return $_SESSION['login'];
	}
	
	public function get_session()
	{		
		return $_SESSION['login'];		
	}
	
	public function user_logout()
	{		
		$_SESSION['login'] = FALSE;		
		session_destroy();		
	}
	
	function is_decimal($val)
	{
		return is_numeric($val) && floor($val) != $val;
	}

	
	
	
}
?>
