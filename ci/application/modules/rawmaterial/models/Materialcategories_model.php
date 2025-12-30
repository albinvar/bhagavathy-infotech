<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class materialcategories_model extends MY_Model {
    public $_table               = 'ub_materialcategories';
    public $protected_attributes = array('mc_materialcategoryid');
    public $primary_key          = 'mc_materialcategoryid';

    private $select_fields = 'mc_materialcategoryid, mc_categoryname, mc_description, mc_issub, mc_maincategoryid, mc_isactive, mc_updatedon, mc_updatedby';

    public function getenquirydetailsbyid($categoryid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_materialcategories');
		$this->db->where('mc_materialcategoryid', $categoryid);
		//$this->db->where('a.mc_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }

    public function getrowbyid($id)
    {
        $this->db->select($this->select_fields);
        $this->db->from('ub_materialcategories');
        $this->db->where('mc_materialcategoryid', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getallrows($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_materialcategories');
		$this->db->where('mc_buid', $buid);
		$this->db->order_by('mc_materialcategoryid', 'DESC');
		//$this->db->where('a.mc_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }

    public function getmaincategories($buid){
    	$this->db->select($this->select_fields);
        $this->db->from('ub_materialcategories');
        $this->db->where('mc_buid', $buid);
        $this->db->where('mc_issub', 0);
        $this->db->where('mc_isactive', 0);
        $this->db->order_by('mc_categoryname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getactiverows($buid){
        $this->db->select($this->select_fields);
        $this->db->from('ub_materialcategories');
        $this->db->where('mc_buid', $buid);
        $this->db->where('mc_isactive', 0);
        $this->db->order_by('mc_categoryname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    
    
}
?>