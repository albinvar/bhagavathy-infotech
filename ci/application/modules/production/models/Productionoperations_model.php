<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productionoperations_model extends MY_Model {

    public $_table               = 'ub_productionoperations';
    public $protected_attributes = array('po_operationid');
    public $primary_key          = 'po_operationid';

    public $selectedfields = 'po_operationid, po_operation, po_description, po_isexternal, po_isactive, po_updatedon, po_priority';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productionoperations');
        $this->db->where('po_buid', $buid);
        $this->db->order_by('po_priority', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productionoperations');
        $this->db->where('po_buid', $buid);
        $this->db->where('po_isactive', 0);
        $this->db->order_by('po_priority', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getrowbyid($id)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_productionoperations');
        $this->db->where('po_operationid', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
}
?>