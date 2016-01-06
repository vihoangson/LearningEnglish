<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_pro extends CI_Controller {

	public function __construct(){
		define("PATH_DB", FCPATH."asset/db/");
		parent::__construct();
		$this->load->model('Tuvung');
		require(APPPATH."libraries/simple_html_dom.php");
	}

	public function index(){
		$input = true;
		$this->load->view('pro/show',compact("input"));
	}

	public function show(){
		$dir = scandir(PATH_DB);
		if(empty($dir)){
			$this->get_in_list();
		}
		foreach ($dir as $key => $value) {
			$word = str_replace(".txt", "", $value);
			if(!($value == "." || $value == "..")){
				$rs[$word] = explode("||||||||",(file_get_contents(PATH_DB.$value)));
			}
		}
		$this->load->view('pro/show',compact("rs"));
	}

	public function get_in_list($string=null){
		$array_string = explode("\n", $this->input->post('list_word'));
		$array_string = array_map("trim", $array_string);
		$array_string = array_map("strtolower", $array_string);
		$array_string = array_filter($array_string);

		foreach ($array_string as $key => $value) {
			try {
				if(!($dom = @str_get_html(file_get_contents("http://www.oxforddictionaries.com/definition/english/".$value)))){
					echo "<h1>Error: ".$value."</h1>";
					continue;
				}
				$string1 = str_replace("Pronunciation:", "", strip_tags($dom->find(".headpron",0)->innertext));
				$string2 = ($dom->find(".entryPageContent",0)->innertext);
				$data = [
				"tuvung_name" => $value,
				"tuvung_prononciation" => $string1,
				"tuvung_mean" => $string2,
				];
				$this->Tuvung->insert_vocabulary($data);
				$dom->clear();
			} catch (Exception $e) {
				
			}
		}
		redirect('/get_pro','refresh');

	}
}
/* End of file get_pro.php */
/* Location: ./application/controllers/get_pro.php */