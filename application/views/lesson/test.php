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

			<p>
				<a href="<?= base_url(); ?>Lesson/index/<?= $this->uri->segment(3); ?>" id="" class="btn btn-info">Trở lại</a>
				<div class="well"><?= $pagination; ?> </div>
			</p>
			<div class="box_word" data-cur="0">
				<?php
				foreach ($data as $key => $value) {
					echo '<span class="word'.$key.'" data-pos="'.$key.'" data-word-id="'.$value["id"].'" data-mean="'.htmlentities($value["word_mean"]).'" data-word="'.strtolower($value["word_name"]).'">'.$value["word_name"].'</span>';
					if($key == 20){
						break;
					}
				}
				?>
				<div class="clearfix"></div>
			</div>
			<input type="text" name="" id="input" class="typing form-control" value="" required="required" pattern="" title="">
			<hr>
			<button type="button" id="trogiup" class="btn btn-warning">Trợ giúp</button>
			<button type="button" id="xemketqua" class="btn btn-danger">Xem kết quả</button>
		</div>
		<audio class="audioDemo play_sound" controls preload="auto" hidden="hidden"> 
		   <source src="" type="audio/mp3">
		</audio>


		<script>
				if(false){
					$.post('<?= base_url(); ?>ajax/word_in_cat', {id: '1'}, function(data, textStatus, xhr) {
						$(".box_word").html("");
						page = 0;
						per_page =22;
						$.each(data, function(index, val) {
							if((page*per_page) < index && index < ((page+1)*(per_page))){
								$(".box_word").append('\
									<span class="word'+index+'" data-pos="'+index+'" data-word-id="'+val["id"]+'" data-mean="'+(val["word_mean"])+'" data-word="'+(val["word_name"])+'">\
									'+val["word_name"]+'\
									</span>\
								');
							}
						});
					});
				}


				$(".box_word span").each(function(index, el) {
					$(this).prepend("<p class='mean' style='display:none'>"+$(this).data("mean")+"</p>");
				});

				$(".typing").focus();
				cur = 0;
				$(".word"+cur).addClass('current');	
				word = $(".word"+cur).data("word");
				phatam(word);
				$(".box_word").data("cur",parseInt($(".box_word").data("cur")));


				$("#trogiup").click(function(event) {
					open_meaning(200);
				});

				$("#xemketqua").click(function(event) {
					if($(".mean").length==0){
						open_meaning(20000);
						$(".typing").remove();		
						$("#xemketqua").html("Làm lại");
					}else{
						location.reload();
					}
				});



				$(".box_word span").click(function(event) {
					$(".current").removeClass('current');
					cur = $(this).data("pos");
					$(".box_word").data("cur",cur)
					$(this).addClass('current');
					word = $(this).data("word");
					phatam(word);
					$(".typing").focus();
				});
				$(".typing").keyup(function(event) {
					if(event.which==112){
						$(".mean").fadeOut(200);
						event.preventDefault();
					}
				});

				$(".typing").keydown(function(event) {
					if(event.which==116){
					}
					if(event.which==112){
						$(".mean").fadeIn(200);
						event.preventDefault();
					}
					if(event.which==113){
						word = $(".word"+cur).data("word");
						phatam(word);
						event.preventDefault();
					}
					if(event.which==114){
						event.preventDefault();
					}
				});

			$(".typing").keyup(function(event) {
				if(event.which==13){
					$.ajax({
						url: '<?= base_url(); ?>Lesson/ajax_test/',
						type: 'post',
						dataType: 'text',
						data: {text: $(".word"+cur).data("word-id"),type:$(".typing").val()},
					})
					.done(function(data) {
						if(parseInt(data)==1){
							if($(".card").length==0){
								$("body").append("<div class='card'></div>");
							}
							$(".card").html("\
								<div class='review_box'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_0.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_1.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_2.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_3.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_4.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_5.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_6.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_7.jpg'>\
								<img src='<?= base_url(); ?>asset/images/"+word+"_8.jpg'>\
								</div>\
								");
							$(".card").fadeIn(200);
							window.setTimeout(function(){
								$(".card").fadeOut(200);
								$(".typing").val("");
							}, 100);
							phatam(word);

							$(".word"+(parseInt(cur))).addClass('success');
							$(".typing").val("");
							$(".box_word").data("cur",parseInt($(".box_word").data("cur"))+1);
							$(".current").removeClass('current');
							check_success();
							cur = $(".box_word").data("cur");
							$(".word"+cur).addClass('current');
							word = $(".word"+cur).data("word");
							phatam(word);



						}else{
							$(".word"+(parseInt(cur))).addClass('error');
							if($(".card").length==0){
								$("body").append("<div class='card'></div>");
							}
							$(".card").html(data);
							$(".card").fadeIn(200);
							window.setTimeout(function(){
								$(".card").fadeOut(200);
								$(".typing").val("");
							}, 1000);
						}					
					});
				}
			});

			function check_success(){
				if($(".box_word span.success").length==$(".box_word span").length){
					$("body").append('\
						<!-- Modal -->\
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
							<div class="modal-dialog" role="document">\
								<div class="modal-content">\
									<div class="modal-header">\
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
										<h4 class="modal-title" id="myModalLabel">Chúc mừng</h4>\
									</div>\
									<div class="modal-body">\
										Bạn đã hoàn thành xong ! \
									</div>\
									<div class="modal-footer">\
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
										<a href="<?= base_url(); ?>Lesson/index/<?= $this->uri->segment(3); ?><?php  ?>" class="btn btn-primary" >Trở về trang trước</a>\
									</div>\
								</div>\
							</div>\
						</div>\
					');
					$('#myModal').modal();
				}
			}

			function open_meaning(time_open){
				if($(".mean").length==0){
					$(".mean").fadeIn(200);
					window.setTimeout(function(){
						$(".mean").remove();
					}, time_open);
				}
			}

			function phatam(word){			
				$(".play_sound source").attr("src","<?= base_url(); ?>asset/audio/"+word+".mp3");
				$(".play_sound").trigger('load');
				$(".play_sound").trigger("play");
			}
		</script>
<?php $this->load->view('_include/footer'); ?>
