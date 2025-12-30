<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Documents_model extends MY_Model {
    public $_table               = 'ub_documents';
    public $protected_attributes = array('dc_documentid');
    public $primary_key          = 'dc_documentid';

    private $select_fields = 'dc_documentid, dc_filename, dc_description, dc_folder, dc_starred, dc_addedon, dc_isactive, dc_updatedon';

    public function getdocummentbyid($docid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_documents');
		$this->db->where('dc_documentid', $docid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getactiverows($buid, $status, $folder)
    {
    	$recntdate = date('Y-m-d', strtotime('-30 days'));
    	$this->db->select($this->select_fields.', b.df_foldername, f.at_name');
		$this->db->from('ub_documents a');
		$this->db->join('ub_documentfolders b', 'b.df_folderid=a.dc_folder', 'left');
		$this->db->join('ub_authentication f', 'f.at_authid=a.dc_addedby', 'left');
		$this->db->where('a.dc_buid', $buid);
		if($status == 1)
		{
			$this->db->where('a.dc_starred', 1);
		}
		if($status == 3)
		{
			$this->db->where('a.dc_isactive', 1);
		}else{
			$this->db->where('a.dc_isactive', 0);
		}

		if($folder != 0)
		{
			$this->db->where('a.dc_folder', $folder);
		}

		if($status == 2)
		{
			$this->db->where('DATE(a.dc_updatedon) >=', $recntdate);
		}
		
		$this->db->order_by('a.dc_documentid', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    
}
?>