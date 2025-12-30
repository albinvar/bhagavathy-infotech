<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class godowns_model extends MY_Model {

    public $_table               = 'ub_godowns';
    public $protected_attributes = array('gd_godownid');
    public $primary_key          = 'gd_godownid';

    public $selectedfields = 'gd_godownid, gd_godowncode, gd_godownname, gd_address, gd_racknumbers, gd_isgatepass, gd_description, gd_isactive';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_godowns');
        $this->db->where('gd_buid', $buid);
        $this->db->order_by('gd_godownid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getallrowsbytype($buid, $type)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_godowns');
        $this->db->where('gd_buid', $buid);
        $this->db->where('gd_isdepartment', $type);
        $this->db->order_by('gd_godownid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_godowns');
        $this->db->where('gd_buid', $buid);
        $this->db->where('gd_isactive', 0);
        $this->db->order_by('gd_godownid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getgodowntransferto($buid, $fromid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_godowns');
        $this->db->where('gd_buid', $buid);
        $this->db->where('gd_godownid !=', $fromid);
        $this->db->where('gd_isactive', 0);
        $this->db->order_by('gd_godownid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getrowbyid($id)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_godowns');
        $this->db->where('gd_godownid', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
}