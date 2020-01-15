<?php
session_start();
include_once("class/Crud.php");
$crud = new Crud();
if (!$crud->is_loggedin()) {
	header('location:index.php');
}
?>