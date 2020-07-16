<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    public function __construct()
    {
       parent::__construct(); 
       $this->load->model('UsersModel');
       $this->load->model('ApiModel');
    }
    
    public function token() {
        $response = $this->ApiModel->getAccessToken();
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));
    }
    
    public function add() {
        $response = $this->ApiModel->addUser();
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));
    }
    
    public function update() {
        $isUpdate = true;
        $response = $this->ApiModel->addUser($isUpdate);
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));
    }
    
    public function listUsers() {
        $response = $this->ApiModel->listUsers();
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));
    }
    
    public function delete() {
        $response = $this->ApiModel->deleteUser();
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($response));
    }
}