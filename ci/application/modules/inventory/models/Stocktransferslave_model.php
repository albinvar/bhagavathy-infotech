<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class stocktransferslave_model extends MY_Model {

    public $_table               = 'ub_stocktransferslave';
    public $protected_attributes = array('sts_transferslaveid');
    public $primary_key          = 'sts_transferslaveid';

    public $selectedfields = 'sts_transferslaveid, sts_productid, sts_fromstockid, sts_tostickid, sts_qty, sts_mrp, sts_purchaseprice, sts_totalprice, sts_updatedon, sts_updatedby';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_stocktransferslave');
        $this->db->where('sts_buid', $buid);
        $this->db->order_by('sts_transferslaveid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function gettranferproducts($trid){
        $this->db->select($this->selectedfields . ", c.pd_productid, c.pd_productcode, c.pd_productname, c.pd_size, c.pd_brand, c.pd_company");
        $this->db->from('ub_stocktransferslave a');
        $this->db->join('ub_products c', 'c.pd_productid=a.sts_productid', 'left');
        $this->db->where('a.sts_stocktransferid', $trid);
        $this->db->order_by('a.sts_transferslaveid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function insert_batch($value = '')
    {
        $this->db->insert_batch($this->_table, $value);
    }

}
?>