<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class businesstypes_model extends MY_Model {

    public $_table               = 'ub_businesstypes';
    public $protected_attributes = array('bt_businesstypeid');
    public $primary_key          = 'bt_businesstypeid';

    public function getallrows() {
        $this->db->select('bt_businesstypeid, bt_businesstype, bt_description, bt_isactive');
        $this->db->from('ub_businesstypes');
        $this->db->order_by('bt_businesstypeid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows(){
        $this->db->select('bt_businesstypeid, bt_businesstype, bt_description, bt_isactive');
        $this->db->from('ub_businesstypes');
        $this->db->where('bt_isactive', 0);
        $this->db->order_by('bt_businesstypeid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

}
?>