<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class customers_model extends MY_Model {
    public $_table               = 'ub_customers';
    public $protected_attributes = array('ct_cstomerid');
    public $primary_key          = 'ct_cstomerid';

    private $select_fields = 'ct_cstomerid, ct_name, ct_type, ct_address, ct_city, ct_country, ct_state, ct_phone, ct_mobile, ct_email, ct_gstin, ct_balanceamount, ct_updatedon, ct_isactive, b.name as countryname, c.name as statename';

    public function getcustomerdetailsbyid($customerid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_customers a');
		$this->db->join('ub_countries b', 'b.id=a.ct_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.ct_state', 'left');
		$this->db->where('a.ct_cstomerid', $customerid);
		//$this->db->where('a.ct_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

    public function getallcustomers($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_customers a');
		$this->db->join('ub_countries b', 'b.id=a.ct_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.ct_state', 'left');
		$this->db->where('a.ct_buid', $buid);
		//$this->db->where('a.ct_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getactivecustomers($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_customers a');
		$this->db->join('ub_countries b', 'b.id=a.ct_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.ct_state', 'left');
		$this->db->where('a.ct_buid', $buid);
		$this->db->where('a.ct_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getactivecustomercount($buid)
    {
    	$this->db->select('ct_cstomerid');
		$this->db->from('ub_customers');
		$this->db->where('ct_buid', $buid);
		$this->db->where('ct_isactive', 0);
		$query = $this->db->get();
		return $query->num_rows();
    }
    public function getactivecustomerbalance($buid)
    {
    	$this->db->select('SUM(ct_balanceamount) as custsum');
		$this->db->from('ub_customers');
		$this->db->where('ct_buid', $buid);
		$this->db->where('ct_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function searchcustomerbytag($tag, $buid)
    {
    	$this->db->select('ct_cstomerid, ct_name, ct_address, ct_gstin, ct_type');
		$this->db->from('ub_customers');
		$this->db->where('ct_isactive', 0);
		$this->db->where('ct_buid', $buid);
		$this->db->like('ct_name', $tag);
		$this->db->or_like('ct_gstin', $tag);
		$this->db->order_by('ct_name', 'asc');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

    public function getcustomerbalance($customerid)
    {
    	$this->db->select('ct_balanceamount');
		$this->db->from('ub_customers');
		$this->db->where('ct_cstomerid', $customerid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
}
?>