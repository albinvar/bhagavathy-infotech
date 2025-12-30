<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ledgerentries_model extends MY_Model {

    public $_table               = 'ub_ledgerentries';
    public $protected_attributes = array('le_ledgerentryid');
    public $primary_key          = 'le_ledgerentryid';

    public function getlastledgerentry($buid, $ledgerid)
    {
    	$this->db->select('le_ledgerentryid, le_ledgerid, le_amount, le_isdebit, le_journalid, le_date, le_note, le_closingamount, le_isactive, le_ispublish');
        $this->db->from('ub_ledgerentries');
        $this->db->where('le_buid', $buid);
        $this->db->where('le_ledgerid', $ledgerid);
        $this->db->order_by('le_ledgerentryid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }


    public function getledgerentries($ledgerid)
    {
        $buid = $this->buid;

        $this->db->select('*, b.at_name');
        $this->db->from('ub_ledgerentries a');
        $this->db->join('ub_authentication b', 'b.at_authid=a.le_updatedby', 'left');
        $this->db->where('a.le_ledgerid', $ledgerid);
        $this->db->where('a.le_buid', $buid);
        //$this->db->where('a.le_ispublish', 0);
        $this->db->order_by('a.le_ledgerentryid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getcustomerledgerentries($ledgerid, $fromdate, $todate)
    {
        $buid = $this->buid;

        $this->db->select('a.le_date, a.le_amount, a.le_isdebit, a.le_note, b.at_name, c.rb_billingtype, c.rb_billprefix, c.rb_billno, c.rb_grandtotal');
        $this->db->from('ub_ledgerentries a');
        $this->db->join('ub_authentication b', 'b.at_authid=a.le_updatedby', 'left');
        $this->db->join('ub_retailbillmaster c', 'c.rb_retailbillid=a.le_salepurchaseid', 'left');
        $this->db->where('a.le_ledgerid', $ledgerid);
        $this->db->where('a.le_buid', $buid);
        //$this->db->where('a.le_ispublish', 0);
        $this->db->where('DATE(a.le_date) >=', $fromdate);
        $this->db->where('DATE(a.le_date) <=', $todate);
        $this->db->order_by('a.le_ledgerentryid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getfullledgerentrydetails($ledgerid, $fromdate, $todate)
    {
        $buid = $this->buid;

        $this->db->select('a.le_ledgerentryid as firstid, a.le_amount as firstamount, a.le_isdebit as firstdebit, a.le_date as firstdate, a.le_journalid as journalid, a.le_issale, b.le_isdebit as seconddebit, c.al_ledger as secledger, d.at_name');
        $this->db->from('ub_ledgerentries a');
        $this->db->join('ub_ledgerentries b', 'b.le_journalid=a.le_journalid AND b.le_ledgerentryid != a.le_ledgerentryid AND a.le_journalid != 0', 'left');
        $this->db->join('ub_accountledgers c', 'c.al_ledgerid=b.le_ledgerid', 'left');
        $this->db->join('ub_authentication d', 'd.at_authid=a.le_updatedby', 'left');
        $this->db->where('a.le_ledgerid', $ledgerid);
        $this->db->where('a.le_buid', $buid);
        $this->db->where('DATE(a.le_date) >=', $fromdate);
        $this->db->where('DATE(a.le_date) <=', $todate);
        //$this->db->where('a.le_ispublish', 0);
        $this->db->order_by('a.le_ledgerentryid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getjournalledgers($journalid)
    {
        $this->db->select('a.*, b.al_ledger');
        $this->db->from('ub_ledgerentries a');
        $this->db->join('ub_accountledgers b', 'b.al_ledgerid=a.le_ledgerid', 'left');
        $this->db->where('a.le_journalid', $journalid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getdaybookentries($buid, $ledgerid, $fromdate, $todate)
    {
        $this->db->select('a.*, b.al_ledger');
        $this->db->from('ub_ledgerentries a');
        $this->db->join('ub_accountledgers b', 'b.al_ledgerid=a.le_ledgerid', 'left');
        if($ledgerid != 0)
        {
            $this->db->where('a.le_ledgerid', $ledgerid);
        }
        
        $this->db->where('a.le_buid', $buid);
        $this->db->where('DATE(a.le_date) >=', $fromdate);
        $this->db->where('DATE(a.le_date) <=', $todate);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function gettotalsumledgerbydate($ldgrid, $fromdate, $type)
    {
        $buid = $this->buid;

        $this->db->select('SUM(le_amount) as total');
        $this->db->from('ub_ledgerentries');
        $this->db->where('le_ledgerid', $ldgrid);
        $this->db->where('le_buid', $buid);
        $this->db->where('le_isdebit', $type);
        $this->db->where('DATE(le_date) <', $fromdate);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->total;
        }else{
            return 0;
        }
    }
    public function gettotalledgertotalby_type_date($ledgerid, $type, $fromdate, $todate, $buid)
    {
        $this->db->select('SUM(le_amount) as total');
        $this->db->from('ub_ledgerentries');
        $this->db->where('le_ledgerid', $ledgerid);
        $this->db->where('le_buid', $buid);
        $this->db->where('le_isdebit', $type);
        $this->db->where('DATE(le_date) >=', $fromdate);
        $this->db->where('DATE(le_date) <=', $todate);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->total;
        }else{
            return 0;
        }
    }
    public function gettotalledgertotalby_type_finyear($ledgerid, $type, $finyear, $buid)
    {
        $this->db->select('SUM(le_amount) as total');
        $this->db->from('ub_ledgerentries');
        $this->db->where('le_ledgerid', $ledgerid);
        $this->db->where('le_buid', $buid);
        $this->db->where('le_isdebit', $type);
        $this->db->where('le_finyearid', $finyear);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->total;
        }else{
            return 0;
        }
    }

    public function deleteoldpurchaseledgers($purchaseid)
    {
        $this->db->where('le_salepurchaseid', $purchaseid);
        $this->db->where('le_issale', 2);
        $this->db->delete('ub_ledgerentries');
    }
    public function deleteoldsaleledgers($billid)
    {
        $this->db->where('le_salepurchaseid', $billid);
        $this->db->where('le_issale', 1);
        $this->db->delete('ub_ledgerentries');
    }
}