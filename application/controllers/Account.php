<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Account extends BASE_Controller
{
    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('Account_model');
    }

    public function index_get()
    {
        $this->response(array('status' => 'success'));
    }

    public function login_post()
    {
        // form validation
        $config = [
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
            ),
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors_array = validation_errors_to_array($config);
            $this->response(['status' => 'failed', 'validation_message' => $errors_array]);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $uresult = $this->Account_model->getUserAccount($username, $password);
            
            // $this->response(array('status' => 'success', 'data' => $uresult));
            
            if (!empty($uresult)) {
                /* $token = generateToken(['username' => $uresult->username, 'password' => $uresult->password, 'user_id' => $uresult->id]);
                $response = array(
                    'name' => $uresult->account_name,
                    "user_id" => $uresult->id
                ); */

                $token = generateToken(['username' => $uresult->name, 'password' => $uresult->password, 'user_id' => $uresult->zoho_id]);
                $response = array(
                    'name' => $uresult->name,
                    "user_id" => $uresult->zoho_id
                );
                
                $this->response(array('status' => 'success', 'message' => 'Login success', 'token' => $token, 'data' => $response));
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Invalid username or password.'));
            }
        }
    }
    
    /**
     * change password
     */
    public function changepassword_post() {
        // form validation
        $config = [
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'new_password',
                'label' => 'New password',
                'rules' => 'trim|required'
            )/* ,
            array(
                'field' => 'confirm_password',
                'label' => 'Confirm password',
                'rules' => 'trim|required|matches[new_password]'
            ), */
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors_array = validation_errors_to_array($config);
            $this->response(['status' => 'failed', 'validation_message' => $errors_array]);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $new_password = $this->input->post('new_password');
            $result = $this->Account_model->changePassword($email, $password, $new_password);
            
            if($result) {
                $this->response(array('status' => 'success', 'message' => 'password changed successfully'));
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Invalid email or password'));
            }
        }
    }  
}
