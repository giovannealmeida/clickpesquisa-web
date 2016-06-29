<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

	public $id;
	public $first_name;
	public $last_name;
	public $cpf;
	public $username;
	public $password;
	public $email;
	public $photo_id;
	public $role_id; //Id da função do usuário
	public $status; //Ativo ou inativo
	public $reg_time; //Data do registro do usuário

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		if (count($query->result()) == 1) {
			$result = $query->row_array();
			return $result;
		}
		return NULL;
	}

	function getByRoleId($id) {
		$this->db->where('role_id', $id);
		$query = $this->db->get('user');
		if (count($query->result()) > 0) {
			return $query->result();
		}
		return NULL;
	}

	function getByUsernameAndPassword($username,$password) {
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('user');
		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}
	
        function getByCpfAndPassword($cpf,$password) {
		$this->db->where('cpf', $cpf);
		$this->db->where('password', $password);
		$query = $this->db->get('user');
		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function getAll(){
		$query = $this->db->get('user');
		if(!empty($query)){
			return $query->result();
		}
		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);
		$this->db->where('id',$id);
		$query = $this->db->delete('user');
		return $user;
	}

	function insert($user){
		$this->db->insert('user',$user);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('user',$data);
		return $this->getById($id);
	}
}
