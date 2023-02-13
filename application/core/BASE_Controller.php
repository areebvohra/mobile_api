<?php
defined('BASEPATH') or exit('No direct script access allowed');
class BASE_Controller extends REST_Controller
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
        $this->form_validation->set_error_delimiters('', '');
    }
}
