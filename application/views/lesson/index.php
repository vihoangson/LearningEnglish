<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('_include/header'); ?>
			<h1>Learning english</h1>
			<h3>Mời bạn chọn nội dung</h3>
			<div class="list-group">
				<a href="<?= base_url(); ?>Lesson/list_v/<?= $this->uri->segment(3); ?>" class="list-group-item">List vocabulary</a>
				<a href="<?= base_url(); ?>Lesson/learn_v/<?= $this->uri->segment(3); ?>" class="list-group-item">Learn vocabulary</a>
				<a href="<?= base_url(); ?>Lesson/test_v/<?= $this->uri->segment(3); ?>" class="list-group-item">Test vocabulary</a>
				
			</div>
<?php $this->load->view('_include/footer'); ?>
