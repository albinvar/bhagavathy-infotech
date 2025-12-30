<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units_model extends MY_Model {

	public $_table               = 'ub_units';
	public $protected_attributes = array('un_unitid');
	public $primary_key          = 'un_unitid';

	private $select_fields = 'un_unitid, un_unitname, un_description, un_isactive';

	public function getallrows($buid)
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_units');
		$this->db->where('un_buid', $buid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}

	public function getactiverows($buid)
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_units');
		$this->db->where('un_buid', $buid);
		$this->db->where('un_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}

}