<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata("logged_in")) {
            redirect("index");
        }
    }

    public function index() {
        $data = array();
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('cpf', 'CPF', 'trim|required');
            $this->form_validation->set_rules('senha', 'SENHA', 'required');
            $this->form_validation->set_message('required', 'O campo %s é obrigatório');

            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $this->load->model("User_model", "user");
                $user = $this->user->getByCpfAndPassword($this->input->post("cpf"), $this->input->post("senha"));
                if (empty($user)) {
                    $data["status"] = FALSE;
                } else {
                    $data["status"] = TRUE;
                    $this->session->set_userdata("logged_in", $user);
                    redirect("index");
                    
                }
            }
        }

        $this->load->view("login", $data);
    }

}
