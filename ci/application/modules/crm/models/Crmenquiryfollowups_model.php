<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class crmenquiryfollowups_model extends MY_Model {
    public $_table               = 'ub_crmenquiryfollowups';
    public $protected_attributes = array('ef_followupid');
    public $primary_key          = 'ef_followupid';

    private $select_fields = 'ef_followupid, ef_enquiryid, ef_followupnote, ef_status, ef_nextfollowupdate, ef_updatedby, ef_updatedon';

    public function getlastfollowupdet($enquiryid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_crmenquiryfollowups');
		$this->db->where('ef_enquiryid', $enquiryid);
		$this->db->order_by('ef_followupid', 'DESC');
		$this->limit(1);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

    public function getenquiryfollowupdetails($enquiryid)
    {
    	$this->db->select($this->select_fields .', f.at_name');
		$this->db->from('ub_crmenquiryfollowups a');
		$this->db->join('ub_authentication f', 'f.at_authid=a.ef_updatedby', 'left');
		$this->db->where('a.ef_enquiryid', $enquiryid);
		$this->db->order_by('a.ef_followupid', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

}
?>