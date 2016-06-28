<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionItem_Model extends CI_Model {

	public $id;
	public $text; //O que está escrito no item
	public $question_id; //Id da questão a qual este item pertence
	public $order; //Ordem deste item na questão
	public $child_question_id; //Id da "questão filha"
	/*
	* "Questão filha" é uma questão condicional que só é exibida caso o
	* usuário escolha este item
	*/

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('question_item');
		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function getByQuestionId($id) {
		$this->db->where('question_id', $id);
		$query = $this->db->get('question_item');
		if (count($query->result()) > 0) {
			return $query->result();
		}
		return NULL;
	}

	function getChildQuestionByQuestionItemId($id) {
		$question_item = $this->getById($id);

		$this->db->where('id', $question_item['child_question_id']);
		$query = $this->db->get('question');
		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function getAll(){
		$query = $this->db->get('question_item');
		if(!empty($query)){
			return $query->result();
		}
		return NULL;
	}

	function deleteById($id){
		$user = $this->getById($id);
		$this->db->where('id',$id);
		$query = $this->db->delete('question_item');
		return $user;
	}

	function insert($data){
		$this->db->insert('question_item',$data);
	}

	function updateById($id,$data){
		$this->db->where('id',$id);
		$this->db->update('question_item',$data);
		return $this->getById($id);
	}
}
