<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Serviceregister_model extends MY_Model {

    public $_table               = 'ub_serviceregister';
    public $protected_attributes = array('sr_id');
    public $primary_key          = 'sr_id';

    public $selectedfields = 'sr_id, sr_buid, sr_finyearid, sr_code, sr_indate, sr_intime, sr_existcustomer, sr_customerid, sr_customername, sr_phone, sr_address, sr_printername, sr_printertype, sr_serialno, sr_reason, sr_status, sr_outdate, sr_outtime, sr_remarks, sr_servicecost, sr_updatedby, sr_updatedon, sr_isactive';

    /**
     * Get next service register code
     * Format: SR-XXXX (e.g., SR-0001, SR-0002)
     */
    public function getnextservicecode($buid)
    {
        $this->db->select('sr_code');
        $this->db->from('ub_serviceregister');
        $this->db->where('sr_buid', $buid);
        $this->db->order_by('sr_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            // Extract number from code like "SR-0001"
            $lastnum = intval(str_replace('SR-', '', $row->sr_code));
            $nextnum = $lastnum + 1;
        } else {
            $nextnum = 1;
        }

        return 'SR-' . str_pad($nextnum, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get service register details by ID
     */
    public function getdetailsbyid($id)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_serviceregister');
        $this->db->where('sr_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    /**
     * Get service register list with filters
     */
    public function getserviceregisterlist($buid, $fromdate, $todate, $status = 'all', $customerid = 0)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_serviceregister');
        $this->db->where('sr_buid', $buid);
        $this->db->where('sr_isactive', 0);
        $this->db->where('DATE(sr_indate) >=', $fromdate);
        $this->db->where('DATE(sr_indate) <=', $todate);

        if ($status !== 'all') {
            $this->db->where('sr_status', $status);
        }

        if ($customerid > 0) {
            $this->db->where('sr_customerid', $customerid);
        }

        $this->db->order_by('sr_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    /**
     * Get pending/in-progress items (not yet delivered)
     */
    public function getpendingitems($buid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_serviceregister');
        $this->db->where('sr_buid', $buid);
        $this->db->where('sr_isactive', 0);
        $this->db->where_in('sr_status', array(0, 1, 2)); // Pending, In Progress, Completed
        $this->db->order_by('sr_indate', 'asc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    /**
     * Update service status
     */
    public function updatestatus($id, $status, $userid)
    {
        $data = array(
            'sr_status' => $status,
            'sr_updatedby' => $userid,
            'sr_updatedon' => date('Y-m-d H:i:s')
        );

        // If delivered, set out date
        if ($status == 3) {
            $data['sr_outdate'] = date('Y-m-d');
            $data['sr_outtime'] = date('H:i:s');
        }

        return $this->update($id, $data, TRUE);
    }

    /**
     * Mark as delivered (OUT)
     */
    public function markdelivered($id, $data)
    {
        $data['sr_status'] = 3;
        $data['sr_outdate'] = date('Y-m-d');
        $data['sr_outtime'] = date('H:i:s');

        return $this->update($id, $data, TRUE);
    }

    /**
     * Get count by status
     */
    public function getcountbystatus($buid, $status)
    {
        $this->db->where('sr_buid', $buid);
        $this->db->where('sr_isactive', 0);
        $this->db->where('sr_status', $status);
        return $this->db->count_all_results('ub_serviceregister');
    }

    /**
     * Search by code
     */
    public function searchbycode($buid, $code)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_serviceregister');
        $this->db->where('sr_buid', $buid);
        $this->db->where('sr_isactive', 0);
        $this->db->like('sr_code', $code);
        $this->db->order_by('sr_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
}
