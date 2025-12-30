<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class deliverynotemaster_model extends MY_Model {

    public $_table               = 'ub_deliverynotemaster';
    public $protected_attributes = array('dn_deliverynoteid');
    public $primary_key          = 'dn_deliverynoteid';

    public $selectedfields = 'dn_deliverynoteid, dn_billprefix, dn_billno, dn_date, dn_time, dn_existcustomer, dn_customerid, dn_customername, dn_phone, dn_address, dn_gstno, dn_placeofsupply, dn_vehicleno, dn_shippingaddress, dn_salesperson, dn_state, dn_totalamount, dn_freight, dn_grandtotal, dn_pagesize, dn_notes, dn_addedby, dn_addedon';

    public function getdeliverynotedetailsbyid($billid)
    {
        $this->db->select($this->selectedfields . ', b.ct_name, b.ct_phone, b.ct_balanceamount, c.name, c.statecode');
        $this->db->from('ub_deliverynotemaster a');
        $this->db->join('ub_customers b', 'b.ct_cstomerid=a.dn_customerid', 'left');
        $this->db->join('ub_states c', 'c.id=a.dn_state', 'left');
        $this->db->where('a.dn_deliverynoteid', $billid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getnextretailbillno($buid)
    {
        $this->db->select('dn_billno');
        $this->db->from('ub_deliverynotemaster');
        $this->db->where('dn_buid', $buid);
        $this->db->order_by('dn_billno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->dn_billno + 1;
        }else{
            return 1;
        }
    }
    public function getallrows($buid)
    {
    	$this->db->select($this->selectedfields . ', b.ct_name, b.ct_phone, b.ct_balanceamount, c.name, c.statecode');
        $this->db->from('ub_deliverynotemaster a');
        $this->db->join('ub_customers b', 'b.ct_cstomerid=a.dn_customerid', 'left');
        $this->db->join('ub_states c', 'c.id=a.dn_state', 'left');
        $this->db->where('a.dn_buid', $buid);
        $this->db->where('a.dn_isreturn', 0);
        $this->db->order_by('a.dn_deliverynoteid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getdeliverynotelist($buid, $complete, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields . ', b.ct_name, b.ct_phone, b.ct_balanceamount, c.name, c.statecode');
        $this->db->from('ub_deliverynotemaster a');
        $this->db->join('ub_customers b', 'b.ct_cstomerid=a.dn_customerid', 'left');
        $this->db->join('ub_states c', 'c.id=a.dn_state', 'left');
        $this->db->where('a.dn_buid', $buid);
        $this->db->where('a.dn_date >=', $fromdate);
        $this->db->where('a.dn_date <=', $todate);
        $this->db->where('a.dn_isreturn', $complete);
        $this->db->order_by('a.dn_deliverynoteid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}