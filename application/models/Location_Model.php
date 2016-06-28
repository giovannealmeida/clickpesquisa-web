<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_Model extends CI_Model {

	public $id;
	public $lat;
	public $long;
	public $neighborhood;
	public $number;
	public $address;
	public $cep;
	public $city;

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('location');
		if (count($query->result()) == 1) {
			$result = $query->row_array();
			return $result;
		}
		return NULL;
	}

	function getAll(){
		$query = $this->db->get('location');
		if(!empty($query)){
			return $query->result();
		}
		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);
		$this->db->where('id',$id);
		$query = $this->db->delete('location');
		return $user;
	}

	function insert($data){
		$this->db->insert('location',$data);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('location',$data);
		return $this->getById($id);
	}
}
