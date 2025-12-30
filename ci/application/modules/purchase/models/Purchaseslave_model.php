<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Purchaseslave_model extends MY_Model {

    public $_table               = 'ub_purchaseslave';
    public $protected_attributes = array('ps_purchaseslaveid');
    public $primary_key          = 'ps_purchaseslaveid';

    public $selectedfields = 'ps_purchaseslaveid, ps_purchaseid, ps_productid, ps_batchno, ps_productstockid, ps_expirydate, ps_purchaseprice, ps_mrp, ps_gstpercent, ps_gstamnt, ps_discountpercent, ps_discountamnt, ps_purchaserate, ps_qty, ps_netamount, ps_totalgst, ps_totalamount';

    public function getpurchaseproducts($purchseid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_stock, c.pc_categoryname, d.un_unitname');
        $this->db->from('ub_purchaseslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.ps_productid', 'left');
        $this->db->join('ub_productcategories c', 'c.pc_productcategoryid=b.pd_categoryid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->where('a.ps_purchaseid', $purchseid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductpurchasehistory($productid, $fromdate, $todate)
    {
        $this->db->select('a.ps_qty, b.pm_purchaseid, b.pm_purchaseprefix, b.pm_purchaseno, b.pm_date, b.pm_time');
        $this->db->from('ub_purchaseslave a');
        $this->db->join('ub_purchasemaster b', 'b.pm_purchaseid=a.ps_purchaseid', 'left');
        $this->db->where('a.ps_productid', $productid);
        $this->db->where('a.ps_type', 0);
        $this->db->where('DATE(b.pm_date) >=', $fromdate);
        $this->db->where('DATE(b.pm_date) <=', $todate);
        $this->db->where('a.ps_israwmaterial', 0);
        $this->db->order_by('a.ps_purchaseslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gerpurchasegstb2blist($buid, $fromdate, $todate)
    {
        $this->db->select('a.ps_qty, a.ps_gstpercent, a.ps_netamount, a.ps_totalgst, a.ps_totalamount, b.pm_purchaseid, b.pm_purchaseprefix, b.pm_purchaseno, b.pm_date, b.pm_time, c.sp_name, c.sp_address, c.sp_gstno, d.name, d.statecode');
        $this->db->from('ub_purchaseslave a');
        $this->db->join('ub_purchasemaster b', 'b.pm_purchaseid=a.ps_purchaseid', 'left');
        $this->db->join('ub_suppliers c', 'c.sp_supplierid=b.pm_supplierid', 'left');
        $this->db->join('ub_states d', 'd.id=c.sp_state', 'left');
        $this->db->where('b.pm_buid', $buid);
        $this->db->where('b.pm_type', 2);
        $this->db->where('c.sp_gstno !=', "");
        $this->db->where('DATE(b.pm_date) >=', $fromdate);
        $this->db->where('DATE(b.pm_date) <=', $todate);
        $this->db->order_by('a.ps_purchaseslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gettotalpurchasecount($productid)
    {
        $this->db->select('SUM(ps_qty) as totqty');
        $this->db->from('ub_purchaseslave');
        $this->db->where('ps_productid', $productid);
        $this->db->where('ps_type', 0);
        $this->db->where('ps_israwmaterial', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->totqty;
        }else{
            return 0;
        }
    }

    public function deleteoldpurchaseitems($purchaseid)
    {
        $this->db->where('ps_purchaseid', $purchaseid);
        $this->db->delete('ub_purchaseslave');
    }

    public function insert_batch($value = '') {
        $this->db->insert_batch($this->_table, $value);
    }

    public function update_batch($value = '') {
        $this->db->update_batch($this->_table, $value, 'ps_purchaseslaveid');
    }
}
?>