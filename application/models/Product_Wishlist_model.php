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
            $data['is_in_wishlist'] = 1;
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
        try {
            $is_in_wishlist = ($data['is_in_wishlist'] == 1) ? 0 : 1;
            $this->db->where('building_id', $data['building_id']);
            $this->db->where('room_id', $data['room_id']);
            $this->db->where('product_category_id', $data['product_category_id']);
            $this->db->where('product_id', $data['product_id']);
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

    function getWhisListByProductAndCategoryID($category_id, $product_id) 
    {
        try {
            $this->db->where('product_category_id', $category_id);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get($this->table)->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function getProductByFilteration($filter) 
    {
        try {
            $select = 'products.*, product_wishlist.*';
            if($filter['building_id']) $this->db->where('building_id', $filter['building_id']);
            
            if($filter['room_id']) {
                $select .= ', zoho_rooms.name as room_name';                
                $this->db->where('room_id', $filter['room_id']);
                $this->db->join('zoho_rooms', 'zoho_rooms.id = product_wishlist.room_id');
            }
            
            if($filter['product_category_id']) {
                $this->db->where('product_category_id', $filter['product_category_id']);
            }

            if(!$filter['product_category_id']) $this->db->where('is_in_wishlist', 1);

            $this->db->select($select);
            $this->db->join('products', 'products.id = product_wishlist.product_id');

            return $this->db->get($this->table)->result();            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get produc by building, room and product
     */
    function getProductByBRCP($data)
    {
        try {
            $this->db->where('building_id', $data['building_id']);
            $this->db->where('room_id', $data['room_id']);
            $this->db->where('product_category_id', $data['product_category_id']);
            $this->db->where('product_id', $data['product_id']);
            $query = $this->db->get($this->table)->row();
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * reset is_in_wishlist by building room and category
     * @param $data Array
     */
    function resetWishlistByBRC($data)
    {
        try {
            $this->db->where('building_id', $data['building_id']);
            $this->db->where('room_id', $data['room_id']);
            $this->db->where('product_category_id', $data['product_category_id']);
            $query = $this->db->update($this->table, ['is_in_wishlist' => 0]);

            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
