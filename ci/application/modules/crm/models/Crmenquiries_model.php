<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class crmenquiries_model extends MY_Model {
    public $_table               = 'ub_crmenquiries';
    public $protected_attributes = array('en_enquiryid');
    public $primary_key          = 'en_enquiryid';

    private $select_fields = 'en_enquiryid, en_enquiryprefix, en_enquiryno, en_existingcust, en_customerid, en_firstname, en_lastname, en_address, en_city, en_state, en_country, en_mobile, en_phone, en_email, en_customertype, en_gstno, en_subject, en_enquiry, en_status, en_isactive, en_addedon, en_addedby, en_completedcomments, en_completedon';

    public function getenquirydetailsbyid($enquiryid)
    {
    	$this->db->select($this->select_fields. ", d.ct_cstomerid, d.ct_name, d.ct_address, d.ct_phone, d.ct_mobile, b.name as countryname, c.name as statename, f.at_name as addedby, f.at_name as completedby");
		$this->db->from('ub_crmenquiries a');
		$this->db->join('ub_customers d', 'd.ct_cstomerid=a.en_customerid', 'left');
		$this->db->join('ub_countries b', 'b.id=a.en_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.en_state', 'left');
		$this->db->join('ub_authentication f', 'f.at_authid=a.en_addedby', 'left');
		$this->db->join('ub_authentication g', 'g.at_authid=a.en_completedby', 'left');
		$this->db->where('a.en_enquiryid', $enquiryid);
		//$this->db->where('a.ct_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

    public function getnextenquirynumber($buid)
    {
        $this->db->select('en_enquiryno');
        $this->db->from('ub_crmenquiries');
        $this->db->where('en_buid', $buid);
        $this->db->order_by('en_enquiryno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->en_enquiryno + 1;
        }else{
            return 1;
        }
    }

    public function getallenquiries($buid)
    {
    	$this->db->select($this->select_fields. ", d.ct_cstomerid, d.ct_name, d.ct_address, d.ct_phone, d.ct_mobile, b.name as countryname, c.name as statename");
		$this->db->from('ub_crmenquiries a');
		$this->db->join('ub_customers d', 'd.ct_cstomerid=a.en_customerid', 'left');
		$this->db->join('ub_countries b', 'b.id=a.en_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.en_state', 'left');
		$this->db->where('a.en_buid', $buid);
		//$this->db->where('a.en_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getdeletedenquiries($buid)
    {
    	$this->db->select($this->select_fields. ", d.ct_cstomerid, d.ct_name, d.ct_address, d.ct_phone, d.ct_mobile, b.name as countryname, c.name as statename");
		$this->db->from('ub_crmenquiries a');
		$this->db->join('ub_customers d', 'd.ct_cstomerid=a.en_customerid', 'left');
		$this->db->join('ub_countries b', 'b.id=a.en_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.en_state', 'left');
		$this->db->where('a.en_buid', $buid);
		$this->db->where('a.en_isactive', 1);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getallenquiriesbystatus($buid, $status)
    {
    	$this->db->select($this->select_fields. ", d.ct_cstomerid, d.ct_name, d.ct_address, d.ct_phone, d.ct_mobile, b.name as countryname, c.name as statename");
		$this->db->from('ub_crmenquiries a');
		$this->db->join('ub_customers d', 'd.ct_cstomerid=a.en_customerid', 'left');
		$this->db->join('ub_countries b', 'b.id=a.en_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.en_state', 'left');
		$this->db->where('a.en_buid', $buid);
		$this->db->where('a.en_status', $status);
		$this->db->where('a.en_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getenquirycountbystatus($buid, $status)
    {
    	$this->db->select("en_enquiryid");
		$this->db->from('ub_crmenquiries');
		$this->db->where('en_buid', $buid);
		$this->db->where('en_status', $status);
		$this->db->where('en_isactive', 0);
		$query = $this->db->get();
		
		return $query->num_rows();
    }
    public function getdeletedenquirycount($buid)
    {
    	$this->db->select("en_enquiryid");
		$this->db->from('ub_crmenquiries');
		$this->db->where('en_buid', $buid);
		$this->db->where('en_isactive', 1);
		$query = $this->db->get();
		
		return $query->num_rows();
    }
    public function getactiveenquiries($buid)
    {
    	$this->db->select($this->select_fields. ", b.name as countryname, c.name as statename");
		$this->db->from('ub_crmenquiries a');
		$this->db->join('ub_countries b', 'b.id=a.en_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.en_state', 'left');
		$this->db->where('a.en_buid', $buid);
		$this->db->where('a.en_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getactivecustomercount($buid)
    {
    	$this->db->select('en_enquiryid');
		$this->db->from('ub_crmenquiries');
		$this->db->where('en_buid', $buid);
		$this->db->where('en_isactive', 0);
		$query = $this->db->get();
		return $query->num_rows();
    }
    
}
?>