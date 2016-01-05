<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_word extends CI_Controller {

	public function index()
	{
		$this->load->model('word');
		$this->load->view('admin/word/index');
	}

	public function add_tag(){
		$this->load->view('admin/word/add_tag');
	}

	public function insert_new_word(){
		$this->load->model('word');
		//https://vi.speaklanguages.com/ti%E1%BA%BFng-anh/t%E1%BB%AB-v%E1%BB%B1ng/ph%C3%B2ng-b%E1%BA%BFp
		//http://speaklanguages.cachefly.net/sound/en/mp3/cup_m.mp3
		$array = ["cooker","dishwasher","freezer","kettle","oven","stove","toaster","washing_machine","bottle_opener","chopping_board","colander","corkscrew","frying_pan","juicer","kitchen_foil","kitchen_scales","ladle","mixing_bowl","oven_cloth","oven_gloves","rolling_pin","saucepan","sieve","tin_opener","tongs","tray","whisk","wooden_spoon","knife","fork_vocab","spoon","dessert_spoon","soup_spoon","tablespoon","teaspoon","carving_knife","chopsticks","cup","bowl","crockery","glass","jar","jug","mug","plate","saucer","sugar_bowl","teapot","wine_glass","bin","cling_film","cookery_book","dishcloth","draining_board","grill","kitchen_roll","plug","tea_towel","shelf","sink","tablecloth","washingup_liquid","to_do_the_dishes","to_do_the_washing_up","to_clear_the_table","refrigerator","grater","cheese_grater","scouring_pad","scourer","plastic_wrap","to_set_the_table","to_lay_the_table"];
		foreach ($array as $key => $value) {
			$value   = strtolower($value);
			$detail  = $this->_get_data_google_translate_api($value);
			$get_img = json_encode((array)$this->_get_image_of_word($value)["name_file"]);

			$object = [
				"word_name"          => str_replace("_", " ", $value),
				"word_mean"          => $detail[0],
				"word_prononciation" => $detail[8],
				"word_image"         => $get_img,
				"word_audio"         => $value.".mp3",
			];
			$this->word->insert_vocabulary($object);
		}
	}

	/*
	Kiểm tra từ có audio không, Nếu ko thì show ra link để download
	 */
	public function get_link_for_word_audio(){
		$this->load->model('word');
		$none_audio = $this->word->get_word_none_audio();
		print_r($this->word->total_check());
		foreach ($none_audio as $key => $value) {
			$value = strtolower($value);
			echo "
				<p>
					<a href='https://translate.google.com/translate_tts?ie=UTF-8&q=$value&tl=en&total=1&idx=0&textlen=9&tk=384427|261984&client=t&prev=input'>
						".$value."
					</a>
				</p>
			";
		}
	}

	private function _get_image_of_word($word){
		$string = file_get_contents("https://www.google.com/search?q=".$word."&es_sm=122&source=lnms&tbm=isch&sa=X&ved=0CAcQ_AUoAWoVChMIgNmD7KKMyQIVweOmCh1CKwHX&biw=1851&bih=952#q=".$word."&tbm=isch&tbs=itp:clipart&imgrc=dSVdnddBAfH_CM%3A");
		preg_match_all("/[\"\']((https\:\/\/encrypted-tbn).+?)[\"\']/",$string,$return );
		foreach($return[1] as $key => $value){
			if(downloadFile($value, APPPATH."../asset/images/".strtolower($word)."_".$key.".jpg")){
				$return_m["path"][] = APPPATH."../asset/images/".strtolower($word)."_".$key.".jpg";
				$return_m["name_file"][] = "".strtolower($word)."_".$key.".jpg";
			}
		}
		return $return_m;
	}

	private function _get_data_google_translate_api($word){
		$word = str_replace("_", " ", $word);
		$word = str_replace(" ", "%20", $word);
		$link = "https://translate.google.com/translate_a/single?client=t&sl=en&tl=vi&hl=vi&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&ie=UTF-8&oe=UTF-8&otf=1&ssel=0&tsel=0&kc=3&tk=208724|331224&q=".$word;
		$json = file_get_contents($link);
		$array = (array_values((explode(",", str_replace(["[","]","\""], ["","",""], $json)))) );
		return $array;
	}
}

/* End of file word.php */
/* Location: ./application/controllers/admin/word.php */