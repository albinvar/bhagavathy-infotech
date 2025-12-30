<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Crm extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('crm/crmenquiries_model', 'enqry');
    }

    
    public function enquirylist($status=0)
    {
        $this->load->model('crm/crmenquiryfollowups_model', 'enqryfllp');
        if($status == 0)
        {
            $this->data['title'] = "New Enquiry List";
        }else if($status == 1){
            $this->data['title'] = "Follow Up Enquiry List";
        }else if($status == 2){
            $this->data['title'] = "Confirmed Enquiry List";
        }else if($status == 3){
            $this->data['title'] = "Cancelled Enquiry List";
        }
        else if($status == 4){
            $this->data['title'] = "Completed Enquiry List";
        }
        
        $this->data['status'] = $status;
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);

        $this->data['newcount'] = $this->enqry->getenquirycountbystatus($this->buid, 0);
        $this->data['followcount'] = $this->enqry->getenquirycountbystatus($this->buid, 1);
        $this->data['confirmcount'] = $this->enqry->getenquirycountbystatus($this->buid, 2);
        $this->data['cancelcount'] = $this->enqry->getenquirycountbystatus($this->buid, 3);
        $this->data['completedcount'] = $this->enqry->getenquirycountbystatus($this->buid, 4);
        $this->data['deletecount'] = $this->enqry->getdeletedenquirycount($this->buid);

        $this->data['enquiries'] = $this->enqry->getallenquiriesbystatus($this->buid, $status);
        $this->load->template('enquirylist', $this->data, FALSE);
    }
    public function deletedenquirylist()
    {
        $this->load->model('crm/crmenquiryfollowups_model', 'enqryfllp');
        $this->data['title'] = "Deleted Enquiry List";
        $this->data['status'] = 4;
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);

        $this->data['newcount'] = $this->enqry->getenquirycountbystatus($this->buid, 0);
        $this->data['followcount'] = $this->enqry->getenquirycountbystatus($this->buid, 1);
        $this->data['confirmcount'] = $this->enqry->getenquirycountbystatus($this->buid, 2);
        $this->data['cancelcount'] = $this->enqry->getenquirycountbystatus($this->buid, 3);
        $this->data['completedcount'] = $this->enqry->getenquirycountbystatus($this->buid, 4);
        $this->data['deletecount'] = $this->enqry->getdeletedenquirycount($this->buid);

        $this->data['enquiries'] = $this->enqry->getdeletedenquiries($this->buid);
        $this->load->template('enquirylist', $this->data, FALSE);
    }
    public function viewenquirydetails($enquiryid)
    {
        $this->load->model('crm/crmenquiryfollowups_model', 'enqryfllp');
        $this->data['enquiryid'] = $enquiryid;
        $this->data['editdata'] = $this->enqry->getenquirydetailsbyid($enquiryid);
        $this->data['followups'] = $this->enqryfllp->getenquiryfollowupdetails($enquiryid);

        $this->load->template('viewenquirydetails', $this->data, FALSE);
    }
    
    public function addenquiry($editid=0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('Country_model', 'cuntry');
        $this->data['editid'] = $editid;
        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);
        if($editid == 0)
        {
            $this->data['enquiryno'] = $this->enqry->getnextenquirynumber($this->buid);
            $this->data['title'] = "Add New Enquiry";
            $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);
        }else{
            $this->data['title'] = "Edit Enquiry Details";
            
            $this->data['editdata'] = $editdet = $this->enqry->getenquirydetailsbyid($editid);
            $this->data['states'] = $this->cuntry->getstatelist($editdet->en_country);
        }
        $this->data['countries'] = $this->cuntry->getalldata();
        $this->data['customers'] = $this->cstmr->getactivecustomers($this->buid);
        
        $this->load->template('addenquiry', $this->data, FALSE);
    }
    public function addenquiryprocess()
    {

        $editid = $this->input->post('editid');
        $customercheck = $this->input->post('customercheck');
        $enquirynumber = $this->input->post('enquirynumber');

        if($customercheck != '1')
        {
            $customerid = 0;
            $customername = $this->input->post('customername');
            $city = $this->input->post('city');
            $address = $this->input->post('address');
            $country = $this->input->post('country');
            $state = $this->input->post('state');
            $phone = $this->input->post('phone');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $gstno = $this->input->post('gstno');
            $customertype= $this->input->post('customertype');
        }else{
            $customername = "";
            $address =  "";
            $city = "";
            $state = "";
            $country = "";
            $mobile = "";
            $phone = "";
            $email = "";
            $gstno = "";
            $customertype= "";
            $customerid = $this->input->post('customerid');
        }

        $subject = $this->input->post('subject');
        $enquirydetails = $this->input->post('enquirydetails');


        if($editid == 0)
        {
            $insert_data = $this->enqry->insert(
                array(
                    'en_buid'        => $this->buid,
                    'en_enquiryno'   => $enquirynumber,
                    'en_existingcust'=> $customercheck,
                    'en_customerid'  => $customerid,
                    'en_firstname'   => $customername,
                    'en_address'     => $address,
                    'en_city'        => $city,
                    'en_state'       => $state,
                    'en_country'     => $country,
                    'en_phone'       => $phone,
                    'en_mobile'      => $mobile,
                    'en_email'       => $email,
                    'en_gstno'       => $gstno,
                    'en_customertype'=> $customertype,
                    'en_subject'     => $subject,
                    'en_enquiry'     => $enquirydetails,
                    'en_addedon'     => $this->updatedon,
                    'en_addedby'     => $this->loggeduserid,
                ), true
            );

            $customerid = $insert_data;
        }else{
            $customerid = $editid;
            $updacc = array(
                'en_existingcust'=> $customercheck,
                'en_customerid'  => $customerid,
                'en_firstname'   => $customername,
                'en_address'     => $address,
                'en_city'        => $city,
                'en_state'       => $state,
                'en_country'     => $country,
                'en_phone'       => $phone,
                'en_mobile'      => $mobile,
                'en_email'       => $email,
                'en_gstno'       => $gstno,
                'en_customertype'=> $customertype,
                'en_subject'     => $subject,
                'en_enquiry'     => $enquirydetails,
                'en_updatedon'   => $this->updatedon,
                'en_updatedby'   => $this->loggeduserid,
            );
            $insert_data = $this->enqry->update($editid, $updacc, TRUE);
            
        }
        

        if ($insert_data) {
            
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('crm/enquirylist');
    }
    public function enabledisableenquiry($editid, $action = 0)
    {
        $dsbledary = $this->enqry->update($editid, ['en_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('crm/enquirylist');
    }
    public function getenquirydetails()
    {
        $enquiryid = $this->input->post('enquiryid');
        $this->data['enquirydet'] = $this->enqry->getenquirydetailsbyid($enquiryid);
        $this->load->view('ajaxenquiryview', $this->data);
    }
    public function followupenquirypopup()
    {
        $enquiryid = $this->input->post('enquiryid');
        $this->data['enquirydet'] = $this->enqry->getenquirydetailsbyid($enquiryid);
        $this->load->view('ajaxenquiryfollowupview', $this->data);
    }
    public function addingfollowupdetails()
    {
        $this->load->model('crm/crmenquiryfollowups_model', 'enqryfllp');
        
        $en_enquiryid = $this->input->post('en_enquiryid');
        $followupcomment = $this->input->post('followupcomment');
        $follwup = $this->input->post('follwup');
        if($follwup == 1)
        {
            $nextfollowupdate = date('Y-m-d', strtotime($this->input->post('nextfollowupdate')));
            $nextfollowuptime = date('H:i:s', strtotime($this->input->post('nextfollowuptime')));

            $nextdatetime = $nextfollowupdate . " " . $nextfollowuptime;
        }else{
            $nextdatetime = "";
        }
        
        $insert = $this->enqryfllp->insert(array(
            'ef_buid' => $this->buid,
            'ef_enquiryid' => $en_enquiryid,
            'ef_followupnote' => $followupcomment,
            'ef_status' => $follwup,
            'ef_nextfollowupdate' => $nextdatetime,
            'ef_updatedby' => $this->loggeduserid,
            'ef_updatedon' => $this->updatedon
        ), TRUE);

        if($insert)
        {
            $updacc = array(
                'en_status'=> $follwup,
            );
            $insert_data = $this->enqry->update($en_enquiryid, $updacc, TRUE);
            
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('crm/enquirylist/'.$follwup);
        
    }

    public function completingenquiry()
    {
        $completeenquiryid = $this->input->post('completeenquiryid');
        $completedcomment = $this->input->post('completedcomment');

        $updacc = array(
            'en_status'=> 4,
            'en_completedcomments' =>$completedcomment,
            'en_completedby' => $this->loggeduserid,
            'en_completedon' => $this->updatedon
        );
        $insert_data = $this->enqry->update($completeenquiryid, $updacc, TRUE);
        if($insert_data)
        {
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('crm/enquirylist/2');
    }
    
}
