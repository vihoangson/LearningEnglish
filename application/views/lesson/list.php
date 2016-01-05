<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('_include/header'); ?>
	<h1>Danh sách từ</h1>
		<audio class="audioDemo play_sound" controls preload="auto" hidden="hidden"> 
		   <source src="" type="audio/mp3">
		</audio>
			<div class="alert alert-info">
				<strong>Từ vựng </strong> 1-20
			</div>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th class="vietnamese" style="display:none;"></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
	$i=1;
	foreach ($data as $key => $value) {
		?>
		<tr class="detail_word">
			<td><h2 class="word_key" data-word="<?php echo strtolower($value["word_name"]); ?>"><?php echo $value["word_name"]; ?></h2>
			<?php  echo ($value["word_audio"]?"audio":""); ?></td>
			<td><h2><?php echo ($value["word_prononciation"]?"/".$value["word_prononciation"]."/":""); ?></h2></td>
			<td class="vietnamese" style="display:none;"><?php echo $value["word_mean"] ?></td>
			<td>
			<?php 
			for($i=0;$i<3;$i++){
				?> <img src='<?= base_url(); ?>asset/images/<?php echo str_replace(" ","_",$value["word_name"]); ?>_<?php echo $i; ?>.jpg'> <?php
			}
			?>
			</td>
		</tr>
		<?php
		if(($i%20)==0){
?>
				</tbody>
			</table>
			<div class="alert alert-info">
				<strong>Từ vựng </strong> <?php echo $i; ?> - <?php echo ($i)+20; ?>
			</div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th class="vietnamese" style="display:none;"></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
			<?php
		}
		$i++;
	}
?>
				</tbody>
			</table>

		<script>
		$(".detail_word").click(function(event) {
			word = $(this).find(".word_key").data("word");
			$(".play_sound source").attr("src","<?= base_url(); ?>asset/audio/"+word+".mp3");
			$(".play_sound").trigger('load');
			$(".play_sound").trigger("play");
			
		});
		
  $(document).unbind('keyup');
  $(document).keyup(function(e){
    if(e.which==113||e.which==114){
      console.log(e.which);
      $(".vietnamese").toggle();
      e.preventDefault();
    }
  });
		</script>

<?php $this->load->view('_include/footer'); ?>
