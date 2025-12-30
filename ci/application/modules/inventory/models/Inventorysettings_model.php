<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inventorysettings_model extends MY_Model {

    public $_table               = 'ub_inventorysettings';
    public $protected_attributes = array('is_inventorysettingid');
    public $primary_key          = 'is_inventorysettingid';

    public function getinventorysettings($buid)
    {
    	$this->db->select('*');
        $this->db->from('ub_inventorysettings');
        $this->db->where('is_buid', $buid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
}