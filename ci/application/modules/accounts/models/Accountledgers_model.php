<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class accountledgers_model extends MY_Model {

    public $_table               = 'ub_accountledgers';
    public $protected_attributes = array('al_ledgerid');
    public $primary_key          = 'al_ledgerid';

    public $selectedfields = 'al_ledgerid, al_groupid, al_ledger, al_closingbalance, al_description, al_issub, al_mainledgerid, al_isactive, al_isdefault, al_usertype, al_userid';

    public function getaccountallledgers($buid){
        $this->db->select($this->selectedfields . ', b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        //$this->db->where('a.al_buid', $buid);
        $this->db->where('(a.al_buid = "'.$buid.'" OR a.al_isdefault="1")');
        $this->db->order_by('a.al_ledger', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function ledgernamealreadyexist($buid, $ledgername)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_accountledgers');
        $this->db->where('al_ledger', $ledgername);
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getaccountledgersbyids($buid, $ledgridarr)
    {
        $this->db->select($this->selectedfields .', b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        //$this->db->where('a.al_buid', $buid);
        $this->db->where('(a.al_ledgerid IN ('.$ledgridarr. '))');
        $this->db->where('(a.al_buid = "'.$buid.'" OR a.al_isdefault="1")');
        $this->db->order_by('a.al_ledger', 'ASC');
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getaccountnotinledgerids($buid, $ledgridarr)
    {
        $this->db->select($this->selectedfields .', b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        //$this->db->where('a.al_buid', $buid);
        $this->db->where('(a.al_ledgerid NOT IN ('.$ledgridarr. '))');
        $this->db->where('(a.al_buid = "'.$buid.'" OR a.al_isdefault="1")');
        $this->db->order_by('a.al_ledger', 'ASC');
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    public function getaccountprofitlossledgers($buid, $grouparr, $ledgridarr){
        $this->db->select('a.*, b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        //$this->db->where('a.al_buid', $buid);
        $this->db->where('(b.ag_groupid IN ('.$grouparr.') OR a.al_ledgerid IN ('.$ledgridarr. '))');
        $this->db->where('(a.al_buid = "'.$buid.'" OR a.al_isdefault="1")');
        $this->db->order_by('a.al_ledger', 'ASC');
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getaccountledgersbygroupid($buid, $grpid)
    {
        $this->db->select('a.al_ledgerid, a.al_ledger, b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        $this->db->where('(b.ag_groupid="'.$grpid.'" OR (b.ag_issub="1" AND b.ag_maingroupid="'.$grpid.'"))');
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $this->db->order_by('al_ledger', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getaccountmainledgers($buid){
        $this->db->select('a.*, b.ag_group');
        $this->db->from('ub_accountledgers a');
        $this->db->join('ub_accountgroups b', 'b.ag_groupid=a.al_groupid', 'left');
        $this->db->where('(a.al_buid = "'.$buid.'" OR a.al_isdefault="1")');
        $this->db->where('a.al_issub', 0);
        $this->db->order_by('a.al_ledger', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getaccsubledgers($maingrpid)
    {
        $buid = $this->buid;
    	$this->db->select('*');
        $this->db->from('ub_accountledgers');
        $this->db->where('al_mainledgerid', $maingrpid);
        $this->db->where('al_issub', 1);
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $this->db->order_by('al_ledger', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getledgerdetailbyid($buid, $ledgerid)
    {
        $this->db->select('*');
        $this->db->from('ub_accountledgers');
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $this->db->where('al_ledgerid', $ledgerid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function getsupplierledgerid($buid, $suppid)
    {
        $this->db->select('al_ledgerid');
        $this->db->from('ub_accountledgers');
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $this->db->where('al_usertype', 2);
        $this->db->where('al_userid', $suppid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getcustomerledgerid($buid, $custid)
    {
        $this->db->select('al_ledgerid');
        $this->db->from('ub_accountledgers');
        $this->db->where('(al_buid = "'.$buid.'" OR al_isdefault="1")');
        $this->db->where('al_usertype', 1);
        $this->db->where('al_userid', $custid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }
    public function getaccountledgerdetbyid($ledgrid)
    {
        $this->db->select($this->selectedfields);
        $this->db->from('ub_accountledgers');
        $this->db->where('al_ledgerid', $ledgrid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

}
?>