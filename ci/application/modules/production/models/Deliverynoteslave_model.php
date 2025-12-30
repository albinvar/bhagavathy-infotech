<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class deliverynoteslave_model extends MY_Model {

    public $_table               = 'ub_deliverynoteslave';
    public $protected_attributes = array('dns_deliverynoteslaveid');
    public $primary_key          = 'dns_deliverynoteslaveid';

    public $selectedfields = 'dns_deliverynoteslaveid, dns_retailbillid, dns_productid, dns_hsnno, dns_mrp, dns_qty, dns_totalamount, dns_updatedby, dns_updatedon, dns_isactive';

    public function getdeliverynoteproducts($billid)
    {
        $this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage');
        $this->db->from('ub_deliverynoteslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.dns_productid', 'left');
        $this->db->where('a.dns_retailbillid', $billid);
        //$this->db->order_by('a.dns_deliverynoteslaveid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getallrows($buid)
    {
    	$this->db->select($this->selectedfields . ', b.pd_productcode, b.pd_productname, b.pd_hsnno, b.pd_prodimage');
        $this->db->from('ub_deliverynoteslave a');
        $this->db->join('ub_products b', 'b.pd_productid=a.dns_productid', 'left');
        $this->db->where('a.dns_buid', $buid);
        //$this->db->order_by('a.dns_deliverynoteslaveid', 'desc');
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