<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productmaterialdesign_model extends MY_Model {

    public $_table               = 'ub_productmaterialdesign';
    public $protected_attributes = array('pmd_productdesignid');
    public $primary_key          = 'pmd_productdesignid';

    public $selectedfields = 'pmd_productdesignid, pmd_productid, pmd_averagaetime, pmd_averagecost, pmd_totalamount, pmd_gstamount, pmd_isactive, pmd_updatedby, pmd_updatedon';

    public function getallrows($buid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage');
        $this->db->from('ub_productmaterialdesign a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pmd_productid', 'left');
        $this->db->where('a.pmd_buid', $buid);
        $this->db->order_by('a.pmd_productdesignid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getproddesigndetailsbyid($designid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productmaterialdesign');
        $this->db->where('pmd_productdesignid', $designid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
?>