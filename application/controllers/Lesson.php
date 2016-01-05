<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson extends CI_Controller {

	public function index()
	{
		$this->load->view('lesson/index');
	}

	public function list_v()
	{
		$this->load->model('word');
		$data = [
			"data" => $this->word->getByCat($this->uri->segment(3)),
		];
		$this->load->view('lesson/list',$data);
	}

	public function test_v()
	{
		$this->load->model('word');
		$page=(int)$this->uri->segment(4);
		if($page==1 || $page==0){
			$page = 0;
		}else{
			$page = $page-1;
		}
		$id = $this->uri->segment(3);
		$per_page = 20;
		$rs = $this->word->getByCat($id);
		for($i=$page*$per_page;$i<$per_page*($page+1);$i++){
			$result[]=$rs[$i];
		}
		shuffle($result);
		if(!$this->uri->segment(4)){
			$page=0;
		}else{
			$page=(int)$this->uri->segment(4)-1;
		}
		$first_pos = $page * $per_page;
		$last_pos = ($page+1) * $per_page;

		$pagination = "";
		if($page>0){
			$pagination .= " <a href='".base_url()."Lesson/test_v/".$id."/".($page)."' class='btn btn-default'>Bài ".($page)."</a> ";
		}
		$pagination .= " Bài ".($page+1)." ";
		if($last_pos < count($rs)){
			$pagination .= " <a href='".base_url()."Lesson/test_v/".$id."/".($page+2)."' class='btn btn-default'>Bài ".($page+2)."</a> ";
		}
		

		$data = [
			"data" => $result,
			"pagination" => $pagination,
		];
		$this->load->view('lesson/test',$data);
	}

	public function learn_v()
	{

		$this->load->model('word');
		$page=(int)$this->uri->segment(4);
		if($page==1 || $page==0){
			$page = 0;
		}else{
			$page = $page-1;
		}
		$id = $this->uri->segment(3);
		$per_page = 20;
		$rs = $this->word->getByCat($id);
		for($i=$page*$per_page;$i<$per_page*($page+1);$i++){
			$result[]=$rs[$i];
		}		

		$data = [
			"data" => $result,
		];
		$this->load->view('lesson/learn',$data);
	}

	public function ajax_test(){
		$this->load->helper('LE');
		$this->load->model('word');
		$value = $this->word->getById($_POST["text"])[0];
		if(remove_special_character($value["word_mean"])== remove_special_character($_POST["type"])){
			echo 1;
		}else{
			echo "<h2>".$value["word_name"]."</h2>";
			echo "<h2>/".$value["word_prononciation"]."/</h2>";
			echo "<h2 class='vietnamese' style='display:none;'>".$value["word_mean"]."</h2>";
			echo "<div class='img_box'>";
			for($i=0;$i<19;$i++){
				echo "
				<div class='img_ele'>
					<img src='".base_url()."asset/images/".$value["word_name"]."_".$i.".jpg'/>
				</div>";
			}
			echo "</div>
			";
		}
		?>
		<script>
			word = $(".word"+cur).data("word");
			phatam(word);
			$(document).unbind('keyup');
			$(document).keyup(function(e){
				if(e.which==113||e.which==114){
					console.log(e.which);
					$(".vietnamese").toggle();
					e.preventDefault();
				}
			});
		</script>
		<?php
	}

}

/* End of file lesson.php */
/* Location: ./application/controllers/lesson.php */
