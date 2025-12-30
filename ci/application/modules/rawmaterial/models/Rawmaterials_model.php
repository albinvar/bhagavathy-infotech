<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class rawmaterials_model extends MY_Model {
    public $_table               = 'ub_rawmaterials';
    public $protected_attributes = array('rm_materialid');
    public $primary_key          = 'rm_materialid';

    private $select_fields = 'rm_materialid, rm_materialcode, rm_materialname, rm_categoryid, rm_brand, rm_company, rm_size, rm_hsnno, rm_description, rm_materialimage, rm_taxbandid, rm_cess, rm_unitid, rm_purchaseprice, rm_mrp, rm_stock, rm_isactive, rm_addedon, rm_stockthreshold';

    public function getmaterialdetailsbyid($editid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_rawmaterials');
		$this->db->where('rm_materialid', $editid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
    public function getactiverows($buid)
    {
    	$this->db->select($this->select_fields .', b.mc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
		$this->db->from('ub_rawmaterials a');
		$this->db->join('ub_materialcategories b', 'b.mc_materialcategoryid=a.rm_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.rm_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.rm_taxbandid', 'left');
		$this->db->where('a.rm_buid', $buid);
		$this->db->where('a.rm_isactive', 0);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    public function getdeletedrows($buid)
    {
    	$this->db->select($this->select_fields.', b.mc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
		$this->db->from('ub_rawmaterials a');
		$this->db->join('ub_materialcategories b', 'b.mc_materialcategoryid=a.rm_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.rm_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.rm_taxbandid', 'left');
		$this->db->where('a.rm_buid', $buid);
		$this->db->where('a.rm_isactive', 1);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		}
		return FALSE;
    }
    
}
?>