<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class accountmaingroups_model extends MY_Model {

    public $_table               = 'ub_accountmaingroups';
    public $protected_attributes = array('am_maingroupid');
    public $primary_key          = 'am_maingroupid';


    public function getallrows(){
        $this->db->select('*');
        $this->db->from('ub_accountmaingroups');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getrowbyid($grpid){
        $this->db->select('*');
        $this->db->from('ub_accountmaingroups');
        $this->db->where('am_maingroupid', $grpid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
?>