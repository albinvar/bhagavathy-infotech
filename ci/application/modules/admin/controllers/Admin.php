<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
    }

    public function dashboard() {
        $this->data['title'] = "Admin Dashboard";
        $this->load->admintemplate('dashboard', $this->data, FALSE);
    }

    public function businesstypes(){
        $this->load->model('admin/businesstypes_model', 'bustyp');
        $this->data['title'] = "Business Types";
        $this->data['butypes'] = $this->bustyp->getallrows();
        $this->load->admintemplate('businesstypes', $this->data, FALSE);
    }
    public function addingbusinesstype()
    {
        $this->load->model('admin/businesstypes_model', 'bustyp');

        $butype = $this->input->post('butype');
        $description = $this->input->post('description');
        
        $insrt = $this->bustyp->insert([
            'bt_businesstype'  => $butype,
            'bt_description'   => $description
        ], TRUE);

        if($insrt)
        {
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('admin/businesstypes');
    }
    public function enabledisablebutypes($editid, $action = 0)
    {
        $this->load->model('admin/businesstypes_model', 'bustyp');
        
        $dsbledary = $this->bustyp->update($editid, ['bt_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('admin/businesstypes');
    }
    public function business()
    {
        $this->load->model('admin/business_model', 'bus');
        $this->data['title'] = "Business";
        $this->data['business'] = $this->bus->getallrows();
        $this->load->admintemplate('business', $this->data, FALSE);
    }
    
    public function addbusiness()
    {
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businesstypes_model', 'bustyp');

        $this->data['butypes'] = $this->bustyp->getactiverows();
        $this->load->admintemplate('addbusiness', $this->data, FALSE);
    }
    public function addbusinessprocess()
    {
        $this->load->model('admin/business_model', 'bus');

        $facilityname     = $this->input->post('facilityname');
        $facilityaddress  = $this->input->post('facilityaddress');
        $facilitywebsite  = $this->input->post('facilitywebsite');
        $facilityemail    = $this->input->post('facilityemail');
        $facilityphone    = $this->input->post('facilityphone');
        $numberfecilities = $this->input->post('numberfecilities');

        $numberofstaff = $this->input->post('numberofstaff');

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $name = $firstname . " " . $lastname;
        $username = $this->input->post('username');
        $password = $this->input->post('password');


        $albumpathfolder = 'uploads/business/';

        create_directory($albumpathfolder);

        $logofile = "";

        $date = date('Y-m-d H:i:s');

        $usernamecheck = $this->usersigin->checkusernamealreadyexists($username);
        if(!$usernamecheck)
        {

        if (!empty($_FILES['facilitylogo']['name'])) {
            $config = array(
                'upload_path'   => $albumpathfolder,
                'allowed_types' => 'jpg|gif|png|jpeg|JPG|JPEG|PNG|Jpg|Png|Jpeg',
                'overwrite'     => false,
                'max_size'      => '10240',
            );
            $this->load->library('upload', $config);
            $salt                = random_string('alnum', 5);
            $fileName            = date('ymdhis') . '_' . $salt;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('facilitylogo')) {
                $albummodel_image = $this->upload->data();
                $logofile     = $albummodel_image['file_name'];

            }

        }

        $insertdata = $this->bus->insert(
            array(
                'bs_name'           => $facilityname,
                'bs_logo'           => $logofile,
                'bs_address'        => $facilityaddress,
                'bs_website'        => $facilitywebsite,
                'bs_email'          => $facilityemail,
                'bs_phone'          => $facilityphone,
                'bs_staffcount'     => $numberofstaff,
                'bs_unitcount'      => $numberfecilities,
                'bs_addedon'        => $this->updatedon,
                'bs_addedby'        => $this->loggeduserid,
            ), true
        );
        $idupd = $this->db->insert_id();

        $userpassword = md5($password);

        $insert_data = $this->usersigin->insert(
            array(
                'at_username'    => $username,
                'at_password'    => $userpassword,
                'at_name'        => $name,
                'at_phone'       => $facilityphone,
                'at_email'       => $facilityemail,
                'at_usertypeid'  => 2,
                'at_businessid'  => $idupd,
                'at_addedon'     => $this->updatedon,
                'at_addedby'     => $this->loggeduserid,
            ), true
        );

        
        if ($insertdata) {
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        }
        else{
            $this->session->set_flashdata('messageE', 'Username already exists, please try another username..');
        }
        
        redirect('admin/business');
    }

    public function enabledisablebusinee($editid, $action = 0)
    {
        $this->load->model('admin/business_model', 'bus');
        
        $dsbledary = $this->bus->update($editid, ['bs_status' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('admin/business');
    }

    public function businessunits()
    {
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->data['title'] = "Business Units";
        $this->data['businessunits'] = $this->busunt->getallrows();
        $this->load->admintemplate('businessunits', $this->data, FALSE);
    }
    public function addbusinessunit()
    {
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('admin/businesstypes_model', 'bustyp');

        $this->data['butypes'] = $this->bustyp->getactiverows();
        $this->data['businss'] = $this->bus->getactiverows();
        $this->load->admintemplate('addbusinessunit', $this->data, FALSE);
    }
    public function addbusinessunitprocess()
    {
        $this->load->model('admin/businessunit_model', 'busunt');

        $businessid     = $this->input->post('businessid');
        $businesstype  = $this->input->post('businesstype');

        $unitname  = $this->input->post('unitname');
        $unitaddress  = $this->input->post('unitaddress');
        $unitwebsite  = $this->input->post('unitwebsite');
        $unitemail  = $this->input->post('unitemail');
        $unitphone  = $this->input->post('unitphone');
        $gstno  = $this->input->post('gstno');

        $composittax = $this->input->post('composittax');
        $taxtype = $this->input->post('taxtype');
        $withoutlogin = $this->input->post('withoutlogin');

        $albumpathfolder = 'uploads/business/';
        create_directory($albumpathfolder);
        $logofile = "";
        $date = date('Y-m-d H:i:s');

        if (!empty($_FILES['unitlogo']['name'])) {
            $config = array(
                'upload_path'   => $albumpathfolder,
                'allowed_types' => 'jpg|gif|png|jpeg|JPG|JPEG|PNG|Jpg|Png|Jpeg',
                'overwrite'     => false,
                'max_size'      => '10240',
            );
            $this->load->library('upload', $config);
            $salt                = random_string('alnum', 5);
            $fileName            = date('ymdhis') . '_' . $salt;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('unitlogo')) {
                $albummodel_image = $this->upload->data();
                $logofile     = $albummodel_image['file_name'];
            }
        }

        $insertdata = $this->busunt->insert(
            array(
                'bu_businessid'     => $businessid,
                'bu_businesstypeid' => $businesstype,
                'bu_unitname'       => $unitname,
                'bu_logo'           => $logofile,
                'bu_address'        => $unitaddress,
                'bu_email'          => $unitemail,
                'bu_phone'          => $unitphone,
                'bu_website'        => $unitwebsite,
                'bu_gstnumber'      => $gstno,
                'bu_updatedon'      => $this->updatedon,
                'bu_updatedby'      => $this->loggeduserid,
                'bu_withoutlogin'   => $withoutlogin,
                'bu_composittax'    => $composittax,
                'bu_isvat'          => $taxtype
            ), true
        );
        $idupd = $this->db->insert_id();
        
        if ($insertdata) {

            if($withoutlogin == 1)
            {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $name = $firstname . " " . $lastname;
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $userpassword = md5($password);

                $insert_data = $this->usersigin->insert(
                    array(
                        'at_username'    => $username,
                        'at_password'    => $userpassword,
                        'at_name'        => $name,
                        'at_phone'       => $unitphone,
                        'at_email'       => $unitemail,
                        'at_usertypeid'  => 3,
                        'at_businessid'  => $businessid,
                        'at_unitids'     => $idupd,
                        'at_addedon'     => $this->updatedon,
                        'at_addedby'     => $this->loggeduserid,
                    ), true
                );
            }

            $this->session->set_flashdata('messageS', lang('record_added_success'));
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        
        redirect('admin/businessunits');
    }

    public function allusers()
    {
        $this->data['title'] = "Users List";
        $this->data['staffs'] = $this->usersigin->adminallstafflist();
        $this->load->admintemplate('alluserslist', $this->data, FALSE);
    }

    public function dbbackup()
    {
        $this->load->helper('download');
        $this->load->dbutil();
        $prefs = array('format' => 'zip', 'filename' => 'Database-backup_' . date('Y-m-d_H-i'));
        $backup = $this->dbutil->backup($prefs);
        $filename = 'BD-backup_' . date('Y-m-d_H-i') . '.zip';
        if (!write_file('./uploads/backup/'. $filename , $backup)) {
            $this->session->set_flashdata('messageE', 'Error occured, please try again.');
        }
        else {
            force_download('./uploads/backup/'. $filename, NULL);
            $this->session->set_flashdata('messageS', 'Database backup has been successfully Created.');
        }
    }

}
