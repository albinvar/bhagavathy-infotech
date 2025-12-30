<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Business extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
    }

    public function dashboard() {
        $this->load->model('business/suppliers_model', 'splr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('purchase/Purchasemaster_model', 'purmstr');
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');

        $this->data['suppcnt'] = $this->splr->getactivesuppliercount($this->buid);
        $this->data['suppblance'] = $this->splr->getactivesupplierbalance($this->buid);
        $this->data['custcnt'] = $this->cstmr->getactivecustomercount($this->buid);
        $this->data['custblance'] = $this->cstmr->getactivecustomerbalance($this->buid);
        $todaydate = date('Y-m-d');
        $this->data['purchasecnt'] = $this->purmstr->getpurchasecountbydate($this->buid, $todaydate);
        $this->data['salecnt'] = $this->retlmstr->getsalecountbydate($this->buid, $todaydate);

        $this->data['prdctcnt'] = $this->prdtmdl->getactiveproductcount($this->buid);
        $this->data['prdctoutstockcnt'] = $this->prdtmdl->getproductoutofstockcount($this->buid);
        $this->data['title'] = "Business Dashboard";
        $this->load->template('dashboard', $this->data, FALSE);
    }
    public function businessalalyticview($fromdate=0, $todate=0)
    {
        $this->load->model('purchase/Purchasemaster_model', 'purmstr');
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d');
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['purchasecnt'] = $this->purmstr->getpurchasecountbyfromtodate($this->buid, $fromdate, $todate);
        $this->data['salecnt'] = $this->retlmstr->getsalecountbyfromtodate($this->buid, $fromdate, $todate);

        $this->data['profitdet'] = $this->retlslv->getprofittotalbyfromtodate($this->buid, $fromdate, $todate);

        $this->data['fastitems'] = $this->retlslv->getfastmovingitemsfromtodate($this->buid, $fromdate, $todate);
        $this->data['slowitems'] = $this->retlslv->getslowmovingitemsfromtodate($this->buid, $fromdate, $todate);
        $this->data['notsaleitems'] = $this->retlslv->getnotsaleitemsfromtodate($this->buid, $fromdate, $todate);

        $this->data['bankdebit'] = $this->ldgrentr->gettotalledgertotalby_type_date(3, 0, $fromdate, $todate, $this->buid);
        $this->data['bankcredit'] = $this->ldgrentr->gettotalledgertotalby_type_date(3, 1, $fromdate, $todate, $this->buid);

        $this->data['cashdebit'] = $this->ldgrentr->gettotalledgertotalby_type_date(4, 0, $fromdate, $todate, $this->buid);
        $this->data['cashcredit'] = $this->ldgrentr->gettotalledgertotalby_type_date(4, 1, $fromdate, $todate, $this->buid);
        

        $this->data['saledet'] = $this->retlmstr->getsaletotalbyfromtodate($this->buid, $fromdate, $todate);
        $this->data['purdet'] = $this->purmstr->getpurchasetotalbyfromtodate($this->buid, $fromdate, $todate);

        $this->data['title'] = "Business Analytics";
        $this->load->template('businessalalyticview', $this->data, FALSE);
    }

    public function updateprofile()
    {
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetails($this->buid);
        $this->load->template('updateprofile', $this->data, FALSE);
    }
    public function updatebusinessunitprofile()
    {
        $buid = $this->buid;
        $unitname  = $this->input->post('unitname');
        $unitaddress  = $this->input->post('unitaddress');
        $phone  = $this->input->post('phone');
        $mobile  = $this->input->post('mobile');
        $email  = $this->input->post('email');
        $website  = $this->input->post('website');
        $gstnumber  = $this->input->post('gstnumber');
        $franchisefrom = $this->input->post('franchisefrom');

        $bankname  = $this->input->post('bankname');
        $accountnumber  = $this->input->post('accountnumber');
        $ifsccode  = $this->input->post('ifsccode');
        $branch  = $this->input->post('branch');

        $upd = array(
            'bu_unitname' => $unitname,
            'bu_address'  => $unitaddress,
            'bu_email' => $email,
            'bu_phone' => $phone,
            'bu_mobile' => $mobile,
            'bu_website' => $website,
            'bu_gstnumber' => $gstnumber,
            'bu_bankname' => $bankname,
            'bu_accountnumber' => $accountnumber,
            'bu_ifsccode' => $ifsccode,
            'bu_bankbranch' => $branch,
            'bu_franchisefrom' => $franchisefrom
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

        if(isset($_FILES["companyseal"]["name"]))
        {
            $target_dir1  = "uploads/business/";
            $temp1        = explode(".", $_FILES["companyseal"]["name"]);
            $filenameup   = @round(microtime(true)) . '-frach.' . end($temp1);
            $target_file1 = $target_dir1 . $filenameup;
            if (move_uploaded_file($_FILES["companyseal"]["tmp_name"], $target_file1)) {
                $companyseal = $filenameup;

                $updacc = array(
                    'bu_companyseal' => $companyseal,
                );
                $updateimg = $this->busunt->update($buid, $updacc, TRUE);
            }
        }

        if(isset($_FILES["franchiselogo"]["name"]))
        {
            $target_dir1  = "uploads/business/";
            $temp1        = explode(".", $_FILES["franchiselogo"]["name"]);
            $filenameup   = @round(microtime(true)) . '-frach.' . end($temp1);
            $target_file1 = $target_dir1 . $filenameup;
            if (move_uploaded_file($_FILES["franchiselogo"]["tmp_name"], $target_file1)) {
                $franchiselogo = $filenameup;

                $updacc = array(
                    'bu_franchiselogo' => $franchiselogo,
                );
                $updateimg = $this->busunt->update($buid, $updacc, TRUE);
            }
        }
        
        if($update)
        {   
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/updateprofile');
    }

    public function staff(){
        $this->load->model('admin/businesstypes_model', 'bustyp');
        $this->data['title'] = "Staff List";
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);
        $this->data['staffscnt'] = $this->usersigin->getallbusinessstaffcnt($this->businessid);
        $this->data['staffs'] = $this->usersigin->getallunitstaffs($this->buid);
        $this->load->template('stafflist', $this->data, FALSE);
    }
    public function addstaff($editid=0){
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('Usertype_model', 'usrtp');
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['buunits'] = $this->busunt->getactiverows($this->businessid);
        $this->data['usertypes'] = $this->usrtp->businessusertypes($this->buid);
        $this->data['editid'] = $editid;
        if($editid == 0)
        {
            $this->data['title'] = "Add Staff";
        }
        else{
            $this->data['title'] = "Update Staff";
            $this->data['editdata'] = $editdet = $this->usersigin->getrowbyid($editid);
        }
        $this->load->template('addstaff', $this->data, FALSE);
    }
    public function addstaffprocess()
    {
        $editid = $this->input->post('editid');
        $businessunitid = $this->input->post('businessunitid');
        $usertypeid = $this->input->post('usertypeid');

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $name = $firstname . " " . $lastname;

        $email    = $this->input->post('email');
        $phone    = $this->input->post('phone');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $godownid = $this->input->post('godownid');

        $userpassword = md5($password);

        if($editid == 0)
        {
            $usernamecheck = $this->usersigin->checkusernamealreadyexists($username);
            if(!$usernamecheck)
            {
                $insert_data = $this->usersigin->insert(
                    array(
                        'at_username'    => $username,
                        'at_password'    => $userpassword,
                        'at_name'        => $name,
                        'at_phone'       => $phone,
                        'at_email'       => $email,
                        'at_usertypeid'  => $usertypeid,
                        'at_businessid'  => $this->businessid,
                        'at_unitids'     => $businessunitid,
                        'at_addedon'     => $this->updatedon,
                        'at_addedby'     => $this->loggeduserid,
                        'at_godownid'    => $godownid
                    ), true
                );

                if ($insert_data) {
                    $this->session->set_flashdata('messageS', lang('record_added_success'));
                } else {
                    $this->session->set_flashdata('messageE', lang('oops_error'));
                }
             
            }else{
                 $this->session->set_flashdata('messageE', 'Username already exists, please try another username..');
            }
        }else{
            $updacc = array(
                'at_name'        => $name,
                'at_phone'       => $phone,
                'at_email'       => $email,
                'at_usertypeid'  => $usertypeid,
                'at_unitids'     => $businessunitid,
                'at_godownid'    => $godownid
            );
            $insert_data = $this->usersigin->update($editid, $updacc, TRUE);

            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        
        
        redirect('business/staff');
    }
    public function enabledisablestaff($editid, $action = 0)
    {
        
        $dsbledary = $this->usersigin->update($editid, ['at_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/staff');
    }

    public function businessunits()
    {
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->data['title'] = "Business Units";
        $this->data['businessunits'] = $this->busunt->getactiverows($this->businessid);
        $this->load->template('businessunits', $this->data, FALSE);
    }

    public function suppliers(){
        $this->load->model('business/suppliers_model', 'splr');
        $this->data['title'] = "Supplier List";
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);
        $this->data['suppliers'] = $this->splr->getallsuppliers($this->buid);
        $this->load->template('suppliers', $this->data, FALSE);
    }
    public function supplierpayhistory($suppid, $fromdate=0, $todate=0)
    {
        $this->load->model('business/suppliers_model', 'splr');
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('purchase/Purchasemaster_model', 'purmstr');

        $this->data['supplierid'] = $suppid;

        $this->data['supplierdet'] = $this->splr->getsupplierdetailsbyid($suppid);

        $getsupplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $suppid);
        if($getsupplierledgr)
        {
            $suppledgrid=$getsupplierledgr->al_ledgerid;
        }else{
            $suppledgrid = 0;
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['custledgrs'] = $this->ldgrentr->getcustomerledgerentries($suppledgrid, $fromdate, $todate);
        $this->data['purchasebills'] = $this->purmstr->getsupplierbillhistory($suppid, $fromdate, $todate);

        $this->load->template('supplierpayhistory', $this->data, FALSE);
    }
    public function getstateliststajax()
    {
        $this->load->model('Country_model', 'cuntry');
        $countryid = $this->input->post('countryid');
        $statedistricts =  $this->cuntry->getstatelist($countryid);
        echo json_encode($statedistricts);
    }
    public function addsupplier($editid=0){
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/suppliers_model', 'splr');

        $this->load->model('Country_model', 'cuntry');
        $this->data['editid'] = $editid;
        if($editid == 0)
        {
            $this->data['title'] = "Add Supplier";
            $this->data['states'] = $this->cuntry->getstatelist('101');
        }else{
            $this->data['title'] = "Update Supplier";
            $this->data['editdata'] = $editdet = $this->splr->getsupplierdetailsbyid($editid);
            $this->data['states'] = $this->cuntry->getstatelist($editdet->sp_country);

            $getsuplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $editid);
            if($getsuplierledgr)
            {
                $supledgrid=$getsuplierledgr->al_ledgerid;
            }else{
                $supledgrid = 0;
            }
            $this->data['supledgr'] = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
        }
        $this->data['countries'] = $this->cuntry->getalldata();
        
        $this->load->template('addsupplier', $this->data, FALSE);
    }
    public function addsupplierprocess(){
        $this->load->model('business/suppliers_model', 'splr');
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');

        $editid = $this->input->post('editid');
        $companyname = $this->input->post('companyname');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $phone = $this->input->post('phone');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $website = $this->input->post('website');
        $contactperson = $this->input->post('contactperson');
        $personphone = $this->input->post('personphone');
        $gstnumber = $this->input->post('gstnumber');
        $balanceamnt = $this->input->post('balanceamnt');
        $isledgerentry = $this->input->post('isledgerentry');

        if($editid == 0)
        {
            $insert_data = $this->splr->insert(
                array(
                    'sp_buid'    => $this->buid,
                    'sp_name'    => $companyname,
                    'sp_address'        => $address,
                    'sp_city'       => $city,
                    'sp_state'       => $state,
                    'sp_country'  => $country,
                    'sp_contactnumber' => $phone,
                    'sp_mobile' => $mobile,
                    'sp_email' => $email,
                    'sp_website' => $website,
                    'sp_contactperson' => $contactperson,
                    'sp_contactphone' => $personphone,
                    'sp_gstno' => $gstnumber,
                    'sp_balanceamount' => $balanceamnt,
                    'sp_updatedon'     => $this->updatedon,
                    'sp_updatedby'     => $this->loggeduserid,
                ), true
            );

            $supplierid = $insert_data;
        }else{
            $supplierid = $editid;

            $updacc = array(
                'sp_name'    => $companyname,
                'sp_address'        => $address,
                'sp_city'       => $city,
                'sp_state'       => $state,
                'sp_country'  => $country,
                'sp_contactnumber' => $phone,
                'sp_mobile' => $mobile,
                'sp_email' => $email,
                'sp_website' => $website,
                'sp_contactperson' => $contactperson,
                'sp_contactphone' => $personphone,
                'sp_gstno' => $gstnumber,
                'sp_updatedon'     => $this->updatedon,
                'sp_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->splr->update($editid, $updacc, TRUE);

            if($isledgerentry == 0)
            {
                $updacc = array(
                    'sp_balanceamount' => $balanceamnt,
                );
                $insert_data = $this->splr->update($editid, $updacc, TRUE);
            }
        }
        

        if ($insert_data) {

            if($isledgerentry == 0)
            {
                $update = $this->accldgr->insert([
                    'al_buid'  => $this->buid,
                    'al_groupid'   => 24,
                    'al_ledger' => $companyname,
                    'al_closingbalance' => $balanceamnt,
                    'al_issub' => 0,
                    'al_mainledgerid' => 0,
                    'al_usertype' => 2,
                    'al_userid'   => $supplierid,
                    'al_updatedon' => $this->updatedon,
                    'al_updatedby' => $this->loggeduserid
                ], TRUE);
                $ledgid = $this->db->insert_id();

                if($update)
                {
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $ledgid,
                        'le_amount' => $balanceamnt,
                        'le_isdebit' => 1,
                        'le_date' => $this->updatedon,
                        'le_closingamount' => $balanceamnt,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                    
                }
            }else{
                $getsupplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $supplierid);
                if($getsupplierledgr)
                {
                    $suppledgrid=$getsupplierledgr->al_ledgerid;
                }else{
                    $suppledgrid = 0;
                }

                if($suppledgrid != 0)
                {
                    $updaccldg = array(
                        'al_ledger' => $companyname,
                    );
                    $update_ldgrname = $this->accldgr->update($suppledgrid, $updaccldg, TRUE);
                }
            }

            $this->session->set_flashdata('messageS', lang('record_added_success'));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/suppliers');
    }

    public function getsupplierdetails()
    {
        $this->load->model('business/suppliers_model', 'splr');
        $supplierid = $this->input->post('supplierid');
        $this->data['suplierdet'] = $this->splr->getsupplierdetailsbyid($supplierid);
        $this->load->view('ajaxsupplierview', $this->data);
    }
    public function enabledisablesupplier($editid, $action = 0)
    {
        $this->load->model('business/suppliers_model', 'splr');
        $dsbledary = $this->splr->update($editid, ['sp_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/suppliers');
    }

    public function addingsupplierpayment()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/suppliers_model', 'splr');

        $this->load->model('accounts/journalentry_model', 'jrnlmdl');

        $supplierid = $this->input->post('supplierid');
        $paidamount = $this->input->post('paidamount');
        $supoldbalance = $this->input->post('supoldbalance');
        $paymethod = $this->input->post('paymethod');
        $paynote = $this->input->post('paynote');

        $newbalance = $supoldbalance - $paidamount;

        // Update supplier balance
        $updateoldbalance = $this->splr->update_status_by([
            'sp_supplierid' => $supplierid
        ], [
            'sp_balanceamount' => $newbalance
        ]);

        if($updateoldbalance)
        {
            $lastjrnlno = $this->jrnlmdl->getlastjournalno($buid, 2);
            if($lastjrnlno)
            {
                $jrnalno = $lastjrnlno->je_journalnumber + 1;
            }else{
                $jrnalno = 1;
            }

            //Jouranal entry
            $insertdata = $this->jrnlmdl->insert(
                array(
                    'je_buid'           => $this->buid,
                    'je_finyearid'      => $this->finyearid,
                    'je_journalnumber'  => $jrnalno,
                    'je_date'           => $this->updatedon,
                    'je_amount'         => $paidamount,
                    'je_crediamount'    => $paidamount,
                    'je_debitamount'    => $paidamount,
                    'je_description'    => $paynote,
                    'je_status'         => 0,
                    'je_type'           => 3,
                    'je_updatedon'      => $this->updatedon,
                    'je_updatedby'      => $this->loggeduserid,
                    'je_customerid'     => $supplierid
                ), true
            );
            $idupd = $this->db->insert_id();

            // Account cash/bank ledger
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt-$paidamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => $paymethod,
                'le_journalid' => $idupd,
                'le_amount' => $paidamount,
                'le_isdebit' => 1,
                'le_note' => $paynote,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosing,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            //getsupplier ledgerid
            $getsuplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $supplierid);
            if($getsuplierledgr)
            {
                $supledgrid=$getsuplierledgr->al_ledgerid;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt-$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $supledgrid,
                    'le_journalid' => $idupd,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 0,
                    'le_note' => $paynote,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }

            $this->session->set_flashdata('messageS', 'Successfully submitted payment.');
        }
        else{
            $this->session->set_flashdata('messageE', 'Error occured, please try again');
        }

        redirect('business/suppliers');
    }

    public function customers()
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->data['title'] = "Customer List";
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);
        $this->data['customers'] = $this->cstmr->getallcustomers($this->buid);
        $this->load->template('customers', $this->data, FALSE);
    }
    public function customerpayhistory($custid, $fromdate=0, $todate=0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');

        $this->data['customerid'] = $custid;

        $this->data['customerdet'] = $this->cstmr->getcustomerdetailsbyid($custid);

        $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $custid);
        if($getcustomerledgr)
        {
            $custledgrid=$getcustomerledgr->al_ledgerid;
        }else{
            $custledgrid = 0;
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['custledgrs'] = $this->ldgrentr->getcustomerledgerentries($custledgrid, $fromdate, $todate);
        $this->data['salebills'] = $this->retlmstr->getcustomerbillhistory($custid, $fromdate, $todate);

        $this->load->template('customerpayhistory', $this->data, FALSE);
    }
    public function addcustomer($editid=0)
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('Country_model', 'cuntry');
        $this->data['editid'] = $editid;
        if($editid == 0)
        {
            $this->data['title'] = "Add Customer";
            $this->data['states'] = $this->cuntry->getstatelist('101');
        }else{
            $this->data['title'] = "Edit Customer Details";
            $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $editid);
             if($getcustomerledgr)
            {
                $custledgrid=$getcustomerledgr->al_ledgerid;
            }else{
                $custledgrid = 0;
            }
            $this->data['custledgr'] = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
            $this->data['editdata'] = $editdet = $this->cstmr->getcustomerdetailsbyid($editid);
            $this->data['states'] = $this->cuntry->getstatelist($editdet->ct_country);
        }
        $this->data['countries'] = $this->cuntry->getalldata();
        
        $this->load->template('addcustomer', $this->data, FALSE);
    }
    public function addcustomerprocess()
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');

        $editid = $this->input->post('editid');
        $customername = $this->input->post('customername');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $phone = $this->input->post('phone');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $gstno = $this->input->post('gstno');
        $balanceamnt = $this->input->post('balanceamnt');
        $isledgerentry = $this->input->post('isledgerentry');

        $customertype= $this->input->post('customertype');

        if($editid == 0)
        {
            $insert_data = $this->cstmr->insert(
                array(
                    'ct_buid'    => $this->buid,
                    'ct_name'    => $customername,
                    'ct_address'        => $address,
                    'ct_city'       => $city,
                    'ct_state'       => $state,
                    'ct_country'  => $country,
                    'ct_phone' => $phone,
                    'ct_mobile' => $mobile,
                    'ct_email' => $email,
                    'ct_gstin' => $gstno,
                    'ct_type' => $customertype,
                    'ct_balanceamount' => $balanceamnt,
                    'ct_updatedon'     => $this->updatedon,
                    'ct_updatedby'     => $this->loggeduserid,
                ), true
            );

            $customerid = $insert_data;
        }else{
            $customerid = $editid;
            $updacc = array(
                'ct_name'    => $customername,
                'ct_address'        => $address,
                'ct_city'       => $city,
                'ct_state'       => $state,
                'ct_country'  => $country,
                'ct_phone' => $phone,
                'ct_mobile' => $mobile,
                'ct_email' => $email,
                'ct_gstin' => $gstno,
                'ct_type' => $customertype,
                'ct_updatedon'     => $this->updatedon,
                'ct_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->cstmr->update($editid, $updacc, TRUE);

            if($isledgerentry == 0)
            {
                $updacc = array(
                    'ct_balanceamount' => $balanceamnt,
                );
                $insert_data = $this->cstmr->update($editid, $updacc, TRUE);
            }
        }
        

        if ($insert_data) {

            if($isledgerentry == 0)
            {
                $update = $this->accldgr->insert([
                    'al_buid'  => $this->buid,
                    'al_groupid'   => 25,
                    'al_ledger' => $customername,
                    'al_closingbalance' => $balanceamnt,
                    'al_issub' => 0,
                    'al_mainledgerid' => 0,
                    'al_usertype' => 1,
                    'al_userid'   => $customerid,
                    'al_updatedon' => $this->updatedon,
                    'al_updatedby' => $this->loggeduserid
                ], TRUE);
                $ledgid = $this->db->insert_id();
                if($update)
                {
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $ledgid,
                        'le_amount' => $balanceamnt,
                        'le_isdebit' => 0,
                        'le_date' => $this->updatedon,
                        'le_closingamount' => $balanceamnt,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                }
            }else{
                $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $customerid);
                if($getcustomerledgr)
                {
                    $custledgrid=$getcustomerledgr->al_ledgerid;
                }else{
                    $custledgrid = 0;
                }

                if($custledgrid != 0)
                {
                    $updaccldg = array(
                        'al_ledger' => $customername,
                    );
                    $update_ldgrname = $this->accldgr->update($custledgrid, $updaccldg, TRUE);
                }
            }
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/customers');
    }
    public function enabledisablecustomer($editid, $action = 0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $dsbledary = $this->cstmr->update($editid, ['ct_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/customers');
    }
    public function getcustomerdetails()
    {
        $this->load->model('business/customers_model', 'cstmr');
        $customerid = $this->input->post('customerid');
        $this->data['customerdet'] = $this->cstmr->getcustomerdetailsbyid($customerid);
        $this->load->view('ajaxcustomerview', $this->data);
    }
    public function addingcustomerpayment()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/customers_model', 'cstmr');

        $this->load->model('accounts/journalentry_model', 'jrnlmdl');

        $customerid = $this->input->post('customerid');
        $paidamount = $this->input->post('paidamount');
        $custoldbalance = $this->input->post('custoldbalance');
        $paymethod = $this->input->post('paymethod');
        $paynote = $this->input->post('paynote');

        $newbalance = $custoldbalance - $paidamount;

        $updatepayment = $this->cstmr->update_status_by([
            'ct_cstomerid' => $customerid
        ], [
            'ct_balanceamount' => $newbalance
        ]);

        if($updatepayment)
        {
            $lastjrnlno = $this->jrnlmdl->getlastjournalno($buid, 2);
            if($lastjrnlno)
            {
                $jrnalno = $lastjrnlno->je_journalnumber + 1;
            }else{
                $jrnalno = 1;
            }

            //Jouranal entry
            $insertdata = $this->jrnlmdl->insert(
                array(
                    'je_buid'           => $this->buid,
                    'je_finyearid'      => $this->finyearid,
                    'je_journalnumber'  => $jrnalno,
                    'je_date'           => $this->updatedon,
                    'je_amount'         => $paidamount,
                    'je_crediamount'    => $paidamount,
                    'je_debitamount'    => $paidamount,
                    'je_description'    => $paynote,
                    'je_status'         => 0,
                    'je_type'           => 2,
                    'je_customerid'     => $customerid,
                    'je_updatedon'      => $this->updatedon,
                    'je_updatedby'      => $this->loggeduserid,
                ), true
            );
            $idupd = $this->db->insert_id();

            // Account cash/bank ledger
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$paidamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => $paymethod,
                'le_journalid' => $idupd,
                'le_amount' => $paidamount,
                'le_isdebit' => 0,
                'le_note' => $paynote,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosing,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            //getcustomer ledgerid
            $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $customerid);
            if($getcustomerledgr)
            {
                $custledgrid=$getcustomerledgr->al_ledgerid;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt-$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $custledgrid,
                    'le_journalid' => $idupd,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 1,
                    'le_note' => $paynote,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }

            $this->session->set_flashdata('messageS', 'Successfully submitted payment.');
        }
        else{
            $this->session->set_flashdata('messageE', 'Error occured, please try again');
        }
        redirect('business/customers');
    }

    public function taxbands()
    {
        $this->load->model('business/taxbands_model', 'txbnds');
        $this->data['taxbands'] = $this->txbnds->getallrows($this->buid);
        $this->load->template('taxbands', $this->data, FALSE);
    }
    public function addingtaxvalue()
    {
        $this->load->model('business/taxbands_model', 'txbnds');

        $editid = $this->input->post('editid');
        $taxband = $this->input->post('taxband');
        $taxvalue = $this->input->post('taxvalue');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insert_data = $this->txbnds->insert(
                array(
                    'tb_buid'    => $this->buid,
                    'tb_taxband'    => $taxband,
                    'tb_tax'        => $taxvalue,
                    'tb_notes'       => $notes,
                    'tb_updatedon'     => $this->updatedon,
                    'tb_updatedby'     => $this->loggeduserid,
                ), true
            );
            $statsmsg = 'record_added_success';
        }else{
            $updacc = array(
                'tb_taxband'    => $taxband,
                'tb_tax'        => $taxvalue,
                'tb_notes'       => $notes,
                'tb_updatedon'     => $this->updatedon,
                'tb_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->txbnds->update($editid, $updacc, TRUE);

            $statsmsg = 'record_updated_success';
        }
        

        if ($insert_data) {
            $this->session->set_flashdata('messageS', lang($statsmsg));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/taxbands');
    }
    public function enabledisabletaxband($editid, $action = 0)
    {
        $this->load->model('business/taxbands_model', 'txbnds');
        $dsbledary = $this->txbnds->update($editid, ['tb_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/taxbands');
    }
    public function gettaxdetails()
    {
        $this->load->model('business/taxbands_model', 'txbnds');

        $taxid   = $this->input->post('taxid');
        $editdata = $this->txbnds->getrowbytaxid($taxid);

        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }

    public function productunits()
    {
        $this->load->model('units_model', 'unmdl');
        $this->data['units'] = $this->unmdl->getallrows($this->buid);
        $this->load->template('productunits', $this->data, FALSE);
    }
    public function addingunit()
    {
        $this->load->model('units_model', 'unmdl');

        $editid = $this->input->post('editid');
        $unit = $this->input->post('unit');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insert_data = $this->unmdl->insert(
                array(
                    'un_buid'    => $this->buid,
                    'un_unitname'    => $unit,
                    'un_description'   => $notes,
                    'un_updatedon'     => $this->updatedon,
                    'un_updatedby'     => $this->loggeduserid,
                ), true
            );
            $statsmsg = 'record_added_success';
        }else{
            $updacc = array(
                'un_unitname'    => $unit,
                'un_description'   => $notes,
                'un_updatedon'     => $this->updatedon,
                'un_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->unmdl->update($editid, $updacc, TRUE);

            $statsmsg = 'record_updated_success';
        }
        

        if ($insert_data) {
            $this->session->set_flashdata('messageS', lang($statsmsg));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/productunits');
    }
    public function enabledisableunit($editid, $action = 0)
    {
        $this->load->model('units_model', 'unmdl');
        $dsbledary = $this->unmdl->update($editid, ['un_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/productunits');
    }

    public function financialyear()
    {
        $this->load->model('business/financialyears_model', 'fnyr');
        $this->data['finyears'] = $this->fnyr->getallrows($this->buid);
        $this->load->template('financialyear', $this->data, FALSE);
    }
    public function addingfinancialyear()
    {
        $this->load->model('business/financialyears_model', 'fnyr');

        $editid = $this->input->post('editid');
        $fromdate = date('Y-m-d', strtotime($this->input->post('fromdate')));
        $todate = date('Y-m-d', strtotime($this->input->post('todate')));
        $finyearname = $this->input->post('finyearname');

        if($editid == "")
        {
            $insert_data = $this->fnyr->insert(
                array(
                    'ay_buid'    => $this->buid,
                    'ay_financialname'    => $finyearname,
                    'ay_startdate'   => $fromdate,
                    'ay_enddate' => $todate,
                    'ay_updatedon'     => $this->updatedon,
                    'ay_updatedby'     => $this->loggeduserid,
                ), true
            );
            $statsmsg = 'record_added_success';
        }else{
            $updacc = array(
                'ay_financialname'    => $finyearname,
                'ay_startdate'   => $fromdate,
                'ay_enddate' => $todate,
                'ay_updatedon'     => $this->updatedon,
                'ay_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->fnyr->update($editid, $updacc, TRUE);

            $statsmsg = 'record_updated_success';
        }
        

        if ($insert_data) {
            $this->session->set_flashdata('messageS', lang($statsmsg));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/financialyear');
    }

    public function setfinancialyear($yearid)
    {
        $this->load->model('business/financialyears_model', 'fnyr');

        $finyeardetails = $this->fnyr->getrowbyyearid($yearid);
        $this->session->set_userdata('finyearid', $yearid);

        $this->session->set_userdata('finstartdate', $finyeardetails->ay_startdate);
        $this->session->set_userdata('finenddate', $finyeardetails->ay_enddate);
        $this->session->set_userdata('finname', $finyeardetails->ay_financialname);

        $this->session->set_flashdata('messageS', 'Successfully changed financial year.');
        redirect('business/financialyear');
    }

    public function designations()
    {
        $this->load->model('usertype_model', 'usrtyp');
        $this->data['designations'] = $this->usrtyp->getbusinessdesignations($this->buid);
        $this->load->template('designations', $this->data, FALSE);
    }
    public function addingdesignation()
    {
        $this->load->model('usertype_model', 'usrtyp');

        $editid = $this->input->post('editid');
        $designation = $this->input->post('designation');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insert_data = $this->usrtyp->insert(
                array(
                    'ut_businessid'    => $this->buid,
                    'ut_usertype'    => $designation,
                    'ut_notes'       => $notes,
                    'ut_updatedon'     => $this->updatedon,
                    'ut_updatedby'     => $this->loggeduserid,
                ), true
            );
            $statsmsg = 'record_added_success';
        }else{
            $updacc = array(
                'ut_usertype'    => $designation,
                'ut_notes'       => $notes,
                'ut_updatedon'     => $this->updatedon,
                'ut_updatedby'     => $this->loggeduserid,
            );
            $insert_data = $this->usrtyp->update($editid, $updacc, TRUE);

            $statsmsg = 'record_updated_success';
        }
        
        if ($insert_data) {
            $this->session->set_flashdata('messageS', lang($statsmsg));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/designations');
    }
    public function getdesignationdetails()
    {
        $this->load->model('usertype_model', 'usrtyp');

        $typeid   = $this->input->post('typeid');
        $editdata = $this->usrtyp->getrowbyid($typeid);

        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }
    public function enabledisabledesignation($editid, $action = 0)
    {
        $this->load->model('usertype_model', 'usrtyp');
        $dsbledary = $this->usrtyp->update($editid, ['ut_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('business/designations');
    }

    public function billprintoptions()
    {
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $this->blprnt->getbillprintdetails($this->buid);
        $this->load->template('billprintoptions', $this->data, FALSE);
    }
    public function updatebillprintdetails()
    {
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $editid   = $this->input->post('editid');

        $bp_retailprefix   = $this->input->post('bp_retailprefix');
        $bp_wholesaleprefix   = $this->input->post('bp_wholesaleprefix');
        $bp_proformaprefix   = $this->input->post('bp_proformaprefix');
        $bp_wholesaleproformaprefix   = $this->input->post('bp_wholesaleproformaprefix');

        $bp_quotationprefix   = $this->input->post('bp_quotationprefix');
        $bp_wholesalequotationprefix   = $this->input->post('bp_wholesalequotationprefix');

        $bp_servicebillprefix   = $this->input->post('bp_servicebillprefix');
        $bp_purchasebillprefix   = $this->input->post('bp_purchasebillprefix');
        $bp_purchaseorderprefix   = $this->input->post('bp_purchaseorderprefix');
        $bp_defaultpagesize   = $this->input->post('bp_defaultpagesize');

        $remarkcolumn = $this->input->post('remarkcolumn');
        $bp_hidepurchaseprice = $this->input->post('bp_hidepurchaseprice');

        $bp_hidevehiclenumber = $this->input->post('bp_hidevehiclenumber');
        $bp_hideewaybillno = $this->input->post('bp_hideewaybillno');
        $bp_hidedeliverydate = $this->input->post('bp_hidedeliverydate');
        $bp_hidepodetails = $this->input->post('bp_hidepodetails');

        $bp_salereturnprefix = $this->input->post('bp_salereturnprefix');
        $bp_purchasereturnprefix = $this->input->post('bp_purchasereturnprefix');

        $bp_needdupinvoice = $this->input->post('bp_needdupinvoice');
        $bp_needtripinvoice = $this->input->post('bp_needtripinvoice');

        $bp_orderprefix = $this->input->post('bp_orderprefix');
        $bp_csaleprefix = $this->input->post('bp_csaleprefix');
        $bp_dsaleprefix = $this->input->post('bp_dsaleprefix');

        if($editid == "")
        {
            $insertdet = $this->blprnt->insert(array(
                'bp_buid' => $this->buid,
                'bp_retailprefix' => $bp_retailprefix,
                'bp_wholesaleprefix' => $bp_wholesaleprefix,
                'bp_proformaprefix' => $bp_proformaprefix,
                'bp_wholesaleproformaprefix' => $bp_wholesaleproformaprefix,
                'bp_quotationprefix' => $bp_quotationprefix,
                'bp_wholesalequotationprefix' => $bp_wholesalequotationprefix,
                'bp_servicebillprefix' => $bp_servicebillprefix,
                'bp_purchasebillprefix' => $bp_purchasebillprefix,
                'bp_purchaseorderprefix' => $bp_purchaseorderprefix,
                'bp_defaultpagesize' => $bp_defaultpagesize,
                'bp_updatedby' => $this->loggeduserid,
                'bp_updatedon' => $this->updatedon,
                'bp_remarkcolumn' => $remarkcolumn,
                'bp_hidepurchaseprice' => $bp_hidepurchaseprice,
                'bp_hidevehiclenumber' => $bp_hidevehiclenumber,
                'bp_hideewaybillno' => $bp_hideewaybillno,
                'bp_hidedeliverydate' => $bp_hidedeliverydate,
                'bp_hidepodetails' => $bp_hidepodetails,
                'bp_salereturnprefix' => $bp_salereturnprefix,
                'bp_purchasereturnprefix' => $bp_purchasereturnprefix,
                'bp_needdupinvoice' => $bp_needdupinvoice,
                'bp_needtripinvoice' => $bp_needtripinvoice,
                'bp_orderprefix' => $bp_orderprefix,
                'bp_csaleprefix' => $bp_csaleprefix,
                'bp_dsaleprefix' => $bp_dsaleprefix
            ), TRUE);
            $statsmsg = 'record_added_success';
        }else{

            $updacc = array(
                'bp_retailprefix' => $bp_retailprefix,
                'bp_wholesaleprefix' => $bp_wholesaleprefix,
                'bp_proformaprefix' => $bp_proformaprefix,
                'bp_wholesaleproformaprefix' => $bp_wholesaleproformaprefix,
                'bp_quotationprefix' => $bp_quotationprefix,
                'bp_wholesalequotationprefix' => $bp_wholesalequotationprefix,
                'bp_servicebillprefix' => $bp_servicebillprefix,
                'bp_purchasebillprefix' => $bp_purchasebillprefix,
                'bp_purchaseorderprefix' => $bp_purchaseorderprefix,
                'bp_defaultpagesize' => $bp_defaultpagesize,
                'bp_updatedby' => $this->loggeduserid,
                'bp_updatedon' => $this->updatedon,
                'bp_remarkcolumn' => $remarkcolumn,
                'bp_hidepurchaseprice' => $bp_hidepurchaseprice,
                'bp_hidevehiclenumber' => $bp_hidevehiclenumber,
                'bp_hideewaybillno' => $bp_hideewaybillno,
                'bp_hidedeliverydate' => $bp_hidedeliverydate,
                'bp_hidepodetails' => $bp_hidepodetails,
                'bp_salereturnprefix' => $bp_salereturnprefix,
                'bp_purchasereturnprefix' => $bp_purchasereturnprefix,
                'bp_needdupinvoice' => $bp_needdupinvoice,
                'bp_needtripinvoice' => $bp_needtripinvoice,
                'bp_orderprefix' => $bp_orderprefix,
                'bp_csaleprefix' => $bp_csaleprefix,
                'bp_dsaleprefix' => $bp_dsaleprefix
            );
            $insertdet = $this->blprnt->update($editid, $updacc, TRUE);
            
            $statsmsg = 'record_updated_success';
        }

        if($insertdet)
        {
            $this->session->set_flashdata('messageS', lang($statsmsg));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('business/billprintoptions');
    }
}
