<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class stocktransfermaster_model extends MY_Model {

    public $_table               = 'ub_stocktransfermaster';
    public $protected_attributes = array('st_stocktransferid');
    public $primary_key          = 'st_stocktransferid';

    public $selectedfields = 'st_stocktransferid, st_fromid, st_toid, st_totalamount, st_updatedon, st_updatedby, st_isactive';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields . ", b.gd_godowncode as fromcode, b.gd_godownname as fromname, c.gd_godowncode as tocode, c.gd_godownname as toname");
        $this->db->from('ub_stocktransfermaster a');
        $this->db->join('ub_godowns b', 'b.gd_godownid=a.st_fromid', 'left');
        $this->db->join('ub_godowns c', 'c.gd_godownid=a.st_toid', 'left');
        $this->db->where('a.st_buid', $buid);
        $this->db->order_by('a.st_stocktransferid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getalltranfersfromtodate($buid, $fromdate, $todate)
    {
        $this->db->select($this->selectedfields . ", b.gd_godowncode as fromcode, b.gd_godownname as fromname, c.gd_godowncode as tocode, c.gd_godownname as toname");
        $this->db->from('ub_stocktransfermaster a');
        $this->db->join('ub_godowns b', 'b.gd_godownid=a.st_fromid', 'left');
        $this->db->join('ub_godowns c', 'c.gd_godownid=a.st_toid', 'left');
        $this->db->where('a.st_buid', $buid);
        $this->db->where('DATE(a.st_updatedon) >=', $fromdate);
        $this->db->where('DATE(a.st_updatedon) <=', $todate);
        $this->db->order_by('a.st_stocktransferid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

}
?>