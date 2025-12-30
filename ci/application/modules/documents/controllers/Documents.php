<?php

defined('BASEPATH') or exit('No direct script access allowed');

class documents extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('documents/documentfolders_model', 'dcfldrs');
        $this->load->model('documents/documents_model', 'dcmnts');
    }

    
    public function documentlist($status=0, $folder=0)
    {
        if($status == 0)
        {
            $this->data['title'] = "Document List";
        }else if($status == 1){
            $this->data['title'] = "Starred List";
        }else if($status == 2){
            $this->data['title'] = "Recent List";
        }
        else if($status == 3){
            $this->data['title'] = "Deleted List";
        }

        $this->data['folders'] = $this->dcfldrs->getactiverows($this->buid);
        
        $this->data['status'] = $status;
        $this->data['folder'] = $folder;
        $this->data['businssdet'] = $this->bus->getbusinessdetails($this->businessid);

        $this->data['documents'] = $this->dcmnts->getactiverows($this->buid, $status, $folder);
        $this->load->template('documentlist', $this->data, FALSE);
    }
    public function addingattachment()
    {
        $folderid = $this->input->post('folderid');
        $filenotes = $this->input->post('filenotes');

        if(isset($_FILES["docfile"]["name"]))
        {
            create_directory("uploads/documents/".$this->buid);

            $target_dir1  = "uploads/documents/".$this->buid."/";
            $temp1        = explode(".", $_FILES["docfile"]["name"]);
            //$filenameup   = @round(microtime(true)) . '.' . end($temp1);
            $filenameup   = @round(microtime(true)) . '-' . $_FILES["docfile"]["name"];
            $target_file1 = $target_dir1 . $filenameup;
            if (move_uploaded_file($_FILES["docfile"]["tmp_name"], $target_file1)) {
                //$attachmntarr[] = $filenameup;

                $insertset = $this->dcmnts->insert(array(
                    'dc_buid' => $this->buid,
                    'dc_filename' => $filenameup,
                    'dc_description' => $filenotes,
                    'dc_folder' => $folderid,
                    'dc_addedby' => $this->loggeduserid,
                    'dc_addedon' => $this->updatedon,
                    'dc_updatedby' => $this->loggeduserid,
                    'dc_updatedon' => $this->updatedon
                ), TRUE);
                
            }

            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('documents/documentlist');
    }

    public function addtofavourite($docid)
    {
        $addfav = $this->dcmnts->update($docid, ['dc_starred' => 1], TRUE);

        if($addfav)
        {
            $this->session->set_flashdata('messageS', 'Added to Starred List.');
        }else{
            $this->session->set_flashdata('messageE', 'Error occured please try again.');
        }

        redirect('documents/documentlist');
    }
    public function removefavourite($docid)
    {
        $addfav = $this->dcmnts->update($docid, ['dc_starred' => 0], TRUE);
        if($addfav)
        {
            $this->session->set_flashdata('messageS', 'Removed from Starred List.');
        }else{
            $this->session->set_flashdata('messageE', 'Error occured please try again.');
        }

        redirect('documents/documentlist');
    }

    public function enabledisabledocument($editid, $action = 0)
    {
        $dsbledary = $this->dcmnts->update($editid, ['dc_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('documents/documentlist');
    }
    public function getdocumentdetails()
    {
        $fileid = $this->input->post('fileid');
        $editdata = $this->dcmnts->getdocummentbyid($fileid);
        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }
    public function renameattachment()
    {
        $fileid = $this->input->post('fileid');
        $oldfilename = $this->input->post('oldfilename');
        $docfilename = $this->input->post('docfilename');
        $docfilenotes = $this->input->post('docfilenotes');

        $updacc = array(
            'dc_filename' => $docfilename,
            'dc_description' => $docfilenotes,
            'dc_updatedby' => $this->loggeduserid,
            'dc_updatedon' => $this->updatedon
        );
        $updfilename = $this->dcmnts->update($fileid, $updacc, TRUE);
        if($updfilename)
        {
            rename('uploads/documents/'.$this->buid.'/' . $oldfilename, 'uploads/documents/'.$this->buid.'/' . $docfilename);

            $this->session->set_flashdata('messageS', "File name updated successfully.");
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('documents/documentlist');
    }
    /*public function documentdownload($attid) {
        $this->load->helper('file');
        $this->load->helper('download');
        $attchmnt = $this->dcmnts->getdocummentbyid($attid);
        
        $atchmnt1 = $attchmnt->dc_filename;
            
        $gturl    = str_replace(' ', '%20', $atchmnt1);
        //echo base_url() . "uploads/documents/".$this->buid."/" . $gturl;
        $atchmnts = file_get_contents(base_url() . "uploads/documents/".$this->buid."/" . $gturl);
        force_download($atchmnt, $atchmnts);
    }*/

    public function documentfolders()
    {
        $this->data['title'] = "Document Folders";
        $this->data['folders'] = $this->dcfldrs->getallrows($this->buid);
        $this->load->template('documentfolders', $this->data, FALSE);
    }
    public function addingfolder()
    {
        $editid = $this->input->post('editid');
        $bpage = $this->input->post('bpage');
        $foldername = $this->input->post('foldername');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insertset = $this->dcfldrs->insert(array(
                'df_buid' => $this->buid,
                'df_foldername' => $foldername,
                'df_description' => $notes,
                'df_addedby' => $this->loggeduserid,
                'df_addedon' => $this->updatedon
            ), TRUE);
        }else{
            $updacc = array(
                'df_buid' => $this->buid,
                'df_foldername' => $foldername,
                'df_description' => $notes,
                'df_addedby' => $this->loggeduserid,
                'df_addedon' => $this->updatedon
            );
            $insertset = $this->dcfldrs->update($editid, $updacc, TRUE);
        }
        if($insertset)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        if($bpage == 1)
        {
            redirect('documents/documentlist');
        }else{
            redirect('documents/documentfolders');
        }
        
    }

    public function getfolderdetails()
    {
        $folderid = $this->input->post('folderid');
        $editdata = $this->dcfldrs->getrowbyid($folderid);
        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }
    
    public function enabledisablefolder($editid, $action = 0)
    {
        $dsbledary = $this->dcfldrs->update($editid, ['df_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('documents/documentfolders');
    }

    
    
}
