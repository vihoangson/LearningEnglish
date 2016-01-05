<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function word_in_cat()
	{
		if(!$_REQUEST["id"]) return false;
		$this->load->model('word');
		header('Content-Type: application/json');
		echo json_encode($this->word->getByCat($_REQUEST["id"]));
	}

	public function autocomplete(){
		header('Content-Type: application/json');
		//if(strlen($_POST["var_input"]) < 2) return;
		$this->db->like( 'word_name' , $_POST["var_input"] );
		$this->db->limit(10);
		$arr = $this->db->get('word')->result_array();
		foreach ($arr as $key => $value) {
			$arr_m[] = $value["word_name"];
		}
		echo json_encode((array)$arr_m);
	}
}

/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */