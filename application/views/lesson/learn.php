<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$data_header= [
		"css"=>[
			base_url()."asset/css/lesson_test.css",
			//base_url()."asset/bower_components/jquery-ui/themes/base/jquery-ui.min.css"
		],
		//"js"=>[base_url()."asset/bower_components/jquery-ui/jquery-ui.min.js"]
	];
	$this->load->view('_include/header',$data_header);

	?>
<style>
	.correct{

	}
</style>
	<?php
	shuffle($data);
	$i=0;
	?>
<div style="height:70px;">
<div class="alert alert-danger " style="display:none;" >
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Incorrect</strong> Please rechoice
</div>
<div class="alert alert-success " style="display:none;" >
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Correct</strong> Congratulation
</div>
</div>
	<?php
	echo '<button class="btn btn-default btn-repeat">Repeat</button><hr>';
	while(true){
		if($i>3){
			echo "<h1>overload</h1>";
			break;
		}
		if(file_exists(APPPATH."../asset/audio/".$data[$i]["word_name"].".mp3")){
			break;
		}
		$i++;
	}

	for($j=0;$j<20;$j++){
		$arr[] = $j;
	}
	shuffle($arr);
	foreach ($arr as $key => $value) {
		?> <img class="<?= ($value==0?"correct":""); ?>" data-word="<?= strtolower($data[$i+$value]["word_name"]); ?>" src="<?= base_url(); ?>asset/images/<?= str_replace(" ","_",$data[$i+$value]["word_name"]); ?>_0.jpg"> <?php 
	}
?>
		<audio class="audioDemo play_sound" controls preload="auto" hidden="hidden" autoplay> 
			<source src="<?= base_url(); ?>asset/audio/<?= $data[$i]["word_name"]; ?>.mp3" type="audio/mp3">
		</audio>
		<script>
			$(".correct").click(function(event) {
				phatam($(this).data("word"));
				$(".alert-success").fadeIn(300,function(){
					$(this).delay(1000).fadeOut(300);
				});
				window.setTimeout(function(){
					location.reload();
				},1000);
			});
			$("img[class!='correct']").click(function(event) {
				phatam($(this).data("word"));
				$(".alert-danger").fadeIn(300,function(){
					$(this).delay(1000).fadeOut(300);
				});
			});
			$(".btn-repeat").click(function(){
				phatam($(".correct").data("word"));
			});

			function phatam(word){
				$(".play_sound source").attr("src","<?= base_url(); ?>asset/audio/"+word+".mp3");
				$(".play_sound").trigger('load');
				$(".play_sound").trigger("play");
			}
		</script>
<?php $this->load->view('_include/footer'); ?>
