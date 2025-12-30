<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class accountgroups_model extends MY_Model {

    public $_table               = 'ub_accountgroups';
    public $protected_attributes = array('ag_groupid');
    public $primary_key          = 'ag_groupid';

    public function getrowbyid($grpid){
        $this->db->select('ag_accmain');
        $this->db->from('ub_accountgroups');
        $this->db->where('ag_groupid', $grpid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function accountgroupalreadyexists($buid, $groupname){
        $this->db->select('ag_groupid');
        $this->db->from('ub_accountgroups');
        $this->db->where('ag_group', $groupname);
        $this->db->where('(ag_buid = "'.$buid.'" OR ag_isdefault="1")');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

     public function getaccountmaingroups($buid){
        $this->db->select('a.*, b.am_maingroup');
        $this->db->from('ub_accountgroups a');
        $this->db->join('ub_accountmaingroups b', 'b.am_maingroupid=a.ag_accmain', 'left');
        $this->db->where('a.ag_issub', 0);
        $this->db->where('(a.ag_buid = "'.$buid.'" OR a.ag_isdefault="1")');
        
        $this->db->order_by('a.ag_group', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getaccsubgroups($maingrpid, $buid)
    {
    	$this->db->select('*');
        $this->db->from('ub_accountgroups');
        $this->db->where('ag_maingroupid', $maingrpid);
        $this->db->where('ag_issub', 1);
        $this->db->where('(ag_buid = "'.$buid.'" OR ag_isdefault="1")');
        $this->db->order_by('ag_group', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getallativeaccountroups($buid)
    {
        $this->db->select('*');
        $this->db->from('ub_accountgroups');
        $this->db->where('(ag_buid = "'.$buid.'" OR ag_isdefault="1")');
        $this->db->where('ag_isactive', 0);
        $this->db->order_by('ag_group', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

}