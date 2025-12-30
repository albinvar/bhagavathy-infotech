<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Purchasemaster_model extends MY_Model {

    public $_table               = 'ub_purchasemaster';
    public $protected_attributes = array('pm_purchaseid');
    public $primary_key          = 'pm_purchaseid';

    public $selectedfields = 'pm_purchaseid, pm_purchaseprefix, pm_purchaseno, pm_date, pm_time, pm_type, pm_supplierid, pm_vehicleno, pm_invoiceno, pm_expecteddelivery, pm_discount, pm_freight, pm_totalamount, pm_oldbalance, pm_paidamount, pm_grandtotal, pm_balanceamount, pm_paymentmethod, pm_purchasenote, pm_totalgstamount, pm_returnedon, pm_partialreturn, pm_returnamount, pm_returncomments, pm_invoicedate, pm_freightgst, pm_freigtgstamnt, pm_roundoffvalue, pm_postatus, pm_godownid';

    public function getpurchasedetailsbyid($purchaseid)
    {
    	$this->db->select($this->selectedfields . ', b.sp_name, b.sp_contactnumber, b.sp_address, b.sp_mobile, b.sp_gstno, b.sp_state, sp_email, b.sp_contactperson');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_purchaseid', $purchaseid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getpurchasereturndetails($purchaseid)
    {
        $this->db->select($this->selectedfields . ', b.sp_name, b.sp_contactnumber, b.sp_address, b.sp_mobile, b.sp_gstno, b.sp_state, sp_email, b.sp_contactperson');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_returnid', $purchaseid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getpurchaselist($buid, $supplierid, $fromdate, $todate, $type=0, $rawmat=0)
    {
    	$this->db->select($this->selectedfields . ', b.sp_name, b.sp_contactnumber, b.sp_mobile');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_buid', $buid);
        if($supplierid != 0)
        {
            $this->db->where('a.pm_supplierid', $supplierid);
        }
        $this->db->where('DATE(a.pm_date) >=', $fromdate);
        $this->db->where('DATE(a.pm_date) <=', $todate);
        $this->db->where('a.pm_type', $type);
        $this->db->where('a.pm_israwmaterial', $rawmat);
        $this->db->where('a.pm_isactive', 0);
        $this->db->order_by('a.pm_purchaseid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getsupplierbillhistory($supplierid, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_purchasemaster');
        
        $this->db->where('pm_supplierid', $supplierid);
        
        $this->db->where('DATE(pm_date) >=', $fromdate);
        $this->db->where('DATE(pm_date) <=', $todate);
        $this->db->where('pm_type', 0);
        $this->db->where('pm_isactive', 0);
        $this->db->order_by('pm_purchaseid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getpurchasetaxlist($buid, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields . ', a.pm_returnid, b.sp_name, b.sp_state');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_buid', $buid);
        
        $this->db->where('DATE(a.pm_date) >=', $fromdate);
        $this->db->where('DATE(a.pm_date) <=', $todate);
        $this->db->where('(a.pm_type=0 OR (a.pm_type=2 AND a.pm_partialreturn=0))');
        $this->db->where('a.pm_isactive', 0);
        $this->db->order_by('a.pm_purchaseid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getpurchasereturnlist($buid, $supplierid, $fromdate, $todate, $rawmat=0)
    {
        $this->db->select($this->selectedfields . ', b.sp_name, b.sp_contactnumber, b.sp_mobile');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_buid', $buid);
        if($supplierid != 0)
        {
            $this->db->where('a.pm_supplierid', $supplierid);
        }
        $this->db->where('DATE(a.pm_date) >=', $fromdate);
        $this->db->where('DATE(a.pm_date) <=', $todate);
        $this->db->where('a.pm_type', 2);
        $this->db->where('a.pm_israwmaterial', $rawmat);
        $this->db->where('a.pm_isactive', 0);
        $this->db->order_by('a.pm_purchaseid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getpurchaseorderlist($buid, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields . ', b.sp_name, b.sp_contactnumber, b.sp_mobile');
        $this->db->from('ub_purchasemaster a');
        $this->db->join('ub_suppliers b', 'b.sp_supplierid=a.pm_supplierid', 'left');
        $this->db->where('a.pm_buid', $buid);
        $this->db->where('DATE(a.pm_date) >=', $fromdate);
        $this->db->where('DATE(a.pm_date) <=', $todate);
        $this->db->where('a.pm_type', 1);
        $this->db->where('a.pm_isactive', 0);
        $this->db->order_by('a.pm_purchaseid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getnextpurchasebillno($buid, $type)
    {
        $this->db->select('pm_purchaseno');
        $this->db->from('ub_purchasemaster');
        $this->db->where('pm_buid', $buid);
        $this->db->where('pm_type', $type);
        $this->db->order_by('pm_purchaseid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->pm_purchaseno + 1;
        }else{
            return 1;
        }
    }

    public function getpurchasecountbydate($buid, $date)
    {
        $this->db->select('pm_purchaseno');
        $this->db->from('ub_purchasemaster');
        $this->db->where('pm_buid', $buid);
        $this->db->where('pm_date', $date);
        $this->db->where('pm_type', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getpurchasecountbyfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('pm_purchaseno');
        $this->db->from('ub_purchasemaster');
        $this->db->where('pm_buid', $buid);
        $this->db->where('DATE(pm_date) >=', $fromdate);
        $this->db->where('DATE(pm_date) <=', $todate);
        $this->db->where('pm_type', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getpurchasetotalbyfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select('SUM(pm_grandtotal) as grandtotal, SUM(pm_totalgstamount) as purchtotgst');
        $this->db->from('ub_purchasemaster');
        $this->db->where('pm_buid', $buid);
        $this->db->where('DATE(pm_date) >=', $fromdate);
        $this->db->where('DATE(pm_date) <=', $todate);
        $this->db->where('pm_type', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return FALSE;
        }
    }
}
?>