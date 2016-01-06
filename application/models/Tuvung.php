<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tuvung extends CI_Model {

	public function getAll(){
		$data = ($this->db->get('tuvung')->result_array());
		return $data;
	}

	public function getById($id){
		$this->db->where('id', $id);
		$data = ($this->db->get('tuvung')->result_array());
		return $data;
	}

	public function getByCat($id_cat){
		$this->db->where('tuvung_id_cat', $id_cat);
		$data = ($this->db->get('tuvung')->result_array());
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

	public function get_tuvung_none_audio(){
		$id = 1;
		$rs = $this->getAll();
		$arr_files_audio = scandir(APPPATH."../asset/audio");
		foreach ($rs as $key => $value) {
			if(!in_array(strtolower($value["tuvung_name"]).".mp3", $arr_files_audio)){
				$result[] = $value["tuvung_name"];
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
		if(!$data["tuvung_name"]) return false;
		if($this->db->where('tuvung_name', $data["tuvung_name"])->get('tuvung')->num_rows()==0){
			$this->db->insert('tuvung', $data);
		}
	}

	public function insert_tuvung_form_array($array=[]){
		if($array["tuvung_name"]=="") return fasle;
	}

	/*
		Function total_check
	*/
	public function total_check(){
		$rs = $this->getAll();
		foreach ($rs as $key => $value) {
			$this->_strtolower_all_tuvung_name($value);
			$this->_strtolower_all_tuvung_image($value);
		}
		return $return;
	}

	/*
		Function _strtolower_all_tuvung_name
		Kiểm tra và update lại tuvung_name không viết hoa
	*/
	private function _strtolower_all_tuvung_name($value){
		if(preg_match("/([A-Z])/",$value["tuvung_name"])){
			$object = ["tuvung_name" => strtolower($value["tuvung_name"])];
			$this->db->where('id', $value["id"]);
			if($this->db->update('tuvung', $object)){
				$return = $value["tuvung_name"];
			}
		}
		return $return;
	}

	/*

		Function _strtolower_all_tuvung_image
		Kiểm tra và update lại tuvung_image không viết hoa

	*/
	private function _strtolower_all_tuvung_image($value){
		if(preg_match("/([A-Z])/",$value["tuvung_image"])){
			$object = ["tuvung_image" => strtolower($value["tuvung_image"])];
			$this->db->where('id', $value["id"]);
			if($this->db->update('tuvung', $object)){
				$return[] = $value["tuvung_image"];
			}
		}
		return $return;
	}
}

/* End of file tuvung.php */
/* Location: ./application/models/tuvung.php */