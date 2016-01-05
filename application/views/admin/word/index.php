<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php 
$data_header = [
	"navigation_bar"=>[
		base_url()."admin/"=>"Admin",
		base_url()."admin/control_word/add_tag"=>"Thêm tag",
	]
];

$this->load->view('_include/header',$data_header); ?>

<?php $this->load->view('_include/footer'); ?>
