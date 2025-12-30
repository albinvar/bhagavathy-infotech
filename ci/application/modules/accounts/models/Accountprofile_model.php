<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class accountprofile_model extends MY_Model {

    public $_table               = 'ub_accountprofile';
    public $protected_attributes = array('ap_accprofileid');
    public $primary_key          = 'ap_accprofileid';

    private $select_fields = 'ap_accprofileid, ap_country, ap_showcurrency, ap_sufprefixsymbol, ap_noofdecimal';

    public function getunitaccountprofile($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_accountprofile');
		$this->db->where('ap_businessunitid', $buid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
}