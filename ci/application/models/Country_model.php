<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country_model extends MY_Model {

	public $_table               = 'ub_countries';
	public $protected_attributes = array('id');
	public $primary_key          = 'id';

	private $select_fields = 'id, name, currency_symbol';

	public function getalldata()
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_countries');
		$this->db->where('ishow', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}
	public function getstatelist($countryid)
	{
		$this->db->select('id, name');
		$this->db->from('ub_states');
		$this->db->where('country_id', $countryid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}

}