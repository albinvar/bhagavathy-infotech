<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Userauthentication_model extends MY_Model {

    public $_table               = 'ub_authentication';
    public $protected_attributes = array('at_authid');
    public $primary_key          = 'at_authid';


    public $validate = array(
        'adduser_validation'    => array(
            array(
                'field' => 'firstname',
                'label' => 'firstname',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'emailaddress',
                'label' => 'emailaddress',
                'rules' => 'trim|required|valid_email',
            ),
            array(
                'field' => 'contactnumber',
                'label' => 'contactnumber',
                'rules' => 'trim|required',
            ),
        ),

        'addguardianvalidation' => array(
            array(
                'field' => 'parentusername',
                'label' => 'username',
                'rules' => 'trim|required|integer',
            ),
            array(
                'field' => 'parentfirstname',
                'label' => 'First Name',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'parentaddress',
                'label' => 'address',
                'rules' => 'trim|required',
            ),
        ),

        'changepassword'        => array(
            array(
                'field' => 'newpassword',
                'label' => 'New password',
                'rules' => 'required|min_length[5]',
            ),
            array(
                'field' => 'confirmpassword',
                'label' => 'Confirm password',
                'rules' => 'required|min_length[5]|matches[newpassword]',
            ),
            array(
                'field' => 'currentpassword',
                'label' => 'currentpassword password',
                'rules' => 'required|min_length[5]',
            ),

        ),
        'logincheck'            => array(
            array(
                'field' => 'username',
                'label' => 'User Name',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'userpassword',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[5]',
            ),

        ),
        'updateuser_validation' => array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
            ),
            array(
                'field' => 'firstname',
                'label' => 'First Name',
                'rules' => 'required',
            ),
            array(
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'address',
                'label' => 'address',
                'rules' => 'trim|required',
            ),

        ),
    );

    private $select_fields = 'at_authid, at_username, at_name, at_phone, at_mobile, at_email, at_photo, at_addedon, at_usertypeid, at_unitids, at_isactive, at_businessid, at_godownid';

    public function getuserdetails($data) {
        $this->db->select($this->select_fields);
        $this->db->from('ub_authentication');
        $this->db->where($data);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        }
        return FALSE;
    }
    public function checkusernamealreadyexists($username){
        $this->db->select('at_authid');
        $this->db->from('ub_authentication');
        $this->db->where('at_username', $username);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        }
        return FALSE;
    }
    public function getallstaffs($businesid){
        $this->db->select($this->select_fields . ', b.ut_usertype');
        $this->db->from('ub_authentication a');
        $this->db->join('ub_usertypes b', 'b.ut_usertypeid=a.at_usertypeid');
        $this->db->where('a.at_businessid', $businesid);
        $this->db->where('a.at_usertypeid !=', 1);
        $this->db->where('a.at_usertypeid !=', 2);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }
    public function getallbusinessstaffcnt($businesid){
        $this->db->select('at_authid');
        $this->db->from('ub_authentication');
        $this->db->where('at_businessid', $businesid);
        $this->db->where('at_usertypeid !=', 1);
        $this->db->where('at_usertypeid !=', 2);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    public function getallunitstaffs($buid){
        $this->db->select($this->select_fields . ', b.ut_usertype');
        $this->db->from('ub_authentication a');
        $this->db->join('ub_usertypes b', 'b.ut_usertypeid=a.at_usertypeid');
        $this->db->where('a.at_unitids', $buid);
        $this->db->where('a.at_usertypeid !=', 1);
        $this->db->where('a.at_usertypeid !=', 2);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    public function adminallstafflist(){
        $this->db->select($this->select_fields . ', b.ut_usertype, c.bs_name');
        $this->db->from('ub_authentication a');
        $this->db->join('ub_usertypes b', 'b.ut_usertypeid=a.at_usertypeid');
        $this->db->join('ub_business c', 'c.bs_businessid=a.at_businessid', 'left');
        $this->db->where('a.at_usertypeid !=', 1);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    public function getrowbyid($id = 0) {
        $this->db->select($this->select_fields);
        $this->db->from('ub_authentication c');
        $this->db->where('at_authid', $id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        }
        return FALSE;
    }
    public function getbusinessunitusers($buid){
        $this->db->select($this->select_fields);
        $this->db->from('ub_authentication c');
        $this->db->where('at_unitids', $buid);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    public function getrowbyid_array(array $id = []) {
        $this->db->select($this->select_fields);
        $this->db->from('ub_authentication');
        $this->db->where_in('at_authid', $id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result();
        }
        return FALSE;
    }

    

}
