<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class financialyears_model extends MY_Model {
    public $_table               = 'ub_financialyears';
    public $protected_attributes = array('ay_financialyearid');
    public $primary_key          = 'ay_financialyearid';

    private $select_fields = 'ay_financialyearid, ay_financialname, ay_startdate, ay_enddate, ay_isdefault, ay_updatedon';

    public function getrowbyyearid($taxid)
    {
		$this->db->select($this->select_fields);
		$this->db->from('ub_financialyears');
		$this->db->where('ay_financialyearid', $taxid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getallrows($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_financialyears');
		$this->db->where('ay_buid', $buid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getcurrentfinancialyear($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_financialyears');
		$this->db->where('ay_buid', $buid);
		$this->db->where('ay_isdefault', 1);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

}