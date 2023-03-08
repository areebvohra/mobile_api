<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product crud opeariton
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Category_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getProductCategory()
    {
        try {
            $this->db->select('*');
            $query = $this->db->get('ci_product_category')->result();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    function getProductCategoryByID()
    {
        try {
            $this->db->select('*');
            $query = $this->db->get('ci_product_category')->result();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}