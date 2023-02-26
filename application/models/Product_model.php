<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product crud opeariton
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model
{
    protected $table = 'product';

    function __construct()
    {
        parent::__construct();
    }

    function getProducts($category_id)
    {
        try {
            $this->db->select('*');

            if($category_id) { $this->db->where('category_id', $category_id); }
            
            $query = $this->db->get('products')->result();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * create product
     * @param $data
     */
    function createProduct($data) {
        try {
            $query = $this->db->insert('products', $data);
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * update product
     * @param $data
     */
    function updateProduct($data) {
        try {
            $query = $this->db->update('products', $data);
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get product by ID
     * @param $id
     */
    function getProductByID($id) {
        try {
            $this->db->where('id', $id);
            $query = $this->db->get('products')->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
