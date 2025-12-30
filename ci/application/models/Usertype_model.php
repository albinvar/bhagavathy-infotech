<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usertype_model extends MY_Model {

	public $_table               = 'ub_usertypes';
	public $protected_attributes = array('ut_usertypeid');
	public $primary_key          = 'ut_usertypeid';

	private $select_fields = 'ut_usertypeid, ut_usertype, ut_isactive, ut_notes';

	public function __construct() {
		parent::__construct();

	}

	public function getallrows() {
		$this->db->select($this->select_fields);
		$this->db->from('ub_usertypes');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}
	public function getrowbyid($typeid)
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_usertypes');
		$this->db->where('ut_usertypeid', $typeid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
	}

	public function getbusinessdesignations($buid)
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_usertypes');
		$this->db->where('ut_businessid', $buid);
		//$this->db->where('ut_isactive', '0');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}
	public function businessusertypes($buid)
	{
		$this->db->select($this->select_fields);
		$this->db->from('ub_usertypes');
		$this->db->where('ut_businessid', $buid);
		$this->db->where('ut_isactive', '0');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
	}

	public function selectusertypes() {
        $this->db->select($this->select_fields);
        $this->db->where('ut_isactive', '0');
        $this->db->where('ut_isvisible', '1');
        $this->db->from('ub_usertypes');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}
    

/* End of file Usertype_model.php */
/* Location: ./application/models/Usertype_model.php */