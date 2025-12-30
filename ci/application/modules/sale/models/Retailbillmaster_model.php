<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Retailbillmaster_model extends MY_Model {

    public $_table               = 'ub_retailbillmaster';
    public $protected_attributes = array('rb_retailbillid');
    public $primary_key          = 'rb_retailbillid';

    public $selectedfields = 'rb_retailbillid, rb_billprefix, rb_billno, rb_billingtype, rb_date, rb_time, rb_existcustomer, rb_customerid, rb_customername, rb_phone, rb_address, rb_gstno, rb_placeofsupply, rb_vehicleno, rb_salesperson, rb_salephone, rb_shippingaddress, rb_state, rb_billtype, rb_totalamount, rb_discount, rb_totalgstamnt, rb_freight, rb_grandtotal, rb_oldbalance, rb_balanceamount, rb_paidamount, rb_paymentmethod, rb_totprofit, rb_advance100, rb_pagesize, rb_notes, rb_addedby, rb_addedon, rb_isactive, rb_roundoffvalue, rb_partialreturn, rb_orderstatus, rb_ewaybillno, rb_deliverydate, rb_ponumber, rb_podate, rb_returnedon, rb_returncomment, rb_returnamount, rb_godownid';

    public function getretailbilldetailsbyid($purchaseid)
    {
    	$this->db->select($this->selectedfields . ", b.ct_name, b.ct_phone, b.ct_balanceamount, c.name, c.statecode, d.at_name");
        $this->db->from('ub_retailbillmaster a');
        $this->db->join('ub_customers b', 'b.ct_cstomerid=a.rb_customerid', 'left');
        $this->db->join('ub_states c', 'c.id=a.rb_state', 'left');
        $this->db->join('ub_authentication d', 'd.at_authid=a.rb_salesperson', 'left');
        $this->db->where('a.rb_retailbillid', $purchaseid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function checkalreadyexistbillno($buid, $billno)
    {
        $this->db->select("rb_retailbillid");
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('rb_billno', $billno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getsalereturndetails($saleid)
    {
        $this->db->select($this->selectedfields . ", b.ct_name, b.ct_balanceamount, c.name, c.statecode");
        $this->db->from('ub_retailbillmaster a');
        $this->db->join('ub_customers b', 'b.ct_cstomerid=a.rb_customerid', 'left');
        $this->db->join('ub_states c', 'c.id=a.rb_state', 'left');
        $this->db->where('a.rb_returnid', $saleid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getretailbilllist($buid, $type, $fromdate, $todate)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster a');
        $this->db->where('a.rb_buid', $buid);
        if($type != 'all')
        {
            $this->db->where('a.rb_billingtype', $type);
        }else{
            $this->db->where('(a.rb_billingtype=0 OR a.rb_billingtype=1 OR a.rb_billingtype=7 OR a.rb_billingtype=8)');
        }
        $this->db->where('DATE(a.rb_date) >=', $fromdate);
        $this->db->where('DATE(a.rb_date) <=', $todate);
        $this->db->where('a.rb_isactive', 0);
        $this->db->where('a.rb_isreturn', 0);
        $this->db->order_by('a.rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getneworderlist($buid, $ordertype, $salesperson, $customer, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster a');
        $this->db->where('a.rb_buid', $buid);

        if($ordertype == 0)
        {
            $this->db->where('a.rb_billingtype', 6);
            $this->db->where('a.rb_orderstatus', 0);
        }
        else if($ordertype == 1){
            $this->db->where('a.rb_billingtype', 6);
            $this->db->where('a.rb_orderstatus', 1);
        }else if($ordertype == 2){
            $this->db->where('a.rb_billingtype', 6);
            $this->db->where('a.rb_orderstatus', 2);
        }


        if($salesperson != 'all')
        {
            $this->db->where('a.rb_salesperson', $salesperson);
        }

        if($customer != 'all')
        {
            if($customer == '0')
            {
                $this->db->where('a.rb_customerid', 0);
            }else{
                $this->db->where('a.rb_customerid', $customer);
            }
            
        }
        
        $this->db->where('DATE(a.rb_date) >=', $fromdate);
        $this->db->where('DATE(a.rb_date) <=', $todate);
        $this->db->where('a.rb_isactive', 0);
        $this->db->where('a.rb_isreturn', 0);
        $this->db->order_by('a.rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getretailbillhistoryfilter($buid, $type, $godownid, $salesperson, $customer, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster a');
        $this->db->where('a.rb_buid', $buid);
        if($type != 'all')
        {
            $this->db->where('a.rb_billingtype', $type);
        }else{
            $this->db->where('(a.rb_billingtype=0 OR a.rb_billingtype=1 OR a.rb_billingtype=7 OR a.rb_billingtype=8)');
        }

        if($salesperson != 'all')
        {
            $this->db->where('a.rb_salesperson', $salesperson);
        }

        if($customer != 'all')
        {
            if($customer == '0')
            {
                $this->db->where('a.rb_customerid', 0);
            }else{
                $this->db->where('a.rb_customerid', $customer);
            }
            
        }

        if($godownid != '0')
        {
            $this->db->where('a.rb_godownid', $godownid);
        }

        $this->db->where('DATE(a.rb_date) >=', $fromdate);
        $this->db->where('DATE(a.rb_date) <=', $todate);
        $this->db->where('a.rb_isactive', 0);
        $this->db->where('a.rb_isreturn', 0);
        $this->db->order_by('a.rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getsalebillhistoryfilterforapi($buid, $salesperson, $customer, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster a');
        $this->db->where('a.rb_buid', $buid);
        
        $this->db->where('(a.rb_billingtype=0 OR a.rb_billingtype=1 OR a.rb_billingtype=7 OR a.rb_billingtype=8)');
        
        if($salesperson != 'all')
        {
            $this->db->where('a.rb_salesperson', $salesperson);
        }

        if($customer != 'all')
        {
            if($customer == '0')
            {
                $this->db->where('a.rb_customerid', 0);
            }else{
                $this->db->where('a.rb_customerid', $customer);
            }
            
        }
       
        $this->db->where('DATE(a.rb_date) >=', $fromdate);
        $this->db->where('DATE(a.rb_date) <=', $todate);
        $this->db->where('a.rb_isactive', 0);
        $this->db->where('a.rb_isreturn', 0);
        $this->db->order_by('a.rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getsalereturnlist($buid, $type, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster a');
        $this->db->where('a.rb_buid', $buid);
        if($type != '5')
        {
            $this->db->where('a.rb_billingtype', $type);
        }
        $this->db->where('DATE(a.rb_date) >=', $fromdate);
        $this->db->where('DATE(a.rb_date) <=', $todate);
        $this->db->where('a.rb_isactive', 0);
        $this->db->where('a.rb_isreturn', 1);
        $this->db->order_by('a.rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getcustomerbillhistory($customerid, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_customerid', $customerid);
        $this->db->where('DATE(rb_date) >=', $fromdate);
        $this->db->where('DATE(rb_date) <=', $todate);
        $this->db->where('rb_isactive', 0);
        $this->db->where('rb_isreturn', 0);
        $this->db->order_by('rb_retailbillid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getnextretailbillno($buid, $type)
    {
        $this->db->select('rb_billno');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('rb_billingtype', $type);
        $this->db->where('rb_isreturn', 0);
        $this->db->order_by('rb_billno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->rb_billno + 1;
        }else{
            return 1;
        }
    }

    public function getsalecountbydate($buid, $date)
    {
        $this->db->select('rb_billno');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('rb_date', $date);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        return$query->num_rows();
    }
    public function getsalecountbyuseriddate($buid, $userid, $date)
    {
        $this->db->select('rb_billno');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('rb_date', $date);
        $this->db->where('rb_salesperson', $userid);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        return$query->num_rows();
    }
    public function getsalecountbyfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('rb_billno');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('date(rb_date) >=', $fromdate);
        $this->db->where('date(rb_date) <=', $todate);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getsaletotalbyfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('SUM(rb_grandtotal) as grandtotal, SUM(rb_totalgstamnt) as tottalgst, SUM(rb_totprofit) as totprofit');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('date(rb_date) >=', $fromdate);
        $this->db->where('date(rb_date) <=', $todate);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return FALSE;
        }
    }
    public function getsaleamountbyuseriddate($buid, $userid, $date)
    {
        $this->db->select('SUM(rb_grandtotal) as grandtotal, SUM(rb_totalgstamnt) as tottalgst, SUM(rb_totprofit) as totprofit, SUM(rb_paidamount) as totpaidamount');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('date(rb_date)', $date);
        $this->db->where('rb_salesperson', $userid);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return FALSE;
        }
    }
    public function getsaleprofitbydate($buid, $date)
    {
        $this->db->select('SUM(rb_totprofit) as totprofit');
        $this->db->from('ub_retailbillmaster');
        $this->db->where('rb_buid', $buid);
        $this->db->where('rb_date', $date);
        $this->db->where('rb_isreturn', 0);
        $this->db->where('(rb_billingtype = 0 OR rb_billingtype = 1 OR rb_billingtype=7 OR rb_billingtype=8)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->totprofit;
        }else{
            return 0;
        }
    }

}
?>