<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productionmaterialoperations_model extends MY_Model {

    public $_table               = 'ub_productionmaterialoperations';
    public $protected_attributes = array('pmo_productionoperationid');
    public $primary_key          = 'pmo_productionoperationid';

    public $selectedfields = 'pmo_productionoperationid, pmo_productionid, pmo_operationid, pmo_cost, pmo_timetaken, pmo_comments, pmo_operationstarttime, pmo_expectedendtime, pmo_operationendtime, pmo_isfinished, pmo_finishedcost, pmo_finishedcomments, pmo_isactive';

    public function getproductionoperations($productionid)
    {
    	$this->db->select($this->selectedfields .', b.po_operation, b.po_description, b.po_isexternal');
        $this->db->from('ub_productionmaterialoperations a');
        $this->db->join('ub_productionoperations b', 'b.po_operationid=a.pmo_operationid', 'left');
        $this->db->where('a.pmo_productionid', $productionid);
        $this->db->order_by('a.pmo_productionoperationid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}
?>