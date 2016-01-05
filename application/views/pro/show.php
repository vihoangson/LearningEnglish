<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="//code.jquery.com/jquery.js"></script>
	</head>
	<body>
		<div class="container">
		<ul class="nav navbar-nav">
			<li class="active">
				<a href="<?= base_url(); ?>get_pro/index">Homepage</a>
			</li>
			<li>
				<a href="<?= base_url(); ?>get_pro/show">Show</a>
			</li>

		</ul>
		<div class="clearfix"></div>
			<?php
			if(!empty($input)){
				?>
				<form action="<?= base_url(); ?>get_pro/get_in_list" method="POST" role="form">
					<legend>Form title</legend>
				
					<div class="form-group">
						<label for="">label</label>
						<textarea name="list_word"  type="text" class="form-control" id="" placeholder="Input field"></textarea>
					</div>
				
					
				
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
				<?php
			}
			if(!empty($rs)){
				foreach ($rs as $key => $value) {
					$word = str_replace(".txt", "", $key);
					?>
					<h1><?= $key; ?></h1>
					<h4><?= strip_tags($value[0]); ?></h4>
					<button onclick="$('.toggle_div_<?= $word; ?>').toggle();" type="button" class="btn btn-primary">Show</button>
					<div style="display:none;" class=" toggle_div_<?= $word; ?>" ><?= ($value[1]); ?></div>
					<?php
				}
			}
			 ?>
		</div>
		<!-- jQuery -->
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>