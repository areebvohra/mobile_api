<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product Crud opearitons
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index_get($id)
    {
        $this->response(array('status' => 'success'));
    }

    /**
     * product list
     */
    public function list_get($category_id = false)
    {        
        $products = $this->Product_model->getProducts($category_id);
        
        $this->load->model('Product_Wishlist_model');
        for ($i=0; $i < count($products); $i++) {
            $is_in_wishlist = $this->Product_Wishlist_model->getWhisListByProductAndCategoryID($products[$i]->category_id, $products[$i]->id);
            $products[$i]->is_in_wishlist = $is_in_wishlist->is_in_wishlist == '1' ? 1 : 0;
        }
        
        $this->response(array('status' => 'success', 'data' => $products));
    }
    
    /**
     * create product
     */
    public function create_post() {

        // form validation
        $config = [
            array(
                'field' => 'category_id',
                'label' => 'Category ID',
                'rules' => 'trim|required|integer',
            ),
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'sku',
                'label' => 'sku',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'price',
                'label' => 'price',
                'rules' => 'trim|decimal'
            )
        ];
        
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors_array = validation_errors_to_array($config);
            $this->response(['status' => 'failed', 'validation_message' => $errors_array]);
        } else {
            $image_path = '';
            $result = $this->Product_model->createProduct($this->input->post());
            
            if($result) {
                $this->response(array('status' => 'success', 'message' => 'product created successfully'));
            } else {
                $this->response(array('status' => 'failed', 'message' => 'something went wrong'));
            }
        }
    }
}
