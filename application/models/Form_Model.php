<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_Model extends CI_Model {

	public $id;
	public $name;
	public $created_at; //Data de criação
	public $user_id_creator; //Id do usuário que criou o formulário
	public $form_group_id; //Grupo ao qual este formulário pertence

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('form');

		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function getByFormGroupId($id) {
		$this->db->where('form_group_id', $id);
		$query = $this->db->get('form');

		if (count($query->result()) > 0) {
			return $query->result();
		}
		return NULL;
	}

	function getAll(){
		$query = $this->db->get('form');

		if(!empty($query)){
			return $query->result();
		}

		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);

		$this->db->where('id',$id);
		$query = $this->db->delete('form');

		return $user;
	}

	function insert($data){
		$this->db->insert('form',$data);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('form',$data);

		return $this->getById($id);
	}
}
