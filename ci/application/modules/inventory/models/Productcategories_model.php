<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productcategories_model extends MY_Model {

    public $_table               = 'ub_productcategories';
    public $protected_attributes = array('pc_productcategoryid');
    public $primary_key          = 'pc_productcategoryid';

    public $selectedfields = 'pc_productcategoryid, pc_categoryname, pc_description, pc_issub, pc_maincategoryid, pc_isactive';

    public function getallrows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_israwmaterial', 0);
        $this->db->order_by('pc_productcategoryid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getactiverows($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_isactive', 0);
        $this->db->where('pc_israwmaterial', 0);
        $this->db->order_by('pc_productcategoryid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getrowbyid($id)
    {
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_productcategoryid', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getmaincategories($buid){
    	$this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_issub', 0);
        $this->db->where('pc_isactive', 0);
        $this->db->where('pc_israwmaterial', 0);
        $this->db->order_by('pc_categoryname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    /************ materials **************/
    public function getactivematerialrows($buid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_isactive', 0);
        $this->db->where('pc_israwmaterial', 1);
        $this->db->order_by('pc_productcategoryid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getmaterialrows($buid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_israwmaterial', 1);
        $this->db->order_by('pc_productcategoryid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getmaterialmaincategories($buid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productcategories');
        $this->db->where('pc_buid', $buid);
        $this->db->where('pc_issub', 0);
        $this->db->where('pc_isactive', 0);
        $this->db->where('pc_israwmaterial', 1);
        $this->db->order_by('pc_categoryname', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}
?>