<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class productionsettings_model extends MY_Model {

    public $_table               = 'ub_productionsettings';
    public $protected_attributes = array('ps_productionsettingid');
    public $primary_key          = 'ps_productionsettingid';

    public $selectedfields = 'ps_productionsettingid, ps_productionprefix, ps_isactive';

    public function getproductionsettings($buid) {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_productionsettings');
        $this->db->where('ps_buid', $buid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}