<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productionmaterialslave_model extends MY_Model {

    public $_table               = 'ub_productionmaterialslave';
    public $protected_attributes = array('pms_materialslaveid');
    public $primary_key          = 'pms_materialslaveid';

    public $selectedfields = 'pms_materialslaveid, pms_productionid, pms_materialid, pms_stockid, pms_qty, pms_itemrate, pms_unitprice, pms_mrp, pms_unitprice, pms_tax, pms_taxamount, pms_itemtotalrate, pms_itemtotalamount, pms_updatedon, pms_isactive';

    public function getproductionmaterials($billid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand, c.pc_categoryname, d.un_unitname, e.pt_batchno, e.pt_expirydate, e.pt_stock');
        $this->db->from('ub_productionmaterialslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pms_materialid', 'left');
        $this->db->join('ub_productcategories c', 'c.pc_productcategoryid=b.pd_categoryid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->join('ub_productstock e', 'e.pt_stockid=a.pms_stockid', 'left');
        $this->db->where('a.pms_productionid', $billid);
        $this->db->order_by('b.pd_productname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function deleteoldproductionitems($billid)
    {
        $this->db->where('pms_productionid', $billid);
        $this->db->delete('ub_productionmaterialslave');
    }
    public function insert_batch($value = '')
    {
        $this->db->insert_batch($this->_table, $value);
    }
}