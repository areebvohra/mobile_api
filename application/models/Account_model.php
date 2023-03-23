<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_model extends CI_Model
{

    function __construct()
    {

        parent::__construct();
    }

    function getUserAccount($username, $password)
    {
        try {
            // $this->load->library('password');
            

            $this->db->select('*');
            $this->db->from('user_auth');
            // $this->db->where('name', $username);
            $this->db->where('username', $username);
            // $this->db->where('password', md5($password));
            $query = $this->db->get()->row();            
            
            if($query && password_verify($password, $query->password)) {
                return $query; 
            } else {
                return false;
            }

            /* $this->db->select('zoho_accounts.id, zoho_accounts.account_name, zoho_contacts.zportal1_username as username, zoho_contacts.setuppw as password');
            $this->db->from('zoho_accounts');
            $this->db->join("zoho_contacts", "zoho_contacts.account_number=zoho_accounts.id");
            $this->db->where('setuppw', $password);
            $this->db->where("zportal1_username", $username);
            $query = $this->db->get()->row();
            return $query; */

            $this->db->select('zoho_contacts.zportal1_username as username, zoho_contacts.setuppw as password');
            $this->db->from('zoho_contacts');
            // $this->db->join("zoho_contacts", "zoho_contacts.account_number=zoho_accounts.id");
            $this->db->where('setuppw', $password);
            $this->db->where("zportal1_username", $username);
            $query = $this->db->get()->row();
            return $query;
        } catch (Exception $th) {
            throw $th->getMessage();
        }
    }

    /**
     * change password
     * @param {string} $email
     * @param {string} $password
     * @param {string} $new_password
     * @return mixed|boolean
     */
    function changePassword($email, $password, $new_password)
    {
        try {
            $is_valid_user = $this->isValidUser($email, $password);
            
            if($is_valid_user) {
                $this->db->update('user_auth', ['password' => md5($new_password)], 'user_id=' . $is_valid_user->user_id);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * user validaton from DB
     * @param {string} $email
     * @param {string} $password
     * @return boolean
     */
    private function isValidUser($email, $password) {
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $query = $this->db->get('user_auth')->row();
        
        if($query) return $query;
        else return false;
    }

    function getUserAccountById($userid)
    {
        $this->db->select('*');
        $this->db->from('user_auth');
        $this->db->where("id", $userid);
        $query = $this->db->get()->row();
        return $query;

        /* $this->db->select('*');
        $this->db->from('zoho_accounts');
        $this->db->where("id", $userid);
        $query = $this->db->get()->row();
        return $query; */
    }
    function getHome($id)
    {
        $this->db->select('*');
        /* $this->db->from('zoho_buildings');
        $this->db->where("account_name", $id); */
        $this->db->from('buildings');
        $this->db->where('user_id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

    function getHomeByID($id, $userid)
    {
        $this->db->select('*');
        $this->db->from('zoho_buildings');
        $this->db->where("id", $id);
        $this->db->where("account_name", $userid);
        $query = $this->db->get()->row();
        return $query;
    }

    function getRooms($id, $userid, $is_wishlist = false)
    {        
        $this->db->select('rooms.*, rooms.id as id, floors.name as floor, room_names.name as name');
        $this->db->from('rooms');
        $this->db->join('floors', 'floors.id = rooms.floor_id', 'left');
        $this->db->join('room_names', 'room_names.id = rooms.room_name_id', 'left');
        
        if($is_wishlist) {
            $this->db->join('product_wishlist', 'product_wishlist.room_id = rooms.id');
            $this->db->where('product_wishlist.is_in_wishlist', 1);
        }
        
        // $this->db->where("account_name", $userid);
        $this->db->where('rooms.building_id', $id);
        $query = $this->db->get()->result();
        return $query;

        /* $this->db->select('*,zoho_rooms.id as id');
        $this->db->from('zoho_rooms');
        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("building", $id);
        $query = $this->db->get()->result();
        return $query; */
    }
    
    function getRoomsByID($id, $userid)
    {
        $this->db->select('*, rooms.id as id, floors.name as floor, room_names.name as name');
        $this->db->from('rooms');

        $this->db->join('floors', 'floors.id = rooms.floor_id', 'left');
        $this->db->join('room_names', 'room_names.id = rooms.room_name_id', 'left');

        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("rooms.id", $id);
        $query = $this->db->get()->row();
        return $query;

        /* $this->db->select('*,zoho_rooms.id as id');
        $this->db->from('zoho_rooms');
        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("zoho_rooms.id", $id);
        $query = $this->db->get()->row();
        return $query; */
    }
    function getComponents($id, $userid)
    {
        $this->db->select('*, products.*, components.id as id');
        $this->db->from('components');
        // $this->db->join('zoho_rooms',"zoho_rooms.id=components.room");
        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("room_id", $id);
        $this->db->join('products', 'products.id = components.product_id');
        $query = $this->db->get()->result();
        return $query;

        /* $this->db->select('*, zoho_components.id as id');
        $this->db->from('zoho_components');
        // $this->db->join('zoho_rooms',"zoho_rooms.id=zoho_components.room");
        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("room", $id);
        $query = $this->db->get()->result();
        return $query; */
    }
    function getComponentsByID($id, $userid)
    {
        $this->db->select('*,zoho_components.id as id');
        $this->db->from('zoho_components');
        // $this->db->join('zoho_rooms',"zoho_rooms.id=zoho_components.room");
        // $this->db->join('zoho_buildings',"zoho_buildings.id=zoho_rooms.building");
        // $this->db->where("account_name", $userid);
        $this->db->where("zoho_components.id", $id);
        $query = $this->db->get()->row();
        return $query;
    }
    function getSystemCertificates($id)
    {
        $this->db->select('*');
        $this->db->from('zoho_systems');
        $this->db->where("building", $id);
        $query = $this->db->get()->result();
        return $query;
    }
    function getAssetCertificates($id)
    {
        $this->db->select('*');
        $this->db->from('zoho_assets');
        $this->db->where("building", $id);
        $query = $this->db->get()->result();
        return $query;
    }
    function getRoomCertificates($id)
    {
        $this->db->select('*');
        $this->db->from('zoho_rooms');
        $this->db->where("building", $id);
        $query = $this->db->get()->result();
        return $query;
    }
    function getComponentCertificates($id)
    {
        $this->db->select('*');
        $this->db->from('zoho_components');
        $this->db->where("buildiings", $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function totalSnags($building_id) {
        $this->db->where('building_id', $building_id);
        $query = $this->db->get('snags')->num_rows();
        
        return $query;
    }

    public function totalSafetyNotice($building_id) {
        $this->db->where('building_id', $building_id);
        $query = $this->db->get('safety_notice')->num_rows();
        
        return $query;
    }

    public function getSnags($room_id) {
        $this->db->select('snag_attachments.image, snag_attachments.notes');
        $this->db->where('room_id', $room_id);
        $this->db->join('snag_attachments', 'snag_attachments.snag_id = snags.id');
        $query = $this->db->get('snags')->result();
        
        return $query;
    }

    public function getSafetyNotices($room_id) {
        $this->db->select('safety_notice_attachments.image, safety_notice_attachments.notes');
        $this->db->where('room_id', $room_id);
        $this->db->join('safety_notice_attachments', 'safety_notice_attachments.safety_notice_id = safety_notice.id');
        $query = $this->db->get('safety_notice')->result();
        
        return $query;
    }
}
