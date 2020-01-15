<?php
include_once('admin_panel/class/Crud.php');
$crud = new Crud();
include_once('admin_panel/mail/smtp.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$to_mail_id = 'info@lushshopee.com';
	$parts = explode("@", $to_mail_id);
	$to_name = $parts[0];
	$subject = 'Enquiry Request';


	$body = '<table>
<tr><td colspan="2"><b>Enquiry</b></td></tr>
<tr><td>Name :</td><td>'.$_POST['name'].'</td></tr>
<tr><td>Mobile :</td><td>'.$_POST['mobile'].'</td></tr>
<tr><td>Address :</td><td>'.$_POST['address'].'</td></tr>
<tr><td>Note :</td><td>'.$_POST['note'].'</td></tr>
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
	} else {
		$msg='failed';
	}

	header("Location:Contact.php?msg=$msg");
exit();
}


include_once('header.php');
?>

<section class="vc_row pt-50 pb-50">
<div class="container">
<div class="row">
<div class="lqd-column col-md-6">
<img src="assets/demo/misc/About.jpg" alt="Instagram Image 1">
</div>
<div class="lqd-column col-md-6"><br>
<h4>Locate Us</h4>
<p>Marine Drive, Broadway South End<br>
Ernakulam, Cochin, 682031, Kerala, India<br>

Call : +91 9744733676<br>

Email : info@lushshopee.com
<br>

				<div class="lqd-column">
				<form method="post">
					<input class="lh-25 rmb-4 textareanew" type="text" name="name" aria-required="true" aria-invalid="false" placeholder="Name" required="">
					<input class="lh-25 rmb-4 textareanew" type="tel" name="mobile" aria-required="true" aria-invalid="false" placeholder="Mobile No" required="">
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
	if ( isset($_GET['msg']) && $_GET['msg']=='success') {
		?>
		alert("Enquiry send Successfully");
		<?php } ?>
</script>