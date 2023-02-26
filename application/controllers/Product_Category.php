<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product Crud opearitons
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Product_Category extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_Category_model');
    }

    public function index_get()
    {
        $this->response(array('status' => 'success'));
    }

    /**
     * product list
     */
    public function list_get()
    {
        $data = $this->Product_Category_model->getProductCategory();
        $this->response(array('status' => 'success', 'data' => $data));
    }
}
