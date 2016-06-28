<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormGroup_Model extends CI_Model {

    public $id;
    public $name;
    
	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('form_group');

		if (count($query->result()) == 1) {
			$result = $query->row_array();

			return $result;
		}

		return NULL;
	}

	function getAll(){
		$query = $this->db->get('form_group');

		if(!empty($query)){
			return $query->result();
		}

		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);

		$this->db->where('id',$id);
		$query = $this->db->delete('form_group');

		return $user;
	}

	function insert($data){
		$this->db->insert('form_group',$data);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('form_group',$data);

		return $this->getById($id);
	}
}
