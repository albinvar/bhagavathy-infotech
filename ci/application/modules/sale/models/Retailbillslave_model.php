<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Retailbillslave_model extends MY_Model {

    public $_table               = 'ub_retailbillslave';
    public $protected_attributes = array('rbs_retailbillslaveid');
    public $primary_key          = 'rbs_retailbillslaveid';

    public $selectedfields = 'rbs_retailbillslaveid, rbs_retailbillid, rbs_productid, rbs_stockid, rbs_batchno, rbs_expirydate, rbs_purchaseprice, rbs_mrp, rbs_netamount, rbs_unitprice, rbs_gstpercent, rbs_gstamnt, rbs_cesspercent, rbs_cessamount, rbs_discountpercent, rbs_discountamnt, rbs_qty, rbs_totalamount, rbs_totalgst, rbs_totaldiscount, rbs_totalcess, rbs_profit, rbs_nettotal, rbs_remarks, rbs_discountedprice, rbs_itemunitprice';

    public function getsaleproducts($billid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand, c.pc_categoryname, d.un_unitname, e.pt_batchno, e.pt_expirydate, e.pt_stock');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.rbs_productid', 'left');
        $this->db->join('ub_productcategories c', 'c.pc_productcategoryid=b.pd_categoryid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->join('ub_productstock e', 'e.pt_stockid=a.rbs_stockid', 'left');
        $this->db->where('a.rbs_retailbillid', $billid);
        $this->db->order_by('b.pd_productname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductsalehistory($productid, $fromdate, $todate)
    {
        $this->db->select('a.rbs_qty, a.rbs_type, b.rb_retailbillid, b.rb_billprefix, b.rb_billno, b.rb_date, b.rb_time');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_productid', $productid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('(a.rbs_type = 0 OR a.rbs_type = 1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $this->db->order_by('a.rbs_retailbillslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductsalesum($productid, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_purchaseprice*a.rbs_qty) as totpurchase, SUM(a.rbs_totalamount) as totsale, SUM(a.rbs_profit) as totprofit');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_productid', $productid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getbillsalesumbyid($billid)
    {
        $this->db->select('SUM(rbs_qty) as totqty, SUM(rbs_purchaseprice*rbs_qty) as totpurchase, SUM(rbs_totalamount) as totsale, SUM(rbs_profit) as totprofit');
        $this->db->from('ub_retailbillslave');
        $this->db->where('rbs_retailbillid', $billid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getprofittotalbyfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_purchaseprice*a.rbs_qty) as totpurchase, SUM(a.rbs_totalamount) as totsale, SUM(a.rbs_profit) as totprofit');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_buid', $buid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        
        $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getfastmovingitemsfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, c.pd_productid, c.pd_productcode, c.pd_productname, c.pd_size, c.pd_brand, c.pd_company');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_products c', 'c.pd_productid=a.rbs_productid', 'left');
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        
        
        $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $this->db->group_by('a.rbs_productid');
        $this->db->order_by('totqty', 'DESC');
        $this->db->limit('10');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getslowmovingitemsfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, c.pd_productid, c.pd_productcode, c.pd_productname, c.pd_size, c.pd_brand, c.pd_company');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_products c', 'c.pd_productid=a.rbs_productid', 'left');
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        
        
        $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $this->db->group_by('a.rbs_productid');
        $this->db->order_by('totqty', 'ASC');
        $this->db->limit('10');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getnotsaleitemsfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('pd_productid, pd_productcode, pd_productname, pd_size, pd_brand, pd_company');
        $this->db->from('ub_products');
        $this->db->where('pd_buid', $buid);
        $this->db->where('pd_productid NOT IN (select rbs_productid from ub_retailbillslave where DATE(rbs_updatedon) >= "'.$fromdate.'" AND DATE(rbs_updatedon) <="'.$todate.'")',NULL,FALSE);
        $this->db->where('pd_isactive', 0);
        //$this->db->limit('10');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gethsnproductkeralasalesum($hsn, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_products c', 'c.pd_productid=a.rbs_productid', 'left');
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        $this->db->where('c.pd_hsnno', $hsn);
        $this->db->where('b.rb_state', '4028');

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function gethsnproductoutkeralasalesum($hsn, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_products c', 'c.pd_productid=a.rbs_productid', 'left');
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('c.pd_hsnno', $hsn);
        $this->db->where('a.rbs_buid', $this->buid);
        $this->db->where('b.rb_state !=', '4028');

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getproductkeralasalesum($productid, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_productid', $productid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        $this->db->where('b.rb_state', '4028');

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function gettaxvaluekeralasalesum($taxval, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_gstpercent', $taxval);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        $this->db->where('b.rb_state', '4028');

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getproductoutkeralasalesum($productid, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_productid', $productid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('a.rbs_buid', $this->buid);
        $this->db->where('b.rb_state !=', '4028');

        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function gettaxvalueoutkeralasalesum($taxval, $type, $fromdate, $todate)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty, SUM(a.rbs_nettotal) as totnet, SUM(a.rbs_totalamount) as totamnt, SUM(a.rbs_totalgst) as totgst');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_gstpercent', $taxval);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);

        $this->db->where('b.rb_state !=', '4028');
        $this->db->where('a.rbs_buid', $this->buid);
        if($type != 'all')
        {
            $this->db->where('a.rbs_type', $type);
        }else{
            $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        }
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getretailgstrb2blist($buid, $fromdate, $todate)
    {
        $this->db->select('a.rbs_qty, a.rbs_type, a.rbs_gstpercent, a.rbs_gstamnt, a.rbs_totalgst, a.rbs_totalamount, a.rbs_nettotal, a.rbs_cesspercent, a.rbs_totalcess, b.rb_retailbillid, b.rb_billprefix, b.rb_billno, b.rb_date, b.rb_time, b.rb_customerid, b.rb_customername, b.rb_address, b.rb_gstno, c.ct_name, c.ct_address, c.ct_gstin');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_customers c', 'c.ct_cstomerid=b.rb_customerid', 'left');
        $this->db->where('a.rbs_buid', $buid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $this->db->where('(a.rbs_type = 0 OR a.rbs_type = 1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('((c.ct_type = 1 AND b.rb_customerid != 0) OR (b.rb_customerid = 0 AND b.rb_gstno!=""))');
        $this->db->order_by('a.rbs_retailbillslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getretailgstrb2clist($buid, $fromdate, $todate)
    {
        $this->db->select('a.rbs_qty, a.rbs_type, a.rbs_gstpercent, a.rbs_gstamnt, a.rbs_totalgst, a.rbs_totalamount, a.rbs_nettotal, a.rbs_cesspercent, a.rbs_totalcess, b.rb_retailbillid, b.rb_billprefix, b.rb_billno, b.rb_date, b.rb_time, b.rb_customerid, b.rb_customername, b.rb_address, b.rb_gstno, c.ct_name, c.ct_address, c.ct_gstin');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_customers c', 'c.ct_cstomerid=b.rb_customerid', 'left');
        $this->db->where('a.rbs_buid', $buid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('b.rb_isreturn', 0);
        $this->db->where('(a.rbs_type = 0 OR a.rbs_type = 1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('((c.ct_type = 0 AND b.rb_customerid != 0) OR (b.rb_customerid = 0 AND b.rb_gstno=""))');
        $this->db->order_by('a.rbs_retailbillslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getretailreturngstrb2blist($buid, $fromdate, $todate)
    {
        $this->db->select('a.rbs_qty, a.rbs_type, a.rbs_gstpercent, a.rbs_gstamnt, a.rbs_totalgst, a.rbs_totalamount, a.rbs_nettotal, a.rbs_cesspercent, a.rbs_totalcess, b.rb_retailbillid, b.rb_billprefix, b.rb_billno, b.rb_date, b.rb_time, b.rb_customerid, b.rb_customername, b.rb_address, b.rb_gstno, c.ct_name, c.ct_address, c.ct_gstin, d.name, d.statecode');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_customers c', 'c.ct_cstomerid=b.rb_customerid', 'left');
        $this->db->join('ub_states d', 'd.id=b.rb_state', 'left');
        $this->db->where('a.rbs_buid', $buid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('b.rb_isreturn', 1);
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('(a.rbs_type = 0 OR a.rbs_type = 1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('((c.ct_type = 1 AND b.rb_customerid != 0) OR (b.rb_customerid = 0 AND b.rb_gstno!=""))');
        $this->db->order_by('a.rbs_retailbillslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getretailreturngstrb2clist($buid, $fromdate, $todate)
    {
        $this->db->select('a.rbs_qty, a.rbs_type, a.rbs_gstpercent, a.rbs_gstamnt, a.rbs_totalgst, a.rbs_totalamount, a.rbs_nettotal, a.rbs_cesspercent, a.rbs_totalcess, b.rb_retailbillid, b.rb_billprefix, b.rb_billno, b.rb_date, b.rb_time, b.rb_customerid, b.rb_customername, b.rb_address, b.rb_gstno, c.ct_name, c.ct_address, c.ct_gstin, d.name, d.statecode');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->join('ub_customers c', 'c.ct_cstomerid=b.rb_customerid', 'left');
        $this->db->join('ub_states d', 'd.id=b.rb_state', 'left');
        $this->db->where('a.rbs_buid', $buid);
        
        $this->db->where('DATE(b.rb_date) >=', $fromdate);
        $this->db->where('DATE(b.rb_date) <=', $todate);
        $this->db->where('b.rb_isreturn', 1);
        $this->db->where('b.rb_isactive', 0);
        $this->db->where('(a.rbs_type = 0 OR a.rbs_type = 1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('((c.ct_type = 0 AND b.rb_customerid != 0) OR (b.rb_customerid = 0 AND b.rb_gstno=""))');
        $this->db->order_by('a.rbs_retailbillslaveid', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gettotalsalecount($productid)
    {
        $this->db->select('SUM(a.rbs_qty) as totqty');
        $this->db->from('ub_retailbillslave a');
        $this->db->join('ub_retailbillmaster b', 'b.rb_retailbillid=a.rbs_retailbillid', 'left');
        $this->db->where('a.rbs_productid', $productid);
        $this->db->where('(a.rbs_type=0 OR a.rbs_type=1 OR a.rbs_type = 7 OR a.rbs_type = 8)');
        $this->db->where('b.rb_isreturn', 0);
        $this->db->where('b.rb_isactive', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->totqty;
        }else{
            return 0;
        }
    }
    public function deleteoldsaleitems($billid)
    {
        $this->db->where('rbs_retailbillid', $billid);
        $this->db->delete('ub_retailbillslave');
    }
    public function insert_batch($value = '')
    {
        $this->db->insert_batch($this->_table, $value);
    }

}
?>