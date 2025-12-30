<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productionmaster_model extends MY_Model {

    public $_table               = 'ub_productionmaster';
    public $protected_attributes = array('pm_productionid');
    public $primary_key          = 'pm_productionid';

    public $selectedfields = 'pm_productionid, pm_productionprefix, pm_productionno, pm_productid, pm_enquiryid, pm_godownind, pm_startdate, pm_qty, pm_comments, pm_materialcost, pm_othercosts, pm_totalcost, pm_expectedtime, pm_status, pm_finished, pm_finishedtime, pm_fnishedcomments, pm_operationcost, pm_isactive, pm_deliverynote';

    public function getproductionfulldetailbyid($productionid)
    {
        $this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand, b.pd_purchaseprice, b.pd_mrp, c.pc_categoryname, d.un_unitname, e.en_enquiryprefix, e.en_enquiryno, f.at_name');
        $this->db->from('ub_productionmaster a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pm_productid', 'left');
        $this->db->join('ub_productcategories c', 'c.pc_productcategoryid=b.pd_categoryid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->join('ub_crmenquiries e', 'e.en_enquiryid=a.pm_enquiryid', 'left');
        $this->db->join('ub_authentication f', 'f.at_authid=a.pm_addedby', 'left');
        $this->db->where('a.pm_productionid', $productionid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getproductiondetailbyid($productionid)
    {
        $this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand, c.pc_categoryname, d.un_unitname');
        $this->db->from('ub_productionmaster a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pm_productid', 'left');
        $this->db->join('ub_productcategories c', 'c.pc_productcategoryid=b.pd_categoryid', 'left');
        $this->db->join('ub_units d', 'd.un_unitid=b.pd_unitid', 'left');
        $this->db->where('a.pm_productionid', $productionid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getallrows($buid) {
        $this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand');
        $this->db->from('ub_productionmaster a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pm_productid', 'left');
        $this->db->where('a.pm_buid', $buid);
        $this->db->order_by('a.pm_productionid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductionhistory($buid, $finished)
    {
        $this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage, b.pd_size, b.pd_brand, c.po_operation');
        $this->db->from('ub_productionmaster a');
        $this->db->join('ub_products b', 'b.pd_productid=a.pm_productid', 'left');
        $this->db->join('ub_productionoperations c', 'c.po_operationid=a.pm_status', 'left');
        $this->db->where('a.pm_buid', $buid);
        $this->db->where('a.pm_finished', $finished);
        $this->db->order_by('a.pm_productionid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getproductioncount($buid, $status)
    {
        $this->db->select('pm_productionid');
        $this->db->from('ub_productionmaster');
        $this->db->where('pm_buid', $buid);
        $this->db->where('pm_finished', $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getnextproductionnumber($buid)
    {
        $this->db->select('pm_productionno');
        $this->db->from('ub_productionmaster');
        $this->db->where('pm_buid', $buid);
        $this->db->order_by('pm_productionno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $purdet = $query->row();
            return $purdet->pm_productionno + 1;
        }else{
            return 1;
        }
    }
}
?>