<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_Model extends CI_Model {

	public $id;
	public $user_id;
	public $form_id;
	public $date;
	public $location_id = 1; //para teste é sempre 1

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('survey');

		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function insert($data){
		$this->db->insert('survey',$data);
	}
}
