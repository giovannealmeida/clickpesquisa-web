<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
        
    public function __construct(){
        parent::__construct();  
    }  
    
	
    public function index()
    {
        if (!$this->session->userdata("logged_in")){
            redirect('login');
        }
        
        $this->load->view("paginaInicial");

    }
}
