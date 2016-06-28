<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/*
* A URL para acesso à API é no formato:
*
* http://<dominio>/clickpesquisa/api/rest/<recurso>/<nome-param>/<valor-param>
*
* onde <recurso> é o objeto que será operado.
* Esta API é compatível com os protocolos HTTP:
* GET    - Para consulta de dados
* POST   - Para inserção de dados
* PUT    - Para atualização de dados
* DELETE - Para remoção de dados
*
* Exemplos:
* Para consulta de todos os usuários é:
* [GET]
* http://<dominio>/clickpesquisa/api/rest/users/
*
* Para consultar somente o usuário de id 1:
* [GET]
* http://<dominio>/clickpesquisa/api/rest/users/id/1
*
* Para consultar usuários operadores (role_id = 1):
* [GET]
* http://<dominio>/clickpesquisa/api/rest/users/role_id/1
*
* Para inserir um usuário é preciso uma requisição POST com os parâmetros sendo
* passados no corpo da requisição. Para uma inserção é preciso passar todos os
* dados obrigatórios:
* [POST]
* http://<dominio>/clickpesquisa/api/rest/users
* [Body]
* first-name: Carlos
* last-name: Alberto
* username: calberto
* password: 81dc9bdb52d04dc20036dbd8313ed055
* email: alberto@gmail.com
* photo: NULL
* role_id: 1
* status: 1
*
* Para editar um usuário é preciso uma requisição PUT com os parâmetros
* sendo passados no corpo da requisição. Para fazer um update é preciso passar
* o id do usuário que se quer editar e os parâmetros que serão alterados com os
* seus valores:
* [PUT]
* http://<dominio>/clickpesquisa/api/rest/users
* [Body]
* id:2
* first-name:Carlos
*
* Para remover um usuário é preciso uma requisição DELETE com os parâmetros
* sendo passados no corpo da requisição. Para deletar um usuário basta passar
* o id:
* [DELETE]
* http://<dominio>/clickpesquisa/api/rest/users
* [Body]
* id:2
*/

