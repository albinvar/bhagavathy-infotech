<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class taxbands_model extends MY_Model {
    public $_table               = 'ub_taxbands';
    public $protected_attributes = array('tb_taxbandid');
    public $primary_key          = 'tb_taxbandid';

    private $select_fields = 'tb_taxbandid, tb_taxband, tb_tax, tb_notes, tb_isactive, tb_updatedon';

    public function getrowbytaxid($taxid)
    {
		$this->db->select($this->select_fields);
		$this->db->from('ub_taxbands');
		$this->db->where('tb_taxbandid', $taxid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getallrows($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_taxbands');
		$this->db->where('tb_buid', $buid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getactiverows($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_taxbands');
		$this->db->where('tb_buid', $buid);
		$this->db->where('tb_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
}