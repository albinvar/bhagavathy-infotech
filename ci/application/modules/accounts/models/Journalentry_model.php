<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class journalentry_model extends MY_Model {

    public $_table               = 'ub_journalentry';
    public $protected_attributes = array('je_journalentryid');
    public $primary_key          = 'je_journalentryid';

    public function getalljournals($buid, $type, $vouchertype=0)
    {
    	$this->db->select('a.*, b.at_name');
        $this->db->from('ub_journalentry a');
        $this->db->join('ub_authentication b', 'b.at_authid=a.je_updatedby', 'left');
        $this->db->where('a.je_buid', $buid);
        $this->db->where('a.je_type', $type);
        if($vouchertype != 0)
        {
            $this->db->where('a.je_vouchertype', $vouchertype);
        }
        $this->db->order_by('a.je_journalentryid', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getjournaldetailsbyid($journalid)
    {
        $this->db->select('a.*, b.at_name');
        $this->db->from('ub_journalentry a');
        $this->db->join('ub_authentication b', 'b.at_authid=a.je_updatedby', 'left');
        $this->db->where('a.je_journalentryid', $journalid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getlastjournalno($buid, $type, $vouchertype=0)
    {
        $this->db->select('je_journalnumber');
        $this->db->from('ub_journalentry');
        $this->db->where('je_buid', $buid);
        $this->db->where('je_type', $type);
        if($vouchertype != 0)
        {
            $this->db->where('je_vouchertype', $vouchertype);
        }
        $this->db->order_by('je_journalentryid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
}

?>