<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Productstock_model extends MY_Model {

    public $_table               = 'ub_productstock';
    public $protected_attributes = array('pt_stockid');
    public $primary_key          = 'pt_stockid';

    public $selectedfields = 'pt_stockid, pt_buid, pt_productid, pt_batchno, pt_godownid, pt_expirydate, pt_purchaseprice, pt_mrp, pt_stock, pt_barcode, pt_barcodevalue';

    public function getproductstockdetailbyid($prdctstockid)
    {
        $this->db->select('a.pd_productid, a.pd_productcode, a.pd_productname, a.pd_size, a.pd_retailprice, a.pd_mrp, '.$this->selectedfields.', b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->like('f.pt_stockid', $prdctstockid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getproductstockdetails($buid, $prdctid, $batch, $godownid)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_productstock');
        $this->db->where('pt_buid', $buid);
        $this->db->where('pt_productid', $prdctid);
        $this->db->where('pt_batchno', $batch);
        $this->db->where('pt_godownid', $godownid);
        $this->db->where('pt_isactive', 0);
        $this->db->order_by('pt_stockid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function addproductstockbyid($stockid, $qty)
    {
    	$this->db->set('pt_stock', 'pt_stock+'.$qty, FALSE);
        $this->db->where('pt_stockid', $stockid);
        $this->db->update('ub_productstock');
    }
    public function reduceproductstockbyid($stockid, $qty)
    {
        $this->db->set('pt_stock', 'pt_stock-'.$qty, FALSE);
        $this->db->where('pt_stockid', $stockid);
        $this->db->update('ub_productstock');
    }

    public function insert_batch($value = '') {
        $this->db->insert_batch($this->_table, $value);
    }

    public function update_batch($value = '') {
        $this->db->update_batch($this->_table, $value, 'pt_stockid');
    }

    public function getproductstocklist($buid)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', a.pd_productcode, a.pd_prodimage, a.pd_productname, a.pd_size, a.pd_brand, a.pd_retailprice, a.pd_mrp, b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', 0);
        //$this->db->where('f.pt_stock >', 0);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductstockcategorylist($buid, $godownid, $categoryid, $rawmat=0)
    {
        $this->db->select('f.pt_stockid, f.pt_batchno, f.pt_expirydate, f.pt_stock, '.$this->selectedfields.', a.pd_productcode, a.pd_prodimage, a.pd_productname, a.pd_size, a.pd_brand, a.pd_retailprice, a.pd_mrp, b.pc_categoryname, c.un_unitname, d.tb_taxband, d.tb_tax');
        $this->db->from('ub_productstock f');
        $this->db->join('ub_products a', 'a.pd_productid=f.pt_productid', 'left');
        $this->db->join('ub_productcategories b', 'b.pc_productcategoryid=a.pd_categoryid', 'left');
        $this->db->join('ub_units c', 'c.un_unitid=a.pd_unitid', 'left');
        $this->db->join('ub_taxbands d', 'd.tb_taxbandid=a.pd_taxbandid', 'left');
        $this->db->where('f.pt_buid', $buid);
        $this->db->where('a.pd_isactive', 0);
        $this->db->where('a.pd_israwmaterial', $rawmat);
        if($godownid != 0)
        {
            $this->db->where('f.pt_godownid', $godownid);
        }
        if($categoryid != 0)
        {
            $this->db->where('a.pd_categoryid', $categoryid);
        }
        //$this->db->where('f.pt_stock >', 0);
        $this->db->order_by('a.pd_productname', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

}
?>