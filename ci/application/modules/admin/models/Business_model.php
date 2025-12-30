<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class business_model extends MY_Model {

    public $_table               = 'ub_business';
    public $protected_attributes = array('bs_businessid');
    public $primary_key          = 'bs_businessid';

    public function getallrows() {
        $this->db->select('*');
        $this->db->from('ub_business');
        $this->db->order_by('bs_businessid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getactiverows(){
        $this->db->select('*');
        $this->db->from('ub_business');
        $this->db->where('bs_status', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getbusinessdetails($busid)
    {
        $this->db->select('*');
        $this->db->from('ub_business');
        $this->db->where('bs_businessid', $busid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
?>