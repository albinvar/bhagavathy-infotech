<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class billprintsettings_model extends MY_Model {
    public $_table               = 'ub_billprintsettings';
    public $protected_attributes = array('bp_printsettingid');
    public $primary_key          = 'bp_printsettingid';

    private $select_fields = 'bp_printsettingid, bp_billdesign, bp_retailprefix, bp_wholesaleprefix, bp_proformaprefix, bp_wholesaleproformaprefix, bp_quotationprefix, bp_wholesalequotationprefix, bp_servicebillprefix, bp_purchasebillprefix, bp_purchaseorderprefix, bp_defaultpagesize, bp_remarkcolumn, bp_hidepurchaseprice, bp_hidevehiclenumber, bp_hideewaybillno, bp_hidedeliverydate, bp_hidepodetails, bp_salereturnprefix, bp_purchasereturnprefix, bp_needdupinvoice, bp_needtripinvoice, bp_orderprefix, bp_csaleprefix, bp_dsaleprefix';

    public function getbillprintdetails($buid)
    {
    	$this->db->select($this->select_fields);
		$this->db->from('ub_billprintsettings');
		$this->db->where('bp_buid', $buid);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
    }
}
?>