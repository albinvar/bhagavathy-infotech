<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class registrations_model extends MY_Model {

    public $_table               = 'ub_registrations';
    public $protected_attributes = array('rg_registrationid');
    public $primary_key          = 'rg_registrationid';

    private $select_fields = 'rg_registrationid';

    public function getalldata()
    {
    	$this->db->select('*');
        $this->db->from('ub_registrations');
        $this->db->order_by('rg_registrationid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    public function getnewregistrations()
    {
        $this->db->select('*');
        $this->db->from('ub_registrations');
        $this->db->where('rg_status', 0);
        $this->db->order_by('rg_registrationid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }
}
?>