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
    protected $table = 'product_wishlist';

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

    function updateProductWishtlist($filter)
    {
        try {
            $product_wishlist = $this->getWhisListByProductID($data['product_id']);
            
            if($product_wishlist) {
                $query = $this->db->update($this->table, $data);
            } else  {
                $query = $this->db->insert($this->table, $data);
            }
            
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function toggleIsInWishList($data)
    {
        $is_in_wishlist = ($data->is_in_wishlist == 1) ? 0 : 1;
        try {            
            $this->db->where('id', $data->id);
            $query = $this->db->update($this->table, ['is_in_wishlist' => $is_in_wishlist]);

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
            if($data['building_id']) $this->db->where('building_id', $data['building_id']);
            if($data['room_id']) $this->db->where('room_id', $data['room_id']);
            if($data['product_id']) $this->db->where('product_id', $data['product_id']);
            $query = $this->db->get($this->table)->result();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }  
}
