<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product Crud opearitons
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Product_Wishlist extends BASE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_Wishlist_model');
    }

    public function index_get()
    {
        $this->response(array('status' => 'success'));
    }

    /**
     * product wishlist list
     */
    public function list_get()
    {
        $data = $this->Product_Wishlist_model->getProductWishtlist();
        $this->response(array('status' => 'success', 'data' => $data));
    }

    /**
     * create product wishlist
     */
    public function create_post()
    {
        // form validation
        $config = [
            array(
                'field' => 'building_id',
                'label' => 'Building ID',
                'rules' => 'trim|required|integer',
            ),
            array(
                'field' => 'room_id',
                'label' => 'Room ID',
                'rules' => 'trim|required|integer'
            ),
            array(
                'field' => 'product_id',
                'label' => 'product_id',
                'rules' => 'trim|required|integer'
            ),
            array(
                'field' => 'quantity',
                'label' => 'Quantity',
                'rules' => 'trim|required|integer'
            )
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors_array = validation_errors_to_array($config);
            $this->response(['status' => 'failed', 'validation_message' => $errors_array]);
        } else {
            
            $this->load->model('Product_model');
            $product = $this->Product_model->getProductByID($this->input->post('product_id'));
            
            if($product) {
                $data = $this->input->post();
                $data['unit_price'] = $product->price;
                $data['total_price'] = $product->price * $this->input->post('quantity');
                
                // $result = $this->Product_Wishlist_model->updateProductWishtlist($data);
                $result = $this->Product_Wishlist_model->getUniqueBuildingProduct($data);
                
                if($result) {
                    $this->response(array('status' => 'success', 'message' => 'product already added'));
                } 
                
                $this->Product_Wishlist_model->addProductInWishtlist($data);
                $this->response(array('status' => 'success', 'message' => 'product added successfully'));
            } else {
                $this->response(array('status' => 'failed', 'message' => 'invalid Product ID'));
            }                        
        }                
    }
}
