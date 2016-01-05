<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('_include/header'); ?>
<style>
	.col-md-4 img {
		height: 115px;
	}
</style>
			<h1>Learning english</h1>
			<h3>Mời bạn chọn bài học</h3>

			<div class="row">
				<div class="col-md-4 text-center">
					<a href="<?= base_url(); ?>Lesson/index/1">
						<img src="<?= base_url(); ?>asset/img/animal.png">
						<p><h3>Animal</h3></p>
					</a>
				</div>
				<div class="col-md-4 text-center">
					<a href="<?= base_url(); ?>Lesson/index/2">
						<img src="<?= base_url(); ?>asset/img/kitchen.png">
						<p><h3>kitchen</h3></p>
					</a>
				</div>
				<div class="col-md-4">

				</div>
			</div>
<?php $this->load->view('_include/footer'); ?>
