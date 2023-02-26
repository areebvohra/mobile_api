<?php

/**
 * 
 * @author Ahsan Ali
 * @purpose Product crud opeariton
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Wishlist_model extends CI_Model
{
    protected $table = 'product_whislist';

    function __construct()
    {
        parent::__construct();
    }

    function getProductWishtlist()
    {
        try {
            $this->db->select('*');
            $query = $this->db->get($this->table)->result();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    function addProductInWishtlist($data)
    {
        try {
            $query = $this->db->insert($this->table, $data);
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function updateProductWishtlist($data)
    {
        try {
            $product_whislist = $this->getWhisListByProductID($data['product_id']);
            
            if($product_whislist) {
                $query = $this->db->update($this->table, $data);
            } else  {
                $query = $this->db->insert($this->table, $data);
            }
            
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function getWhisListByProductID($product_id) 
    {
        try {
            $this->db->where('product_id', $product_id);
            $query = $this->db->get($this->table)->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function getUniqueBuildingProduct($data) 
    {
        try {
            $this->db->where('building_id', $data['building_id']);
            $this->db->where('room_id', $data['room_id']);
            $this->db->where('product_id', $data['product_id']);
            $query = $this->db->get($this->table)->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
