<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productmaterialdesignslave_model extends MY_Model {

    public $_table               = 'ub_productmaterialdesignslave';
    public $protected_attributes = array('pdm_productmaterialid');
    public $primary_key          = 'pdm_productmaterialid';

    public $selectedfields = 'pdm_productmaterialid, pdm_productdesignid, pdm_materialid, pdm_qty, pdm_rate, pdm_unitprice, pdm_mrp, pdm_itemtotalamount, pdm_tax, pdm_totalgst, pdm_isactive, pdm_updatedon';

    public function getproductmaterials($proddesignid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_size, b.pd_brand, b.pd_hsnno, b.pd_prodimage');
        $this->db->from('ub_productmaterialdesignslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pdm_materialid', 'left');
        $this->db->where('a.pdm_productdesignid', $proddesignid);
        $this->db->order_by('a.pdm_productmaterialid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function selectedproductmaterials($productid)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_size, b.pd_brand, b.pd_hsnno, b.pd_prodimage, d.un_unitname');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_productmaterialdesignslave a', 'a.pdm_materialid=f.pt_productid', 'left');
        $this->db->join('ub_productmaterialdesign c', 'c.pmd_productdesignid=a.pdm_productdesignid', 'left');
        $this->db->join('ub_products b', 'b.pd_productid=a.pdm_materialid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->where('c.pmd_productid', $productid);
        $this->db->where('c.pmd_isactive', 0);
        $this->db->order_by('b.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function deleteolddesignmaterilas($rdesignid)
    {
        $this->db->where('pdm_productdesignid', $rdesignid);
        $this->db->delete('ub_productmaterialdesignslave');
    }

}
?>