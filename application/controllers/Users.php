<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    public function __construct()
    {
       parent::__construct(); 
       $this->load->model('UsersModel');         
    }

   public function index()
   {
       $this->load->view('includes/header');       
       $this->load->view('users/index');
       $this->load->view('includes/footer');
   }

   public function add()
   {    
        $data['roles'] = $this->UsersModel->getRoles();
        if(isset($_POST) && !empty($_POST)) {
            $add = $this->UsersModel->addUser();
            if($add['status'] == true) {
                redirect(base_url('users'));
            } else {
                $data['message'] = '<div class="alert alert-danger" role="alert">'. $add['message'] . '</div>';
                $this->load->view('includes/header');
                $this->load->view('users/add', $data);
                $this->load->view('includes/footer');
            }
        } else {
            $this->load->view('includes/header');
            $this->load->view('users/add', $data);
            $this->load->view('includes/footer');  
        }
   }

   public function edit($id)
   {
        if(isset($_POST) && !empty($_POST)) {
            $this->UsersModel->addUser($id);
            redirect(base_url('users'));
        } else {
            $data['roles'] = $this->UsersModel->getRoles();
            $data['user'] = $this->db->get_where('user_details', array('id' => $id))->row_array();
            $this->load->view('includes/header');
            $this->load->view('users/edit',$data);
            $this->load->view('includes/footer');   
        }
   }

   public function delete($id)
   {
       $this->UsersModel->deleteUser($id);
       redirect(base_url('users'));
   }

   public function filter(){
       $data['data'] = $this->UsersModel->filter();
       $this->load->view('includes/header');
       $this->load->view('users/filter', $data);
       $this->load->view('includes/footer');
   }
}