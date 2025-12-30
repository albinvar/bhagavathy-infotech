<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class products_model extends MY_Model {

    public $_table               = 'ub_products';
    public $protected_attributes = array('pd_productid');
    public $primary_key          = 'pd_productid';

    public $selectedfields = 'pd_productid, pd_productcode, pd_productname, pd_size, pd_brand, pd_company, pd_categoryid, pd_hsnno, pd_prodimage, pd_cess, pd_stock, pd_isactive, pd_unitid, pd_purchaseprice, pd_taxbandid, pd_mrp, pd_profittype, pd_retailprofit, pd_retailprice, pd_wholesaleprofit, pd_wholesaleprice, pd_csaleprofit, pd_csaleprice, pd_dsaleprofit, pd_dsaleprice, pd_stockthreshold';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function checkproductcodeexists($buid, $prdcode)
    {
        $this->db->select('pd_productid');
        $this->db->from('ub_products');
        $this->db->where('pd_buid', $buid);
        $this->db->where('pd_productcode', $prdcode);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    public function getproductdetailsbyid($prodid)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_productid', $prodid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getproductdetailstockbyid($prodid, $stockid)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_purchaseprice, f.pt_mrp, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('f.pt_stockid', $stockid);
        $this->db->where('a.pd_productid', $prodid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getactiveproductcount($buid)
    {
        $this->db->select('pd_productid');
        $this->db->from('ub_products');
        $this->db->where('pd_buid', $buid);
        $this->db->where('pd_isactive', 0);
        $this->db->where('pd_israwmaterial', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function searchproductsbycode($searchtag, $buid, $rawmat=0)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->like('pd_productcode', $searchtag);
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function searchproductstockbycode($searchtag, $buid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        //$this->db->like('pd_productcode', $searchtag);
        $this->db->where('(pd_productcode like "%'.$searchtag.'%" OR pt_barcodevalue="'.$searchtag.'")');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function speedsearchproductstockbycode($searchtag, $buid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        //$this->db->like('pd_productcode', $searchtag);
        $this->db->where('(pd_productcode ="'.$searchtag.'" OR pt_barcodevalue="'.$searchtag.'")');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function searchgodownproductstockbycode($searchtag, $buid, $godownid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        //$this->db->like('pd_productcode', $searchtag);
        $this->db->where('(pd_productcode like "%'.$searchtag.'%" OR pt_barcodevalue="'.$searchtag.'")');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('f.pt_godownid', $godownid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function speedsearchgodownproductstockbycode($searchtag, $buid, $godownid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        //$this->db->like('pd_productcode', $searchtag);
        $this->db->where('(pd_productcode="'.$searchtag.'" OR pt_barcodevalue="'.$searchtag.'")');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('f.pt_godownid', $godownid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function searchproductsbyname($searchtag, $buid, $rawmat=0)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->like('pd_productname', $searchtag);
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function searchproductstockbyname($searchtag, $buid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->like('pd_productname', $searchtag);
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function searchgodownproductstockbyname($searchtag, $buid, $godownid, $rawmat=0, $type=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->like('pd_productname', $searchtag);
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('f.pt_godownid', $godownid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            $this->db->where('f.pt_stock >', 0);
        }
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows($buid, $rawmat=0){
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gethsnproductrows($buid)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_hsnno !=', "");
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->group_by('a.pd_hsnno');
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getprofitproductrows($buid)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactivecategoryrows($buid, $categoryid, $rawmat=0)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        if($categoryid != 0)
        {
            $this->db->where('a.pd_categoryid', $categoryid);
        }
        
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductoutofstocks($buid){
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->where('a.pd_stock <= a.pd_stockthreshold');
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductoutofstockcount($buid){
        $this->db->select('pd_productid');
        $this->db->from('ub_products');
        $this->db->where('pd_buid', $buid);
        $this->db->where('pd_isactive', 0);
        $this->db->where('pd_israwmaterial', 0);
        $this->db->where('pd_stock <=', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getdeletedrows($buid, $rawmat=0){
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 1);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function addproductstock($prdctid, $qty){
        $this->db->set('pd_stock', 'pd_stock+'.$qty, FALSE);
        $this->db->where('pd_productid', $prdctid);
        $this->db->update('ub_products');
    }
    public function reduceproductstock($prdctid, $qty){
        $this->db->set('pd_stock', 'pd_stock-'.$qty, FALSE);
        $this->db->where('pd_productid', $prdctid);
        $this->db->update('ub_products');
    }

    public function update_batch($value = '') {
        $this->db->update_batch($this->_table, $value, 'pd_productid');
    }
    
    public function insert_batch($value = '') {
        $this->db->insert_batch($this->_table, $value);
    }

    public function getproductexpiredlist($buid, $todaydate)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->where('pt_expirydate <=', $todaydate);
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->where('f.pt_stock >', 0);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getcsvexprotproducts($buid, $active)
    {
        $this->db->select('pd_productcode, pd_productname, b.pc_categoryname, c.un_unitname, pd_hsnno, d.tb_tax, pd_cess');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', $active);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function getnotdesignedproducts($buid)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->where('a.pd_productid NOT IN (SELECT pmd_productid FROM ub_productmaterialdesign)',NULL,FALSE);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getnotdesignedproductbyid($buid, $prdid)
    {
        $this->db->select($this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_products a');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('a.pd_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        $this->db->where('a.pd_productid NOT IN (SELECT pmd_productid FROM ub_productmaterialdesign WHERE pmd_productid!='.$prdid.')',NULL,FALSE);
        $this->db->order_by('a.pd_productid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }


}
?>