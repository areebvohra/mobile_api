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
    // protected $table = 'ci_products';
    protected $table = 'products';

    function __construct()
    {
        parent::__construct();
    }

    function getProducts($category_id)
    {
        try {
            $this->db->select('id, name, sku, details, description, price, image_path');
            $this->db->from($this->table);
            if($category_id) { $this->db->where('product_category_id', $category_id); }

            $query = $this->db->get()->result();
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
            $query = $this->db->insert($this->table, $data);
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
            $query = $this->db->update($this->table, $data);
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
            $query = $this->db->get($this->table)->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
