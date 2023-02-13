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

            if (!empty($uresult)) {
                $token = generateToken(['username' => $uresult->username,'password' => $uresult->password, 'user_id' => $uresult->id]);
                $response = array(
                    'name' => $uresult->account_name,
                    "user_id" => $uresult->id
                );
                $this->response(array('status' => 'success', 'message' => 'Login success', 'token' => $token, 'data' => $response));
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Invalid username or password.'));
            }
        }
    }
}
