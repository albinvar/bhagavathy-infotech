<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class documentfolders_model extends MY_Model {
    public $_table               = 'ub_documentfolders';
    public $protected_attributes = array('df_folderid');
    public $primary_key          = 'df_folderid';

    private $select_fields = 'df_folderid, df_foldername, df_description, df_isactive, df_addedon, df_addedby';

    public function getrowbyid($folderid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_documentfolders');
		$this->db->where('df_folderid', $folderid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getallrows($buid)
    {
    	$this->db->select($this->select_fields.', f.at_name');
		$this->db->from('ub_documentfolders a');
		$this->db->join('ub_authentication f', 'f.at_authid=a.df_addedby', 'left');
		$this->db->where('a.df_buid', $buid);
		//$this->db->where('a.df_isactive', 0);
		$this->db->order_by('a.df_foldername', 'ASC');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

    public function getactiverows($buid)
    {
    	$this->db->select($this->select_fields.', f.at_name');
		$this->db->from('ub_documentfolders a');
		$this->db->join('ub_authentication f', 'f.at_authid=a.df_addedby', 'left');
		$this->db->where('a.df_buid', $buid);
		$this->db->where('a.df_isactive', 0);
		$this->db->order_by('a.df_foldername', 'ASC');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

    
}
?>