class Rest extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
    * USER RESOURCE
    */
    public function users_get() {
        $this->load->model('User_Model','User');
        $id = $this->get('id');
        $role_id = $this->get('role_id');

        if ($id === NULL && $role_id === NULL) {
            $users = $this->User->getAll();
            if ($users) {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        if($id !== NULL){
            $id = (int) $id;
            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
            $user = $this->User->getById($id);
            if (!empty($user)) {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } elseif ($role_id !== NULL) {
            $role_id = (int) $role_id;
            if ($role_id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
            $user = $this->User->getByRoleId($role_id);
            if (!empty($user)) {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function users_post() {
        $this->load->model('User_Model','User');
        $user = array(
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'email' => $this->post('email'),
            'role_id' => $this->post('role_id'),
            'status' => $this->post('status'),
        );
        if(!empty($this->post('photo_id'))){
            $user['photo_id'] => $this->post('photo_id'),
        }
        $this->User->insert($user);
        $message = ['message' => $user['first_name'].' added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function users_put() {
        $this->load->model('User_Model','User');
        $id = (int) $this->put('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array();
        if(!empty($this->put('first_name'))){
            $data['first_name'] = $this->put('first_name');
        }
        if(!empty($this->put('last_name'))){
            $data['last_name'] = $this->put('last_name');
        }
        if(!empty($this->put('username'))){
            $data['username'] = $this->put('username');
        }
        if(!empty($this->put('password'))){
            $data['password'] = $this->put('password');
        }
        if(!empty($this->put('email'))){
            $data['email'] = $this->put('email');
        }
        if(!empty($this->put('role_id'))){
            $data['role_id'] = $this->put('role_id');
        }
        if(!empty($this->put('photo_id'))){
            $data['photo_id'] = $this->put('photo_id');
        }
        if(!empty($this->put('status'))){
            $data['status'] = $this->put('status');
        }

        $user = $this->User->updateById($id,$data);

        $message = [
            'id' => $id,
            'message' => $user['first_name'].' updated'
        ];

        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    function users_delete() {
        $this->load->model('User_Model','User');
        $id = (int) $this->delete('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $user = $this->User->deleteById($id);

        $message = [
            'id' => $id,
            'message' => $user['first_name'].' deleted'
        ];

        $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }

    /*
    * FORM GROUP RESOURCE
    */
    function formgroups_get() {
        $this->load->model('Formgroup_Model','FGroup');
        $id = $this->get('id');
        if ($id === NULL) {
            $groups = $this->FGroup->getAll();
            if ($groups) {
                $this->response($groups, REST_Controller::HTTP_OK);
            }
            else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No groups were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        $id = (int) $id;
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        $group = $this->FGroup->getById($id);
        if (!empty($group)) {
            $this->set_response($group, REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Group could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function formgroups_post() {
        $this->load->model('Formgroup_Model','FGroup');
        $group = array(
            'name' => $this->post('name'),
        );
        $this->FGroup->insert($group);
        $message = ['message' => $group['name'].' added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    function formgroups_put() {
        $this->load->model('Formgroup_Model','FGroup');
        $id = (int) $this->put('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array();
        if(!empty($this->put('name'))){
            $data['name'] = $this->put('name');
        }

        $group = $this->FGroup->updateById($id,$data);

        $message = [
            'id' => $id,
            'message' => $group['name'].' updated'
        ];

        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /*
    * Todo e qualquer formulário no grupo deletado será removido em cascata.
    * TODO: Notificar o usuário e perguntra se ele tem certeza da operação.
    */
    function formgroups_delete() {
        $this->load->model('FormGroup_Model','FGroup');
        $id = (int) $this->delete('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        $group = $this->FGroup->deleteById($id);

        $message = [
            'id' => $id,
            'message' => $group['name'].' deleted'
        ];

        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /* FORM RESOURCE */
    function forms_get() {
        $this->load->model('Form_Model','Form');
        $id = $this->get('id');
        $form_group_id = $this->get('form_group_id');
        if ($id === NULL && $form_group_id === NULL) {
            $forms = $this->Form->getAll();
            if ($forms) {
                $this->response($forms, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No forms were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        if($id !== NULL){
            $id = (int) $id;
            if ($id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $form = $this->Form->getById($id);
            if (!empty($form)) {
                $this->set_response($form, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Form could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } elseif ($form_group_id !== NULL){
            $form_group_id = (int) $form_group_id;
            if ($form_group_id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $forms = $this->Form->getById($form_group_id);
            if (!empty($forms)) {
                $this->set_response($forms, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Forms could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    function forms_post() {
        $this->load->model('Form_Model','Form');
        $form = array(
            'name' => $this->post('name'),
            'user_id_creator' => $this->post('user_id_creator'),
            'form_group_id' => $this->post('form_group_id')
        );
        $this->Form->insert($form);
        $message = ['message' => $form['name'].' added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    function forms_put() {
        $this->load->model('Form_Model','Form');
        $id = (int) $this->put('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array();
        if(!empty($this->put('name'))){
            $data['name'] = $this->put('name');
        }
        if(!empty($this->put('user_id_creator'))){
            $data['user_id_creator'] = $this->put('user_id_creator');
        }
        if(!empty($this->put('form_group_id'))){
            $data['form_group_id'] = $this->put('form_group_id');
        }

        $form = $this->Form->updateById($id,$data);

        $message = [
            'id' => $id,
            'message' => $form['name'].' updated'
        ];

        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /*
    * Todas as questões no formulário deletado serão removidas em cascata.
    * TODO: Notificar o usuário e perguntar se ele tem certeza da operação.
    */
    function forms_delete() {
        $this->load->model('Form_Model','Form');
        $id = (int) $this->delete('id');
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        $form = $this->Form->deleteById($id);
        $message = [
            'id' => $id,
            'message' => $form['name'].' deleted'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /* QUESTION RESOURCE */
    function questions_get(){
        $this->load->model('Question_Model','Question');
        $id = $this->get('id');
        $form_id = $this->get('form_id');

        if ($id === NULL && $form_id === NULL) {
            $questions = $this->Question->getAll();
            if ($questions) {
                $this->response($questions, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No questions were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        if($id !== NULL) {
            $id = (int) $id;
            if ($id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $question = $this->Question->getById($id);
            if (!empty($question)) {
                $this->set_response($question, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Question could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } elseif ($form_id !== NULL){
            $form_id = (int) $form_id;
            if ($form_id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $questions = $this->Question->getByFormId($form_id);
            if (!empty($questions)) {
                $this->set_response($questions, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Questions could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    function questions_post() {
        $this->load->model('Question_Model','Question');
        $question = array(
            'order' => $this->post('order'),
            'text' => $this->post('text'),
            'form_id' => $this->post('form_id'),
            'question_type_id' => $this->post('question_type_id'),
            'num_options' => $this->post('num_options'),
            'comment' => $this->post('comment')
        );
        $this->Question->insert($question);
        $message = ['message' => $question['name'].' added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    function questions_put() {
        $this->load->model('Question_Model','Question');
        $id = (int) $this->put('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array();
        if(!empty($this->put('order'))){
            $data['order'] = $this->put('order');
        }
        if(!empty($this->put('text'))){
            $data['text'] = $this->put('text');
        }
        if(!empty($this->put('form_id'))){
            $data['form_id'] = $this->put('form_id');
        }
        if(!empty($this->put('question_type_id'))){
            $data['question_type_id'] = $this->put('question_type_id');
        }
        if(!empty($this->put('num_options'))){
            $data['num_options'] = $this->put('num_options');
        }
        if(!empty($this->put('comment'))){
            $data['comment'] = $this->put('comment');
        }
        $question = $this->Question->updateById($id,$data);
        $message = [
            'id' => $id,
            'message' => 'Question updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /*
    * Todos os itens de questões na questão deletada serão removidos em cascata.
    * TODO: Notificar o usuário e perguntar se ele tem certeza da operação.
    */
    function questions_delete() {
        $this->load->model('Question_Model','Question');
        $id = (int) $this->delete('id');
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        $question = $this->Question->deleteById($id);
        $message = [
            'id' => $id,
            'message' => 'Question deleted'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /* QUESTION ITEM RESOURCE */
    function questionitems_get(){
        $this->load->model('QuestionItem_Model','QItem');
        $id = $this->get('id');
        $question_id = $this->get('question_id');

        if ($id === NULL && $question_id === NULL) {
            $questionitems = $this->QItem->getAll();
            if ($questionitems) {
                $this->response($questionitems, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No questionitems were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        if($id !== NULL) { //Se o id não estiver vazio, procura o itme por id
            $id = (int) $id;
            if ($id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $questionitem = $this->QItem->getById($id);
            if (!empty($questionitem)) {
                $this->set_response($questionitem, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Question item could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } elseif ($question_id !== NULL) { //Se o question_id não estiver vazio, procura o itme por id da questão
            $question_id = (int) $question_id;
            if ($question_id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $questionitem = $this->QItem->getByQuestionId($question_id);
            if (!empty($questionitem)) {
                $this->set_response($questionitem, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Question item could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    /*
    * TODO: Permitir que cada item tenha mais de uma questão filha
    */
    function childquestions_get(){
        $this->load->model('QuestionItem_Model','QItem');
        //O parâmetro passado é o id do item cujo se quer saber quem são as questões filhas
        $id = $this->get('child_question_id');

        if($id !== NULL) { //Se o id não estiver vazio, procura a questão filha por esse id
            $id = (int) $id;
            if ($id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }
            $child_question = $this->QItem->getChildQuestionByQuestionItemId($id);
            if (!empty($child_question)) {
                $this->set_response($child_question, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Child question for question id \''.$id.'\'could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function questionitems_post() {
        $this->load->model('QuestionItem_Model','QItem');
        $questionitem = array(
            'order' => $this->post('order'),
            'text' => $this->post('text'),
            'form_id' => $this->post('form_id'),
            'question_type_id' => $this->post('question_type_id'),
            'num_options' => $this->post('num_options'),
            'comment' => $this->post('comment')
        );
        $this->QItem->insert($questionitem);
        $message = ['message' => $questionitem['name'].' added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    function questionitems_put() {
        $this->load->model('QuestionItem_Model','QItem');
        $id = (int) $this->put('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array();
        if(!empty($this->put('order'))){
            $data['order'] = $this->put('order');
        }
        if(!empty($this->put('text'))){
            $data['text'] = $this->put('text');
        }
        if(!empty($this->put('form_id'))){
            $data['form_id'] = $this->put('form_id');
        }
        if(!empty($this->put('question_type_id'))){
            $data['question_type_id'] = $this->put('question_type_id');
        }
        if(!empty($this->put('num_options'))){
            $data['num_options'] = $this->put('num_options');
        }
        if(!empty($this->put('comment'))){
            $data['comment'] = $this->put('comment');
        }
        $questionitem = $this->QItem->updateById($id,$data);
        $message = [
            'id' => $id,
            'message' => 'Question item updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /*
    * Todos as questões filhas do item de questão deletado serão removidas em cascata.
    * TODO: Notificar o usuário e perguntar se ele tem certeza da operação.
    */
    function questionitems_delete() {
        $this->load->model('QuestionItem_Model','QItem');
        $id = (int) $this->delete('id');
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        $questionitem = $this->QItem->deleteById($id);
        $message = [
            'id' => $id,
            'message' => 'Question item deleted'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    /* LOCATION RESOURCE */
    /*
    * O usuário escolhe se quer cadastrar o local onde realizou uma pesquisa
    * utilizando latitude e longitudo (gerados automaticamente pelo app) ou
    * pelo endereço físico (bairro, rua, cep, etc.)
    */
    function locationcoords_post() {
        $this->load->model('Location_Model','Location');
        $location = array(
            'lat' => $this->post('lat'),
            'long' => $this->post('long'),
            'city' => $this->post('city')
        );
        $this->Location->insert($location);
        $message = ['message' => 'Location added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    function locationaddress_post() {
        $this->load->model('Location_Model','Location');
        $location = array(
            'lat' => $this->post('lat'),
            'long' => $this->post('long'),
            'city' => $this->post('city')
        );
        $this->Location->insert($location);
        $message = ['message' => 'Location added'];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }
}
