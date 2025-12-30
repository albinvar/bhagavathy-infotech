<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Servicebillslave_model extends MY_Model {

    public $_table               = 'ub_servicebillslave';
    public $protected_attributes = array('sbs_serviceslaveid');
    public $primary_key          = 'sbs_serviceslaveid';

    public $selectedfields = 'sbs_serviceslaveid, sbs_servicebillid, sbs_productname, sbs_complaint, sbs_price, sbs_updatedby, sbs_updatedon';

    public function getbillproducts($billid)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_servicebillslave');
        $this->db->where('sbs_servicebillid', $billid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}
?>