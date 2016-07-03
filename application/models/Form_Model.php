<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_Model extends CI_Model {

	/*
		TODO: Quando a restrição de permissão por grupo for implementada, alterar
		todas funções para que recebam por parâmetro o id do usuário que está
		pedindo (com exceção de getAll())
	*/
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

	function getByCreatedAfter($time) {
		$this->db->where('(UNIX_TIMESTAMP(last_updated_at)*1000) >', $time);
		$this->db->order_by('last_updated_at', 'DESC');
		$query = $this->db->get('form');

		if (count($query->result()) > 0) {
			return $query->result();
		}
		return NULL;
	}

	function getAllComplete($last_update_time=0){
		$result = NULL;

		$this->load->model('Question_Model','Q');
		//$forms possui todos os formulários cadastrados (com ou sem questões)
		$forms = $this->getByCreatedAfter($last_update_time);

		/* BUSCANDO QUESTÕES DO FORMULÁRIO */
		if(count($forms) > 0){
			foreach ($forms as $key => $value) {
				//$questions possui as questões do formulário id=$value->id
				$questions = $this->Q->getByFormId($value->id);
				//Verifica se a consulta retornou alguma questão no form atual
				if(count($questions)>0){
					//Se retornou alguma questão, existe form não vazio
					$emptyForms = FALSE;
					$forms[$key]->questions = $questions;
					//$forms_validos possui somente formulários com questões
					$forms_validos[$key] = $forms[$key];
				}
			}

			/* BUSCANDO ITENS DAS QUESTÕES ENCONTRADAS */
			$this->load->model('QuestionItem_Model','QI');

			//Itera entre os forms
			foreach ($forms_validos as $idx => $form) {
				//Itera entre as questões dos forms
				foreach ($form->questions as $key => $question) {
					//Retornas os itens da questão atual
					$items = $this->QI->getByQuestionId($question->id);
					if(count($items)>0){
						$forms_validos[$idx]->questions[$key]->items = $items;
						$result[$idx] = $forms_validos[$idx];
					}
				}
			}

			$result = array_values($result);
			return $result;
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
