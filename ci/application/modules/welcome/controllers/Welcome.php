<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
    }

    public function index() {
        $this->data['title'] = "signin";

        

        $this->load->signintemplate('signin', $this->data, FALSE);

    }

    public function signinauthentication() {
        $this->load->model('admin/business_model', 'bus');

        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));

        $data = array(
            'username'     => $username,
            'userpassword' => $password,
        );

        $loggedinflag = 0;
        if ($this->usersigin->validate($data, 'logincheck')) {

            $success = $this->usersigin->getuserdetails(array('at_username' => $username, 'at_isactive' => '0'));

            if ($success && $success->at_authid > 0) {

                $checkpassword = md5($password);

                if ($this->usersigin->getuserdetails(array('at_username' => $username, 'at_password' => $checkpassword))) {

                    if ($success->at_authid > 0) {

                        $session_id  = $success->at_authid;
                        $userrole    = $success->at_usertypeid;
                        if ($userrole == 1) {
                            $tarurl = "admin";
                        } else if ($userrole == 2) {
                            $tarurl = "business";
                        } else if ($userrole == 3) {
                            $tarurl = "business";
                        }

                        if ($userrole == 1) {
                            $loggedinflag = 1;
                            $data         = array(
                                'authenticationid' => $success->at_authid,
                                'usertype'         => $success->at_usertypeid,
                                'name'             => $success->at_name,
                                'contactnumber'    => $success->at_mobile,
                                'profilepic'       => $success->at_photo
                            );
                            $this->session->set_userdata($data);
                            $this->session->set_flashdata('successmessage', 'User authentication success');
                            redirect('admin/dashboard');

                        } else {

                            $loggedinflag = 1;

                            $checkbusavail = $this->bus->get_by(array('bs_businessid' => $success->at_businessid, 'bs_status' => '0'));
                            if ($checkbusavail) {
                                /*$currencyid = $checkbusavail->bs_currencyid;
                                $crncydet = $this->crncy->getcurrencydetails($currencyid);*/
                                $sess_data = array(
                                    'authenticationid' => $success->at_authid,
                                    'usertype'         => $success->at_usertypeid,
                                    'name'             => $success->at_name,
                                    'contactnumber'    => $success->at_mobile,
                                    'businessid'       => $success->at_businessid,
                                    'buslogo'          => $checkbusavail->bs_logo,
                                    'profilepic'       => $success->at_photo,
                                    'businessid'       => $success->at_businessid,
                                    'buid'             => "",
                                    'finyearid'        => "",
                                    'finstartdate'     => "",
                                    'finenddate'       => "",
                                    'finname'          => "",
                                    'godownid'         => $success->at_godownid,
                                );
                                $this->session->set_userdata($sess_data);
                                $this->session->set_flashdata('successmessage', 'User authentication success');
                                redirect('business/dashboard');

                            } else {
                                $this->session->set_flashdata('errormessage', 'Business not available or active');
                                redirect('welcome/index');
                            }
                        } 
                    } else {
                        $this->session->set_flashdata('errormessage', 'User does not exist');
                        redirect('welcome/index');
                    }
                } else {
                    $this->session->set_flashdata('errormessage', 'Invalid password');
                    redirect('welcome/index');
                }
            } else {

                $this->session->set_flashdata('errormessage', 'User does not exist');
                redirect('welcome/index');
            }
        } else {
            $this->session->set_flashdata('errormessage', 'Please fill all required fields');
            redirect('welcome/index');
        }

    }

    public function userregistration()
    {
        $this->data['title'] = "User Registration";
        $this->load->view('userregistration', $this->data, FALSE);
    }
    public function userregistrationprocess()
    {
        $this->load->model('registrations_model', 'usrrg');

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $alternatephone = $this->input->post('alternatephone');
        $businessname = $this->input->post('businessname');
        $businesstype = $this->input->post('businesstype');
        $gstnumber = $this->input->post('gstnumber');
        $address = $this->input->post('address');
        $notes = $this->input->post('notes');

        $acceptterms = $this->input->post('acceptterms');

        $curdate = date('Y-m-d H:i:s');

        if($acceptterms)
        {
            /*$checkemail = $this->usrrg->checkemailexists($email);
            $checkphone = $this->usrrg->checkphoneexists($phone);*/

            $insert = $this->usrrg->insert(array(
                'rg_firstname' => $firstname,
                'rg_lastname' => $lastname,
                'rg_email' => $email,
                'rg_phone' => $phone,
                'rg_alternatephone' => $alternatephone,
                'rg_typeofbusiness' => $businesstype,
                'rg_nameofbusiness' => $businessname,
                'rg_gstno' => $gstnumber,
                'rg_address' => $address,
                'rg_notes' => $notes,
                'rg_registrationdate' => $curdate,
                'rg_status' => 0,
                'rg_ispayment' => 0,
                'rg_updatedon' => $curdate
            ), TRUE);

            if($insert)
            {

                /***** Email option *********/
                $senderMail = 'info@artcl.in';

                $from    = "Artcl <info@artcl.in>";
                $headers = "From: $from";

                $to = 'dipeesh.27@gmail.com,info@artcl.in,prashobhchandra@artcl.cloud,prashobhchandra@gmail.com';
                $subject = "New registration from use Artcl.";

                $message = "Name: " . $firstname . " " . $lastname . "<br/>";
                $message = $message . "Email: " . $email . "<br/>";
                $message .= "Phone: " . $phone . "<br/>";
                $message .= "Alternate Phone: " . $alternatephone . "<br/>";
                $message .= "Business Type: " . $businesstype . "<br/>";
                $message .= "Business Name: " . $businessname . "<br/>";
                $message .= "GST/VAT: " . $gstnumber . "<br/>";
                $message .= "Address : " . $address . "<br/>";
                $message .= "Note: " . $notes . "<br/>";
                $message .= "Registration Date: " . $curdate . "<br/>";

                // boundary 
                $semi_rand = md5(time()); 
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

                // headers for attachment 
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

                // multipart boundary 
                $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
             
               
                $message .= "--{$mime_boundary}--";
                $returnpath = "-f" . $senderMail;

                //send email
                $mail = @mail($to, $subject, $message, $headers, $returnpath); 
                /******* Email option end *********/

                $this->session->set_flashdata('success', 'Success.');
                redirect('welcome/userregistrationsuccess/'.$insert);
            }else{
                $this->session->set_flashdata('errormessage', 'Error occured, please try again.');
                redirect('welcome/userregistration');
            }
        }else{
            $this->session->set_flashdata('errormessage', 'Please accept terms & conditions.');
                redirect('welcome/userregistration');
        }
    }
    public function userregistrationsuccess($regid)
    {
        $this->data['title'] = "User Registration";
        $this->load->view('userregistrationsuccess', $this->data, FALSE);
    }

    public function changepassword() {
        $this->data['vendorjs']        = array('parsleyjs/parsley.min.js');
        $this->data['commonjs']        = array('customscriptfiles.js');
        $this->data['scriptfunctions'] = array('changepassword();');
        $this->data['title']           = "Change Password";
        $this->load->template('changepassword', $this->data, FALSE);

    }

    public function changepasswordprocess() {
        $password     = $this->input->post('password', TRUE);
        $confpassword = $this->input->post('confpassword', TRUE);

        if ($password != "" && $confpassword != "") {

            if ($password == $confpassword) {

                $date = date('Y-m-d H:i:s');

                $saltstudent  = $this->usersigin->getrowbyid($this->loggeduserid)->at_salt;
                $userpassword = md5($password . $saltstudent);

                $this->usersigin->update_status_by(
                    array(
                        'at_authid' => $this->loggeduserid,
                    ),
                    array(
                        'at_disptp' => $userpassword
                    )
                );

                $this->session->set_flashdata('successmessage', 'Password Changed successfully');

                $session_id = $this->session->userdata('usertype');

                if ($session_id) {
                    switch ($session_id) {
                    case '1':
                        $redirect = "admin";
                        break;
                    case '2':
                        $redirect = "welcome";
                        break;
                    case '3':
                        $redirect = "club";
                        break;
                    }
                }
                
                $this->session->set_flashdata('messageS', 'Password Changed successfully');
            } else {
                $this->session->set_flashdata('messageE', 'Confirm password and password should be same');
            }
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('welcome/changepassword', 'refresh');

    }

    public function testingemail() {
        sendemailusingses('dipeesh.nova@gmail.com', 'hello', 'sample email');
    }

    public function forgetpassword() {
        $this->data['title'] = "forget password";
        $this->load->signintemplate('forgetpassword', $this->data, FALSE);

    }

    public function forgetpasswordrequest() {

        $username = $this->security->xss_clean($this->input->post('username'));

        if ($this->input->is_ajax_request()) {
            if ($username != "") {

                $success = $this->usersigin->getuserdetails(array('AES_DECRYPT(at_disptu,"' . EncriptKey . '")' => $username, 'at_isactive' => '0'));

                if ($success && $success->at_authid > 0) {

                    $userinsertiondata = array(
                        'au_passwordreset' => '1',

                    );
                    $userregistration = $this->usersigin->update_status_by(array('at_authid' => $success->at_authid), $userinsertiondata);

                    $this->load->library('email');

                    $this->data['firstname'] = $success->at_disptn;
                    $this->data['lastname']  = $success->au_cricks;
                    $this->data['authid']    = $success->at_authid;
                    $this->data['auth']      = $this->checksumgen($success->at_authid);

                    $result = sendemailusingses($success->at_disptu, 'Reset Password Request ' . WEBSITE_NAME . '', $this->load->view('welcome/forgetpasswordemail', $data, true));
                    if ($result) {
                        $result = array('status' => 'Yes', 'Message' => 'Reset password link sent to your email address');
                    } else {
                        $result = array('status' => 'No', 'Message' => 'Failed to generate reset password link,Please try again.');
                    }

                } else {

                    $this->session->set_flashdata('errormessage', 'Username/Email does not exist');
                    $result = array('status' => 'No', 'Message' => 'Username/Email does not exist');
                }
            } else {
                $this->session->set_flashdata('errormessage', 'Please fill all required fields');
                $result = array('status' => 'No', 'Message' => 'Please fill all required fields');
            }
        } else {
            $this->session->set_flashdata('errormessage', 'Invalid request found');
            $result = array('status' => 'No', 'Message' => 'Invalid request found');
        }
        echo json_encode($result);
    }

    public function resetpassword($id, $auth) {

        if ($this->validchecksumcheck($id, $auth)) {
            $this->data['title'] = "reset password";

            $success = $this->usersigin->getuserdetails(array('at_authid' => $id, 'at_isactive' => '0'));

            if ($success->au_passwordreset == "1") {
                $this->data['authid'] = $success->at_authid;
                $this->data['auth']   = $auth;
                $this->load->template('resetpassword', $this->data, FALSE);

            } else {
                $this->session->set_flashdata('errormessage', 'Invalid reset password request');
                redirect('welcome');
            }
        } else {
            $this->session->set_flashdata('errormessage', 'Invalid reset password request');
            redirect('welcome');

        }

    }

    public function resetpasswordprocess() {
        $authid             = $this->security->xss_clean($this->input->post('authid'));
        $auth               = $this->security->xss_clean($this->input->post('auth'));
        $signuppassword     = $this->security->xss_clean($this->input->post('signuppassword'));
        $signupconfpassword = $this->security->xss_clean($this->input->post('signupconfpassword'));
        $error              = array();
        if (!isset($signuppassword) || $signuppassword == "") {
            $error['signuppassword'] = "New password required";
        }
        if (!isset($signupconfpassword) || $signupconfpassword == "") {
            $error['signupconfpassword'] = "Confirm password required";
        }
        if ($signupconfpassword != $signupconfpassword) {
            $error['signupconfpassword'] = "New password should be equal to confirm password";
        }
        if (!count($error)) {
            if ($this->input->is_ajax_request()) {
                if ($this->validchecksumcheck($authid, $auth)) {

                    $success = $this->usersigin->getuserdetails(array('at_authid' => $authid, 'at_isactive' => '0'));

                    if ($success && $success->at_authid > 0) {

                        $saltstudent      = random_string('alnum', 16);
                        $userpassword     = md5($signuppassword . $saltstudent);
                        $userregistration = $this->usersigin->update_status_by(array('at_authid' => $success->at_authid), array('au_crickp' => $userpassword, 'at_salt' => $saltstudent, 'au_passwordreset' => '0'));

                        if ($userregistration) {
                            $result = array('status' => 'Yes', 'Message' => 'Your password resetted successfully');
                        } else {
                            $result = array('status' => 'No', 'Message' => 'Failed to set new  password,Please try again.');
                        }

                    } else {

                        $this->session->set_flashdata('errormessage', 'User does not exist');
                        $result = array('status' => 'No', 'Message' => 'User does not exist');
                    }
                } else {
                    $this->session->set_flashdata('errormessage', 'Please fill all required fields');
                    $result = array('status' => 'No', 'Message' => 'Please fill all required fields');
                }
            } else {
                $this->session->set_flashdata('errormessage', 'Invalid request found');
                $result = array('status' => 'No', 'Message' => 'Invalid request found');
            }
        } else {
            $this->session->set_flashdata('errormessage', $error[0]);
            $result = array('status' => 'No', 'Message' => $error[0]);
        }
        echo json_encode($result);

    }

    public function generatenumericotp($n) {

        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    public function checkusernameexits() {

        if (!$this->input->is_ajax_request()) {
            exit(lang('no_access_url'));
        }

        $username = $this->security->xss_clean($this->input->post('username'));

        $success = $this->usersigin->getuserdetails(array('AES_DECRYPT(at_disptu,"' . EncriptKey . '")' => $username));

        if ($success && $success->at_authid > 0) {

            echo json_encode(false);

        } else {

            echo json_encode(true);
        }

    }

}
