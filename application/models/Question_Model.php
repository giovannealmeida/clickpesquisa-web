<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_Model extends CI_Model {

	public $id;
	public $order;
	public $text;
	public $form_id;
	public $question_type_id;
	public $num_options;
	public $comment;

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('question');
		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function getByFormId($id) {
		$this->db->where('form_id', $id);
		$query = $this->db->get('question');
		if (count($query->result()) > 0) {
			return $query->result();
		}
		return NULL;
	}

	function getAll(){
		$query = $this->db->get('question');
		if(!empty($query))
			return $query->result();
		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);
		$this->db->where('id',$id);
		$query = $this->db->delete('question');
		return $user;
	}

	function insert($data){
		$this->db->insert('question',$data);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('question',$data);
		return $this->getById($id);
	}
}
