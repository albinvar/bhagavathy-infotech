<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class businessunit_model extends MY_Model {

    public $_table               = 'ub_businessunit';
    public $protected_attributes = array('bu_businessunitid');
    public $primary_key          = 'bu_businessunitid';

    public function getallrows() {
        $this->db->select('a.*, b.bs_name, c.bt_businesstype');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_business b', 'b.bs_businessid=a.bu_businessid', 'left');
        $this->db->join('ub_businesstypes c', 'c.bt_businesstypeid=a.bu_businesstypeid', 'left');
        $this->db->order_by('a.bu_businessunitid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows($businesid){
        $this->db->select('a.*,  b.bt_businesstype, c.*, d.currency_symbol');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_businesstypes b', 'b.bt_businesstypeid=a.bu_businesstypeid', 'left');
        $this->db->join('ub_accountprofile c', 'c.ap_businessunitid=a.bu_businessunitid', 'left');
        $this->db->join('ub_countries d', 'd.id=c.ap_country', 'left');
        $this->db->where('a.bu_businessid', $businesid);
        $this->db->where('a.bu_withoutlogin', 0);
        $this->db->where('a.bu_isactive', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getuseractivebuints($businesid, $userid){
        $this->db->select('a.bu_businessunitid, a.bu_businesstypeid, a.bu_unitname, a.bu_logo, a.bu_address, a.bu_email, a.bu_phone, a.bu_gstnumber, a.bu_currencyid, a.bu_withoutlogin, a.bu_composittax, a.bu_isvat, b.*, d.currency_symbol');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_accountprofile b', 'b.ap_businessunitid=a.bu_businessunitid', 'left');
        $this->db->join('ub_authentication c', 'FIND_IN_SET(a.bu_businessunitid, c.at_unitids) != 0', 'left');
        $this->db->join('ub_countries d', 'd.id=b.ap_country', 'left');
        $this->db->where('a.bu_businessid', $businesid);
        $this->db->where('c.at_authid', $userid);
        $this->db->where('a.bu_isactive', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getbusinessunitdetails($businesunitid){
        $this->db->select('*, d.currency_symbol');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_businesstypes b', 'b.bt_businesstypeid=a.bu_businesstypeid', 'left');
        $this->db->join('ub_accountprofile c', 'c.ap_businessunitid=a.bu_businessunitid', 'left');
        $this->db->join('ub_countries d', 'd.id=c.ap_country', 'left');
        $this->db->where('a.bu_businessunitid', $businesunitid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getbusinessunitdetailbyid($businesunitid){
        $this->db->select('a.*, d.bs_name, b.bt_businesstype, c.*');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_business d', 'd.bs_businessid=a.bu_businessid', 'left');
        $this->db->join('ub_businesstypes b', 'b.bt_businesstypeid=a.bu_businesstypeid', 'left');
        $this->db->join('ub_accountprofile c', 'c.ap_businessunitid=a.bu_businessunitid', 'left');
        $this->db->where('a.bu_businessunitid', $businesunitid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getprintbusinessunitdetails($businesunitid)
    {
        $this->db->select('a.*, b.name, b.statecode');
        $this->db->from('ub_businessunit a');
        $this->db->join('ub_states b', 'b.id=a.bu_state', 'left');
        $this->db->where('a.bu_businessunitid', $businesunitid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
?>