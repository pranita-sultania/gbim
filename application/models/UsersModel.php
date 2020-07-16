<?php
class UsersModel extends CI_Model{

    public function validate_mobile($mobile) {
        return preg_match('/^[0-9]{10}+$/', $mobile);
    }
    
    public function validate_email($email) {
        return preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email);
    }

    public function addUser($id=null) {
        $response['status'] = true;
        $response['message'] = 'Success';
        $data = array(
            'firstName' => $this->input->post('firstName'),
            'lastName' => $this->input->post('lastName'),
            'email' => $this->input->post('email'),
            'phoneNumber' => $this->input->post('phoneNumber'),
            'roleType' => $this->input->post('roleType'),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $checkMobile = $this->validate_mobile($data['phoneNumber']);
        $checkEmail = $this->validate_email($data['email']);
        if($checkMobile == false) {
            $response['status'] = false;
            $response['message'] = 'Please enter valid mobile number';
        } else if($checkEmail == false) {
            $response['status'] = false;
            $response['message'] = 'Please enter valid email address';
        } else {
            $isExisting = $this -> checkExistingUser($data);
            if($isExisting == false) {
                $data['createdAt'] = date('Y-m-d H:i:s');
                $data['password'] = $this->input->post('password');
                $this->db->insert('user_details', $data);
            } else {
                if($id != null) {
                    unset($data['email']);
                    unset($data['phoneNumber']);
                    $this->db->where('id', $id);
                    $this->db->update('user_details', $data);
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Duplicate user email or phone number';
                }
            }
        }

        return $response;
    }
    
    public function deleteUser($id) {
        $data['isActive'] = false;
        $this->db->where('id', $id);
        $this->db->update('user_details', $data);
    }

    public function checkExistingUser($data) {
        $this->db->select('id');
        $this->db->from('user_details');
        $this->db->where('email', $data['email']);
        $this->db->or_where('phoneNumber', $data['phoneNumber']);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $id = $query->row()->id;
        } else {
            $id = false;
        }
        return $id;
    }

    public function getRoles() {
        $this->db->select('*');
        $this->db->from('roles');
        $query = $this->db->get();
        $row = array();
        if ($query->result_array() > 0)
        {
            $row = $query->result_array();
        }
        return $row;
    }

    public function filter() {
        if(isset($_POST) && !empty($_POST)) {
            $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
            $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
            $roleType = isset($_POST['roleType']) ? $_POST['roleType'] : '';
            
            $this->db->select('*');
            $this->db->from('user_details');
            if($firstName != '') {
                $this->db->like('firstName', $firstName);
            } if($lastName != '') {
                $this->db->like('lastName', $lastName);
            } if($email != '') {
                $this->db->like('email', $email);
            } if($phoneNumber != '') {
                $this->db->like('phoneNumber', $phoneNumber);
            } if($roleType != '') {
                $this->db->like('roleType', $roleType);
            }
            $query = $this->db->get();
            $row = array();
            if ($query->result_array() > 0)
            {
                $row = $query->result_array();
            }
        } else {
            $this->db->select('*');
            $this->db->from('user_details');
            $query = $this->db->get();
            $row = array();
            if ($query->result_array() > 0)
            {
                $row = $query->result_array();
            }
        }
        return $row;
    }
}
?>