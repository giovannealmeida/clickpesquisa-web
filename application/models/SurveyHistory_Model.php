<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SurveyHistory_Model extends CI_Model {

	public $id;
	public $survey_id;
	public $question_id;
	public $item_id;
	public $response_text;

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('survey_history');

		if (count($query->result()) == 1) {
			return $query->row_array();
		}
		return NULL;
	}

	function insert($data){
		$this->db->insert('survey_history',$data);
	}
}
