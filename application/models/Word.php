<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Word extends CI_Model {

	public function getAll(){
		$data = ($this->db->get('word')->result_array());
		return $data;
	}

	public function getById($id){
		$this->db->where('id', $id);
		$data = ($this->db->get('word')->result_array());
		return $data;
	}

	public function getByCat($id_cat){
		$this->db->where('word_id_cat', $id_cat);
		$data = ($this->db->get('word')->result_array());
		return $data;
	}

	public function get_cat_name($cat_id){
		switch ($cat_id) {
			case 1:
				return "animal";
				break;

			default:
				return "animal";
				break;
		}
	}

	public function get_word_none_audio(){
		$id = 1;
		$rs = $this->getAll();
		$arr_files_audio = scandir(APPPATH."../asset/audio");
		foreach ($rs as $key => $value) {
			if(!in_array(strtolower($value["word_name"]).".mp3", $arr_files_audio)){
				$result[] = $value["word_name"];
			}
		}
		return (array)$result;
	}

	public function get_list_audio(){
		$list_dir = scandir(APPPATH."../asset/audio/");
		foreach ($list_dir as $key => $value) {
			preg_match("/([a-z]+)/", $value,$match);
			$return[$match[1]] = $value;
		}

		return $return;
	}



	public function get_list_image(){
		$list_dir = scandir(APPPATH."../asset/images/");
		foreach ($list_dir as $key => $value) {
			preg_match("/([\w]+)_/", $value,$match);
			$return[strtolower($match[1])] = $value;
		}

		return $return;
	}

	public function insert_vocabulary($data){
		if(!$data["word_name"]) return false;
		$this->db->insert('word', $data);
	}

	public function insert_word_form_array($array=[]){
		if($array["word_name"]=="") return fasle;
	}

	/*
		Function total_check
	*/
	public function total_check(){
		$rs = $this->getAll();
		foreach ($rs as $key => $value) {
			$this->_strtolower_all_word_name($value);
			$this->_strtolower_all_word_image($value);
		}
		return $return;
	}

	/*
		Function _strtolower_all_word_name
		Kiểm tra và update lại word_name không viết hoa
	*/
	private function _strtolower_all_word_name($value){
		if(preg_match("/([A-Z])/",$value["word_name"])){
			$object = ["word_name" => strtolower($value["word_name"])];
			$this->db->where('id', $value["id"]);
			if($this->db->update('word', $object)){
				$return = $value["word_name"];
			}
		}
		return $return;
	}

	/*

		Function _strtolower_all_word_image
		Kiểm tra và update lại word_image không viết hoa

	*/
	private function _strtolower_all_word_image($value){
		if(preg_match("/([A-Z])/",$value["word_image"])){
			$object = ["word_image" => strtolower($value["word_image"])];
			$this->db->where('id', $value["id"]);
			if($this->db->update('word', $object)){
				$return[] = $value["word_image"];
			}
		}
		return $return;
	}
}

/* End of file word.php */
/* Location: ./application/models/word.php */