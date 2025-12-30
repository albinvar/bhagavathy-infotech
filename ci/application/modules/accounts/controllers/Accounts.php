<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('accounts/accountprofile_model', 'accprfle');
        $this->load->model('accounts/accountmaingroups_model', 'accmaingrp');
        $this->load->model('accounts/accountgroups_model', 'accgrp');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        
        $this->load->model('accounts/journalentry_model', 'jrnlmdl');
    }

    public function changepublicbuid()
    {
        $bunitid = $this->input->post('id');
        $this->session->set_userdata('buid', $bunitid);

        $this->load->model('business/financialyears_model', 'fnyr');

        $finyeardetails = $this->fnyr->getcurrentfinancialyear($bunitid);
        $this->session->set_userdata('finyearid', $finyeardetails->ay_financialyearid);

        $this->session->set_userdata('finstartdate', $finyeardetails->ay_startdate);
        $this->session->set_userdata('finenddate', $finyeardetails->ay_enddate);
        $this->session->set_userdata('finname', $finyeardetails->ay_financialname);
    }
    
    public function profiles()
    {
        $this->data['title'] = "Business Units";
        $this->data['businessunits'] = $this->busunt->getbusinessunitdetailbyid($this->buid);
        $this->load->template('profiles', $this->data, FALSE);
    }

    public function accountprofileupdate($buid)
    {
        $this->data['buid'] = $buid;
        $this->load->model('Country_model', 'cuntry');

        $this->data['countries'] = $this->cuntry->getalldata();
        $this->data['businessdet'] = $businessdet = $this->busunt->getbusinessunitdetails($buid);
        if($businessdet)
        {
            if($businessdet->bu_country != "")
            {
                $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);
            }else{
                $this->data['states'] = $this->cuntry->getstatelist('101');
            }
        }else{
            $this->data['states'] = $this->cuntry->getstatelist('101');
        }

        $this->load->template('addaccountprofile', $this->data, FALSE);
    }
    public function getcountrystatesajax()
    {
        $this->load->model('Country_model', 'cuntry');
        $countryid = $this->input->post('countryid');

        $states = $this->cuntry->getstatelist($countryid);
        echo json_encode($states);
    }
    public function updateaccountprofiledetails()
    {
        $buid  = $this->input->post('buid');
        $accproid  = $this->input->post('accproid');
        $unitname  = $this->input->post('unitname');
        $country  = $this->input->post('country');
        $state = $this->input->post('state');
        $unitaddress  = $this->input->post('unitaddress');
        $gstno  = $this->input->post('gstno');
        $otherlicence  = $this->input->post('otherlicence');
        $financialyear  = $this->input->post('financialyear');
        $startfinancialyear  = date('Y-m-d', strtotime($this->input->post('startfinancialyear')));
        $endfinancialyear  = date('Y-m-d', strtotime($this->input->post('endfinancialyear')));
        $transcationstart  = date('Y-m-d', strtotime($this->input->post('transcationstart')));
        $upd = array(
            'bu_unitname' => $unitname,
            'bu_address'  => $unitaddress,
            'bu_country'  => $country,
            'bu_state'    => $state,
            'bu_gstnumber' => $gstno
        );
        $update = $this->busunt->update($buid, $upd, TRUE);

        if(isset($_FILES["unitlogo"]["name"]))
        {
            $target_dir1  = "uploads/business/";
            $temp1        = explode(".", $_FILES["unitlogo"]["name"]);
            $filenameup   = @round(microtime(true)) . '.' . end($temp1);
            $target_file1 = $target_dir1 . $filenameup;
            if (move_uploaded_file($_FILES["unitlogo"]["tmp_name"], $target_file1)) {
                $unitimage = $filenameup;

                $updacc = array(
                    'bu_logo'   => $unitimage,
                );
                $updateimg = $this->busunt->update($buid, $updacc, TRUE);
            }
        }

        if($accproid == "")
        {
            $update = $this->accprfle->insert([
                'ap_businessunitid'  => $buid,
                'ap_country'   => $country,
                'ap_state' => $state,
                'ap_gstno' => $gstno,
                'ap_otherlicenceno' => $otherlicence,
                'ap_financialyearname' => $financialyear,
                'ap_startdate' => $startfinancialyear,
                'ap_enddate' => $endfinancialyear,
                'ap_transcationstartdate' => $transcationstart,
                'ap_updatedon' => $this->updatedon,
                'ap_updatedby' => $this->loggeduserid
            ], TRUE);
        }else{
            $updacc = array(
                'ap_country'   => $country,
                'ap_state' => $state,
                'ap_gstno' => $gstno,
                'ap_otherlicenceno' => $otherlicence,
                'ap_financialyearname' => $financialyear,
                'ap_startdate' => $startfinancialyear,
                'ap_enddate' => $endfinancialyear,
                'ap_transcationstartdate' => $transcationstart,
                'ap_updatedon' => $this->updatedon,
                'ap_updatedby' => $this->loggeduserid
            );
            $update = $this->accprfle->update($accproid, $updacc, TRUE);
        }

        if($update)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('accounts/profiles');
    }

    public function accountprofileview($buid)
    {
        $this->data['buid'] = $buid;
        $this->load->model('Country_model', 'cuntry');

        $this->data['countries'] = $this->cuntry->getalldata();
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetails($buid);

        $this->load->template('accountprofileview', $this->data, FALSE);
    }

    public function accountgroups()
    {
        $this->data['title'] = "Account Groups";
        $this->data['buid'] = $this->buid;
        $this->data['accprimarygroups'] = $this->accmaingrp->getallrows();
        $this->data['accountgroups'] = $this->accgrp->getaccountmaingroups($this->buid);
        $this->load->template('accountgroups', $this->data, FALSE);
    }
    public function addingaccgroup()
    {
        $buid = $this->input->post('buid');
        $issubgroup = $this->input->post('issubgroup');

        if($issubgroup == 1)
        {
            $maingroupid = $this->input->post('maingroupid');
            $getprimaryfrpdet = $this->accgrp->getrowbyid($maingroupid);
            $primarygroupid = $getprimaryfrpdet->ag_accmain;
        }
        else{
            $maingroupid = 0;
            $primarygroupid = $this->input->post('primarygroupid');
        }

        $groupname = $this->input->post('groupname');
        $description = $this->input->post('description');

        $alreadyexist = $this->accgrp->accountgroupalreadyexists($this->buid, $groupname);

        if(!$alreadyexist)
        {
            $update = $this->accgrp->insert([
                'ag_buid'  => $buid,
                'ag_accmain' => $primarygroupid,
                'ag_group'   => $groupname,
                'ag_issub' => $issubgroup,
                'ag_maingroupid' => $maingroupid,
                'ag_description' => $description,
                'ag_updatedon' => $this->updatedon,
                'ag_updatedby' => $this->loggeduserid
            ], TRUE);

            if($update)
            {
                $this->session->set_flashdata('messageS', lang('record_added_success'));
            }
            else{
                $this->session->set_flashdata('messageE', lang('oops_error'));
            }
        }else{
            $this->session->set_flashdata('messageE', 'Account group name already exists.');
        }
        redirect('accounts/accountgroups/'.$buid);
    }

    public function accountledger()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['title'] = "Account Ledger";
        $this->data['buid'] = $this->buid;
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);
        $this->data['mainledgers'] = $this->accldgr->getaccountmainledgers($this->buid);
        $this->data['accountgroups'] = $this->accgrp->getallativeaccountroups($this->buid);
        $this->load->template('accountledger', $this->data, FALSE);
    }
    public function addingaccledger()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        
        $buid = $this->input->post('buid');
        $issubgroup = $this->input->post('issubgroup');

        if($issubgroup == 1)
        {
            $mainledgerid = $this->input->post('mainledgerid');
            $getmaindetail = $this->accldgr->getledgerdetailbyid($this->buid, $mainledgerid);
            $accgroupid = $getmaindetail->al_groupid;
        }
        else{
            $mainledgerid = 0;
            $accgroupid = $this->input->post('accgroupid');
        }
        

        $ledgername = $this->input->post('ledgername');
        $description = $this->input->post('description');
        $debicredit = $this->input->post('debicredit');
        $openingbalance = $this->input->post('openingbalance');

        $ledgercheck = $this->accldgr->ledgernamealreadyexist($buid, $ledgername);
        if(!$ledgercheck)
        {
            $update = $this->accldgr->insert([
                'al_buid'  => $buid,
                'al_groupid'   => $accgroupid,
                'al_ledger' => $ledgername,
                'al_closingbalance' => $openingbalance,
                'al_issub' => $issubgroup,
                'al_mainledgerid' => $mainledgerid,
                'al_description' => $description,
                'al_updatedon' => $this->updatedon,
                'al_updatedby' => $this->loggeduserid
            ], TRUE);
            $ledgid = $this->db->insert_id();

            if($update)
            {
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $buid,
                    'le_finyearid' =>$this->finyearid,
                    'le_ledgerid' => $ledgid,
                    'le_amount' => $openingbalance,
                    'le_isdebit' => $debicredit,
                    'le_date' => $this->updatedon,
                    'le_note' => $description,
                    'le_closingamount' => $openingbalance,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
                
                $this->session->set_flashdata('messageS', lang('record_added_success'));
            }
            else{
                $this->session->set_flashdata('messageE', lang('oops_error'));
            }
        }else{
            $this->session->set_flashdata('messageE', 'Ledger already exists, please try another name.');
        }
        redirect('accounts/accountledger/'.$buid);
    }

    public function addingledgeropeningbalance()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        
        $ledgerid = $this->input->post('ledgerid');
        $debicredit = $this->input->post('debicredit');
        $openingbalance = $this->input->post('openingbalance');
        $description = $this->input->post('description');

        $insrt = $this->ldgrentr->insert([
            'le_buid' => $this->buid,
            'le_finyearid' =>$this->finyearid,
            'le_ledgerid' => $ledgerid,
            'le_amount' => $openingbalance,
            'le_isdebit' => $debicredit,
            'le_date' => $this->updatedon,
            'le_note' => $description,
            'le_closingamount' => $openingbalance,
            'le_updatedby' => $this->loggeduserid,
            'le_updatedon' => $this->updatedon
        ], TRUE);

        if($insrt)
        {
            $settleentry = $this->accldgr->update_status_by([
                                'al_ledgerid' => $ledgerid
                            ], [
                                'al_closingbalance' => $openingbalance,
                            ]);

            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
             $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('accounts/accountledger');
    }

    public function ledgerentries($ldgrid, $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['ledgerid'] = $ldgrid;
        $this->data['ledgerdet'] = $this->accldgr->getledgerdetailbyid($this->buid, $ldgrid);

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $totaldebitamnt = $this->ldgrentr->gettotalsumledgerbydate($ldgrid, $fromdate, 0);
        $totalcreditamnt = $this->ldgrentr->gettotalsumledgerbydate($ldgrid, $fromdate, 1);

        $this->data['openingbalance'] = $totaldebitamnt - $totalcreditamnt;

        $this->data['ledgerentrie'] = $this->ldgrentr->getfullledgerentrydetails($ldgrid, $fromdate, $todate);

        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('printledgerentries',$this->data, FALSE);
        }else{
            $this->load->template('ledgerentries', $this->data, FALSE);
        }
    }

    public function ledgerflowstatement($ldgrid, $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['ledgerid'] = $ldgrid;
        $this->data['ledgerdet'] = $this->accldgr->getledgerdetailbyid($this->buid, $ldgrid);

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d');
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $totaldebitamnt = $this->ldgrentr->gettotalsumledgerbydate($ldgrid, $fromdate, 0);
        $totalcreditamnt = $this->ldgrentr->gettotalsumledgerbydate($ldgrid, $fromdate, 1);

        $this->data['openingbalance'] = $totaldebitamnt - $totalcreditamnt;

        $this->data['ledgerentrie'] = $this->ldgrentr->getfullledgerentrydetails($ldgrid, $fromdate, $todate);

        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('printledgerflowstatement',$this->data, FALSE);
        }else{
            $this->load->template('ledgerflowstatement', $this->data, FALSE);
        }
    }

    public function accountjournals()
    {
        $this->data['title'] = "Account Journals";
        $this->data['buid'] = $this->buid;
        $this->data['journals'] = $this->jrnlmdl->getalljournals($this->buid, 0);
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);

        $this->data['mainledgers'] = $this->accldgr->getaccountmainledgers($this->buid);
        $this->data['accountgroups'] = $this->accgrp->getallativeaccountroups($this->buid);
        $this->load->template('accountjournals', $this->data, FALSE);
    }
    public function addjournal($buid)
    {
        $this->data['buid'] = $buid;
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($buid);

        $lastjrnlno = $this->jrnlmdl->getlastjournalno($buid, 0);
        if($lastjrnlno)
        {
            $this->data['jrnalno'] = $lastjrnlno->je_journalnumber + 1;
        }else{
            $this->data['jrnalno'] = 1;
        }
        $this->load->template('addjournal', $this->data, FALSE);
    }

    public function addjournalprocess()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('business/suppliers_model', 'splr');
        $buid = $this->input->post('buid');
        $journalno = $this->input->post('journalno');

        $jounaldatedate = $this->input->post('jounaldatedate');
        $ledgerid = $this->input->post('ledgerid');
        $description = $this->input->post('description');
        $debitamount = $this->input->post('debitamount');
        $creditamount = $this->input->post('creditamount');

        $totaldebit = $this->input->post('totaldebit');
        $totalcredit = $this->input->post('totalcredit');

        $notes = $this->input->post('notes');
        $submit = $this->input->post('submit');

        $albumpathfolder = 'uploads/journals';
        create_directory($albumpathfolder);

        $attachfile = "";

        $date = date('Y-m-d H:i:s');

        if (!empty($_FILES['journalfile']['name'])) {
            $config = array(
                'upload_path'   => $albumpathfolder,
                /*'allowed_types' => 'jpg|gif|png|jpeg|JPG|JPEG|PNG|Jpg|Png|Jpeg',*/
                'overwrite'     => false,
                'max_size'      => '10240',
            );
            $this->load->library('upload', $config);
            $salt                = random_string('alnum', 5);
            $fileName            = date('ymdhis') . '_' . $salt;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('journalfile')) {
                $albummodel_image = $this->upload->data();
                $attachfile     = $albummodel_image['file_name'];

            }

        }

        $insertdata = $this->jrnlmdl->insert(
            array(
                'je_buid'           => $this->buid,
                'je_finyearid'      => $this->finyearid,
                'je_journalnumber'  => $journalno,
                'je_date'           => $date,
                'je_amount'         => $totaldebit,
                'je_crediamount'    => $totalcredit,
                'je_debitamount'    => $totaldebit,
                'je_description'    => $notes,
                'je_file'           => $attachfile,
                'je_status'         => $submit,
                'je_updatedon'      => $this->updatedon,
                'je_updatedby'      => $this->loggeduserid,
            ), true
        );
        $idupd = $this->db->insert_id();

        if($insertdata)
        {
            $k=0;
            foreach($jounaldatedate as $journaldatevl)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($buid, $ledgerid[$k]);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }

                if($debitamount[$k] != "")
                {
                    $isdebit = 0;
                    $amount = $debitamount[$k];
                    $lastclosing = $closamnt+$amount;
                }else{
                    $isdebit = 1;
                    $amount = $creditamount[$k];
                    $lastclosing = $closamnt-$amount;
                }

                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $ledgerid[$k],
                    'le_amount' => $amount,
                    'le_isdebit' => $isdebit,
                    'le_journalid' => $idupd,
                    'le_date' => date('Y-m-d H:i:s', strtotime($journaldatevl)),
                    'le_note' => $description[$k],
                    'le_closingamount' => $lastclosing,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon,
                    'le_ispublish' => $submit
                ], TRUE);

                $ledgrdet = $this->accldgr->getaccountledgerdetbyid($ledgerid[$k]);
                if($ledgrdet)
                {
                    $userid = $ledgrdet->al_userid;
                    if($ledgrdet->al_usertype == 1)
                    {
                        if($userid != "")
                        {
                            $custdet = $this->cstmr->getcustomerbalance($userid);
                            if($custdet)
                            {
                                if($debitamount[$k] != "")
                                {
                                    $balanceamnt = $custdet->ct_balanceamount - $debitamount[$k];
                                }else{
                                    $balanceamnt = $custdet->ct_balanceamount + $creditamount[$k];
                                }
                                $updateoldbalance = $this->cstmr->update_status_by([
                                    'ct_cstomerid' => $userid
                                ], [
                                    'ct_balanceamount' => $balanceamnt
                                ]);
                            }
                        }
                        
                    }else if($ledgrdet->al_usertype == 2)
                    {
                        if($userid != "")
                        {
                            $suppdet = $this->splr->getsupplierbalance($userid);
                            if($suppdet)
                            {
                                if($debitamount[$k] != "")
                                {
                                    $balanceamnt = $suppdet->sp_balanceamount - $debitamount[$k];
                                }else{
                                    $balanceamnt = $suppdet->sp_balanceamount + $creditamount[$k];
                                }
                                $updateoldbalance = $this->splr->update_status_by([
                                    'sp_supplierid' => $userid
                                ], [
                                    'sp_balanceamount' => $balanceamnt
                                ]);
                            }
                        }
                    }
                }

                $k++;
            }
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('accounts/accountjournals/'.$buid);
    }
    public function publishjournal($journalid, $buid, $type=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        
        $dsbledary = $this->jrnlmdl->update($journalid, ['je_status' => 0], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {

            $settleentry = $this->ldgrentr->update_status_by([
                                'le_buid' => $buid,
                                'le_journalid' => $journalid
                            ], [
                                'le_ispublish' => 0
                            ]);

            $this->session->set_flashdata('messageS', 'Journal published successfully.');
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        if($type == 0)
        {
            redirect('accounts/accountjournals/'.$buid);
        }
        else{
            redirect('accounts/vouchers/'.$buid.'/'.$type);
        }
    }

    public function getjournaldetails()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');

        $journalid = $this->input->post('journalid');

        $this->data['journaldet'] = $this->jrnlmdl->getjournaldetailsbyid($journalid);
        $this->data['ledgerdet'] = $this->ldgrentr->getjournalledgers($journalid);

        $this->load->view('ajaxjournalview', $this->data);
    }

    public function vouchers($vouchertype)
    {
        $this->data['title'] = "Account Vouchers";
        $this->data['buid'] = $this->buid;
        $this->data['vouchertype'] = $vouchertype;
        if($vouchertype == 1)
        {
            $this->data['vouchername'] = 'Payment Vouchers';
        }else if($vouchertype == 2)
        {
            $this->data['vouchername'] = 'Receiver Vouchers';
        }else if($vouchertype == 3)
        {
            $this->data['vouchername'] = 'Contra Vouchers';
        }else if($vouchertype == 4)
        {
            $this->data['vouchername'] = 'Journal Vouchers';
        }else{
            $this->data['vouchername'] = 'Other Vouchers';
        }
        $this->data['vouchers'] = $this->jrnlmdl->getalljournals($this->buid, 1, $vouchertype);
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);

        $this->data['mainledgers'] = $this->accldgr->getaccountmainledgers($this->buid);
        $this->load->template('accountvouchers', $this->data, FALSE);
    }
    public function addvoucher($vouchertype)
    {
        $this->data['buid'] = $this->buid;
        $this->data['vouchertype'] = $vouchertype;

        $ledgridarr = '3,4';

        if($vouchertype == 1)
        {
            $this->data['vouchername'] = 'Add Payment Voucher';
            
            $this->data['drledgers'] = $this->accldgr->getaccountledgersbyids($this->buid, $ledgridarr);
            $this->data['crledgers'] = $this->accldgr->getaccountnotinledgerids($this->buid, $ledgridarr);
        }else if($vouchertype == 2)
        {
            $this->data['vouchername'] = 'Add Receiver Voucher';

            $this->data['drledgers'] = $this->accldgr->getaccountnotinledgerids($this->buid, $ledgridarr);
            $this->data['crledgers'] = $this->accldgr->getaccountledgersbyids($this->buid, $ledgridarr);
        }else if($vouchertype == 3)
        {
            $this->data['vouchername'] = 'Add Contra Voucher';
            $this->data['drledgers'] = $this->accldgr->getaccountledgersbyids($this->buid, $ledgridarr);
            $this->data['crledgers'] = $this->accldgr->getaccountledgersbyids($this->buid, $ledgridarr);
        }else if($vouchertype == 4)
        {
            $this->data['drledgers'] = $this->accldgr->getaccountallledgers($this->buid);
            $this->data['crledgers'] = $this->accldgr->getaccountallledgers($this->buid);
            $this->data['vouchername'] = 'Add Journal Voucher';
        }else{
            $this->data['drledgers'] = $this->accldgr->getaccountallledgers($this->buid);
            $this->data['crledgers'] = $this->accldgr->getaccountallledgers($this->buid);
            $this->data['vouchername'] = 'Add Other Voucher';
        }

        
        $lastvouchrno = $this->jrnlmdl->getlastjournalno($this->buid, 1, $vouchertype);
        if($lastvouchrno)
        {
            $this->data['vouchrno'] = $lastvouchrno->je_journalnumber + 1;
        }else{
            $this->data['vouchrno'] = 1;
        }
        $this->load->template('addvoucher', $this->data, FALSE);
    }


    public function addvoucherprocess()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('business/suppliers_model', 'splr');
        $buid = $this->input->post('buid');
        $voucherno = $this->input->post('voucherno');
        $vouchertype = $this->input->post('vouchertype');

        $voucherdate = date('Y-m-d', strtotime($this->input->post('voucherdate')));
        $vouchertime = date('H:i:s', strtotime($this->input->post('vouchertime')));

        $voucherdatetime = $voucherdate . " " . $vouchertime;

        $totaldebit = $this->input->post('totaldebit');
        $totalcredit = $this->input->post('totalcredit');
        $totalamnt = $this->input->post('totalamount');

        $notes = $this->input->post('notes');
        $submit = $this->input->post('submit');

        $albumpathfolder = 'uploads/journals';
        create_directory($albumpathfolder);

        $attachfile = "";

        $date = date('Y-m-d H:i:s');

        if (!empty($_FILES['journalfile']['name'])) {
            $config = array(
                'upload_path'   => $albumpathfolder,
                /*'allowed_types' => 'jpg|gif|png|jpeg|JPG|JPEG|PNG|Jpg|Png|Jpeg',*/
                'overwrite'     => false,
                'max_size'      => '10240',
            );
            $this->load->library('upload', $config);
            $salt                = random_string('alnum', 5);
            $fileName            = date('ymdhis') . '_' . $salt;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('journalfile')) {
                $albummodel_image = $this->upload->data();
                $attachfile     = $albummodel_image['file_name'];
            }
        }

        $insertdata = $this->jrnlmdl->insert(
            array(
                'je_buid'           => $this->buid,
                'je_finyearid'      => $this->finyearid,
                'je_type'           => 1,
                'je_vouchertype'    => $vouchertype,
                'je_journalnumber'  => $voucherno,
                'je_date'           => $voucherdatetime,
                'je_amount'         => $totalamnt,
                'je_crediamount'    => $totalcredit,
                'je_debitamount'    => $totaldebit,
                'je_description'    => $notes,
                'je_file'           => $attachfile,
                'je_status'         => $submit,
                'je_updatedon'      => $this->updatedon,
                'je_updatedby'      => $this->loggeduserid,
            ), true
        );
        $idupd = $this->db->insert_id();

        if($insertdata)
        {
            $k=0;

            $isdebit = $this->input->post('isdebit');
            $ledgerid = $this->input->post('ledgerid');
            $description = $this->input->post('description');
            $amount = $this->input->post('amount');

            $lk=0;
            foreach($ledgerid as $ledgvl)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($buid, $ledgvl);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                if($isdebit[$lk] == 0)
                {
                    $lastclosing = $closamnt+$debitamount;
                }else{
                    $lastclosing = $closamnt-$debitamount;
                }
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $ledgvl,
                    'le_amount' => $amount[$lk],
                    'le_isdebit' => $isdebit[$lk],
                    'le_journalid' => $idupd,
                    'le_date' => $voucherdatetime,
                    'le_note' => $description[$lk],
                    'le_closingamount' => $lastclosing,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon,
                    'le_ispublish' => $submit
                ], TRUE);

                $ledgrdet = $this->accldgr->getaccountledgerdetbyid($ledgvl);
                if($ledgrdet)
                {
                    $userid = $ledgrdet->al_userid;
                    if($ledgrdet->al_usertype == 1)
                    {
                        if($userid != "")
                        {
                            $custdet = $this->cstmr->getcustomerbalance($userid);
                            if($custdet)
                            {
                                if($isdebit[$lk] == 0)
                                {
                                    $balanceamnt = $custdet->ct_balanceamount - $amount[$lk];
                                }else{
                                    $balanceamnt = $custdet->ct_balanceamount + $amount[$lk];
                                }
                                $updateoldbalance = $this->cstmr->update_status_by([
                                    'ct_cstomerid' => $userid
                                ], [
                                    'ct_balanceamount' => $balanceamnt
                                ]);
                            }
                        }
                        
                    }else if($ledgrdet->al_usertype == 2)
                    {
                        if($userid != "")
                        {
                            $suppdet = $this->splr->getsupplierbalance($userid);
                            if($suppdet)
                            {
                                if($isdebit[$lk] == 0)
                                {
                                    $balanceamnt = $suppdet->sp_balanceamount - $amount[$lk];
                                }else{
                                    $balanceamnt = $suppdet->sp_balanceamount + $amount[$lk];
                                }
                                $updateoldbalance = $this->splr->update_status_by([
                                    'sp_supplierid' => $userid
                                ], [
                                    'sp_balanceamount' => $balanceamnt
                                ]);
                            }
                        }
                    }
                }
                $lk++;
            }
            
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('accounts/vouchers/'.$vouchertype);
    }

    public function getvoucherdetails()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');

        $journalid = $this->input->post('journalid');

        $this->data['journaldet'] = $this->jrnlmdl->getjournaldetailsbyid($journalid);
        $this->data['ledgerdet'] = $this->ldgrentr->getjournalledgers($journalid);

        $this->load->view('ajaxvoucherview', $this->data);
    }
    public function printvoucher($journalid)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['journaldet'] = $this->jrnlmdl->getjournaldetailsbyid($journalid);
        $this->data['ledgerdet'] = $this->ldgrentr->getjournalledgers($journalid);
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->load->view('printvoucher', $this->data);
    }

    public function trialbalance()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        if($this->input->post('filterbtn'))
        {
            $this->data['fromdate'] = date('Y-m-d', strtotime($this->input->post('fromdate')));
            $this->data['todate'] = date('Y-m-d', strtotime($this->input->post('todate')));
        }else{
            $this->data['fromdate'] = date('Y-m-d');
            $this->data['todate'] = date('Y-m-d');
        }
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);
        $this->load->template('trialbalance', $this->data, FALSE);
    }
    public function trialbalanceprint($fromdate, $todate)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);
        $this->load->view('trialbalanceprint', $this->data, FALSE);
    }
    public function daybook()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        if($this->input->post('filterbtn'))
        {
            $this->data['ledgerid'] = $ledgerid = $this->input->post('ledgerid');
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($this->input->post('fromdate')));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($this->input->post('todate')));
        }else{
            $this->data['ledgerid'] = $ledgerid = 0;
            $this->data['fromdate'] = $fromdate = date('Y-m-d');
            $this->data['todate'] = $todate = date('Y-m-d');
        }
        $this->data['ledgers'] = $this->accldgr->getaccountallledgers($this->buid);

        $this->data['ledgerentries'] = $this->ldgrentr->getdaybookentries($this->buid, $ledgerid, $fromdate, $todate);
        $this->load->template('daybook', $this->data, FALSE);
    }
    public function daybookprint($ledgerid, $fromdate, $todate)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['ledgerid'] = $ledgerid;
        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;

        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['ledgerentries'] = $this->ldgrentr->getdaybookentries($this->buid, $ledgerid, $fromdate, $todate);
        $this->load->view('daybookprint', $this->data, FALSE);
    }

    public function profitandlossaccount($print=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $drarr = '10,12';
        $drledgrarr = '5';
        $crarr = '11,13';
        $crrledgrarr = '1';
        $this->data['drledgers'] = $this->accldgr->getaccountprofitlossledgers($this->buid, $drarr, $drledgrarr);
        $this->data['crledgers'] = $this->accldgr->getaccountprofitlossledgers($this->buid, $crarr, $crrledgrarr);

        //$this->data['ledgerentries'] = $this->ldgrentr->getdaybookentries($this->buid, $this->finyearid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('profitandlossaccountprint', $this->data, FALSE);
        }else{
            $this->load->template('profitandlossaccount', $this->data, FALSE);
        }
        
    }
    public function balancesheet($print=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->data['title'] = "Balance Sheet";

        $this->data['branchledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 1);
        $this->data['capitalledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 2);
        $this->data['currntassetledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 3);
        $this->data['currntliabiltyledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 4);
        $this->data['fixedasstledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 5);
        $this->data['investmntledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 6);
        $this->data['loansledgers'] = $this->accldgr->getaccountledgersbygroupid($this->buid, 7);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('balancesheetprint', $this->data, FALSE);
        }else{
            $this->load->template('balancesheet', $this->data, FALSE);
        }
        
    }

    public function accountsettings()
    {
        $this->data['profdet'] = $this->accprfle->getunitaccountprofile($this->buid);

        $this->load->template('accountsettings', $this->data, FALSE);
    }
    public function updateaccountsettings()
    {
        $accproid = $this->input->post('accproid');
        $showcurrency = $this->input->post('showcurrency');
        $symbolposition = $this->input->post('symbolposition');
        $decimalpoint = $this->input->post('decimalpoint');

        $updacc = array(
            'ap_showcurrency'   => $showcurrency,
            'ap_sufprefixsymbol' => $symbolposition,
            'ap_noofdecimal' => $decimalpoint,
        );
        $update = $this->accprfle->update($accproid, $updacc, TRUE);

        if($update)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }else
        {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('accounts/accountsettings');
    }

}
