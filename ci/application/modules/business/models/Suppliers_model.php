<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class suppliers_model extends MY_Model {
    public $_table               = 'ub_suppliers';
    public $protected_attributes = array('sp_supplierid');
    public $primary_key          = 'sp_supplierid';

    private $select_fields = 'sp_supplierid, sp_name, sp_address, sp_city, sp_state, sp_country, sp_contactnumber, sp_mobile, sp_email, sp_website, sp_contactperson, sp_contactphone, sp_gstno, sp_updatedon, sp_balanceamount, sp_isactive, b.name as countryname, c.name as statename';

    public function getsupplierdetailsbyid($supplierid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_suppliers a');
		$this->db->join('ub_countries b', 'b.id=a.sp_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.sp_state', 'left');
		$this->db->where('a.sp_supplierid', $supplierid);
		//$this->db->where('a.sp_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getsupplierbalance($supplierid)
    {
    	$this->db->select('sp_balanceamount');
		$this->db->from('ub_suppliers');
		$this->db->where('sp_supplierid', $supplierid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

    public function searchsupplierbytag($tag, $buid)
    {
    	$this->db->select('sp_supplierid, sp_name, sp_gstno');
		$this->db->from('ub_suppliers');
		/*$this->db->like('sp_name', $tag);
		$this->db->or_like('sp_gstno', $tag);*/
		$this->db->where('(sp_name LIKE "%'.$tag.'%" OR sp_gstno LIKE "%'.$tag.'%")');
		$this->db->where('sp_isactive', 0);
		$this->db->where('sp_buid', $buid);
		$this->db->order_by('sp_name', 'asc');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

    public function getallsuppliers($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_suppliers a');
		$this->db->join('ub_countries b', 'b.id=a.sp_country', 'left');
		$this->db->join('ub_states c', 'c.id=a.sp_state', 'left');
		$this->db->where('a.sp_buid', $buid);
		//$this->db->where('a.sp_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getactivesuppliercount($buid)
    {
    	$this->db->select('sp_supplierid');
		$this->db->from('ub_suppliers');
		$this->db->where('sp_buid', $buid);
		$this->db->where('sp_isactive', 0);
		$query = $this->db->get();
		return $query->num_rows();
    }
    public function getactivesupplierbalance($buid)
    {
    	$this->db->select('SUM(sp_balanceamount) as supbalance');
		$this->db->from('ub_suppliers');
		$this->db->where('sp_buid', $buid);
		$this->db->where('sp_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
}
?>