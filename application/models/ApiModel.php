<?php
class ApiModel extends CI_Model{

    public function authenticate() {
        $headers = $this->input->request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : 0;
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('accessToken', $authHeader);
        $this->db->where('expiresAt > NOW()');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return array("status"=>"success","data"=>"Authentication successful");
        }
        return array("status"=>"fail","data"=>"Authentication failed");
    }
    
    public function getAccessToken() {
        $headers = $this->input->request_headers();
        $email = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
        if($email != '' && $password != '') {
            $this->db->select('id');
            $this->db->from('user_details');
            $this->db->where('email', $email);
            $this->db->where('password', $password);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $id = $row['id'];
                $data['accessToken'] = sha1(rand());
                $data['expiresAt'] = date("Y-m-d H:i:s", strtotime('+1 day'));
                $this->db->where('id', $id);
                $this->db->update('user_details', $data);
                $response = array("status"=>"success","data"=>$data);
                return $response;
            }
        }
        $response = array("status"=>"fail","data"=>"Authentication failed");
        return $response;
    }
    
    public function addUser($isUpdate=false) {
        $this->load->model('UsersModel');
        $authenticate = $this ->authenticate();
        if($authenticate['status'] == "fail") {
            $response = $authenticate;
        } else {
            $currentDateTime = date("Y-m-d H:i:s");
            $data = json_decode(file_get_contents('php://input'), true);
            $checkMobile = $this->UsersModel->validate_mobile($data['phoneNumber']);
            if($checkMobile == false) {
                $response['status'] = false;
                $response['message'] = 'Error. Please enter valid mobile number';
                return $response;
            }
            $checkEmail = $this->UsersModel->validate_email($data['email']);
            if($checkEmail == false) {
                $response['status'] = false;
                $response['message'] = 'Error. Please enter valid email address';
                return $response;
            }
            if($isUpdate == true) {
                $email = $data['email'];
                $phoneNumber = $data['phoneNumber'];
                unset($data['email']);
                unset($data['phoneNumber']);
                if(isset($data['password'])) {
                    unset($data['password']);
                }
                $data['updatedAt'] = $currentDateTime;
                $this->db->where('email', $email);
                $this->db->where('phoneNumber', $phoneNumber);
                $this->db->update('user_details', $data);
                if($this->db->affected_rows()) {
                    $response = array("status"=>"success","data"=>"Successfully updated");
                } else {
                    $response = array("status"=>"fail","data"=>"No new changes to update");
                }
            } else {
                $data = json_decode(file_get_contents('php://input'), true);
                $email = isset($data['email']) ? $data['email'] : '';
                $phoneNumber = isset($data['phoneNumber']) ? $data['phoneNumber'] : '';
                $password = isset($data['password']) ? $data['password'] : '';
                if($email == '') {
                    $response['status'] = 'fail';
                    $response['data']= 'Email mandatory';
                } else if($phoneNumber == '') {
                    $response['status'] = 'fail';
                    $response['data']= 'PhoneNumber mandatory';
                } else if($password == '') {
                    $response['status'] = 'fail';
                    $response['data']= 'Password mandatory';
                } else {
                    $isExisting = $this->UsersModel->checkExistingUser($data);
                    if($isExisting == false) {
                        $data['createdAt'] = $currentDateTime;
                        $data['updatedAt'] = $currentDateTime;
                        $this->db->insert('user_details', $data);
                        $response = array("status"=>"success","data"=>"Successfully added");
                    } else {
                        $response = array("status"=>"fail","data"=>"Duplicate user email or phone number");
                    }
                }
            }
        }
        return $response;
    }
    
    public function listUsers() {
        $authenticate = $this ->authenticate();
        if($authenticate['status'] == "fail") {
            $response = $authenticate;
        } else {
            $response = array();
            $data = json_decode(file_get_contents('php://input'), true);
            $this->db->select('firstName,lastName,email,phoneNumber,roleType');
            $this->db->from('user_details');
            if(isset($data['roleType'])) {
                $this->db->where('roleType', $data['roleType']);
            } if(isset($data['fromDate'])) {
                $fromDate = isset($data['fromDate']) ? $data['fromDate'] : 0;
                $toDate = isset($data['toDate']) ? $data['toDate'] : 0;
                $this->db->where('(DATE_FORMAT(`createdAt`,"%Y-%m-%d") BETWEEN "'.$fromDate.'" AND "'.$toDate.'")');
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $response['status'] = 'success';
                $response['data'] = $query->result_array();
            } else {
                $response = array("status"=>"success","data"=>"No records found");
            }
        }
        return $response;
    }
    
    public function deleteUser() {
        $authenticate = $this ->authenticate();
        if($authenticate['status'] == "fail") {
            $response = $authenticate;
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
            $updateData = array("isActive"=>false);
            $this->db->where('email', $data['email']);
            $this->db->update('user_details', $updateData);
            if($this->db->affected_rows()) {
                $response = array("status"=>"success","data"=>"Successfully soft-deleted");
            } else {
                $response = array("status"=>"fail","data"=>"Please check input and retry");
            }
        }
        return $response;
    }
}
?>