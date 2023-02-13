<?php
defined('BASEPATH') or exit('No direct script access allowed');
class USER_Controller extends REST_Controller
{

    protected $user_data = array();
    protected $user_id = "";

    public function __construct()
    {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, Auth-Token, Device-Id");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        // header("Access-Control-Allow-Credentials: true");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $_POST = $this->post();
        $this->load->model('Account_model');
        $secret_data = tokenAuthentication();
        if (!empty($secret_data)) {
            $user = $this->Account_model->getUserAccountById($secret_data->user_id);
            if (empty($user)) {
                $this->response(array('status' => 'failed', 'message' => 'Authorization failed, Invalid credentials.'));
            }
            $this->user_data = $user;
            $this->user_id = $user->id;
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Invalid credentials.'));
        }
        $this->form_validation->set_error_delimiters('', '');
   }

    
}
