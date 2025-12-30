<?php

class MY_Controller extends CI_Controller {
    public $CI;
    protected $data;
    public $title = '';
    public $userlogged_data;
    public $loggeduserid;
    public $checkloginid;
    public $paymentstatus;
    public $businessid;
    public $buid;
    public $accyearid;
    public $accyeardetails;
    public $desigpagepermissions;
    public $designation;

    public $finyearid;
    public $finstartdate;
    public $finenddate;
    public $finname;

    public $userrole;

    public $currency;
    public $currencysymbol;
    public $presufsymbol;
    public $decimalpoints;
    public $taxband;
    public $topbusinessunitdet;

    public $modulepermissions;
    public $pagePermissions;

    public $permissionmodulearrayspages;

    public $inventorysettings;

    public $todaydate;
    public $updatedon;

    public $withoutlogin;
    public $composittax;
    public $isvatgst;
    public $isvatgstname;

    public $godownid;

    public function __construct() {
        
        $flg = 0;

        date_default_timezone_set('Asia/Kolkata');

        parent::__construct();

        $this->data = [];

        $this->data['controller_name'] = $this->router->class;
        $this->data['method_name']     = $this->router->method;

        $this->load->helper('language');

        $this->lang->load(['common_errors', 'common_styles'], 'english');


        $this->todaydate = current_date_mysqlformat();
        $this->updatedon = get_updated_on();
        $this->CI        = &get_instance();

        $this->loggeduserid = $this->session->userdata('authenticationid');
        $this->businessid   = $this->session->userdata('businessid');
        $this->buid   = $this->session->userdata('buid');
        $this->godownid = $this->session->userdata('godownid');

        $this->finyearid   = $this->session->userdata('finyearid');
        $this->finstartdate   = $this->session->userdata('finstartdate');
        $this->finenddate   = $this->session->userdata('finenddate');
        $this->finname   = $this->session->userdata('finname');

        $this->currency   = $this->session->userdata('currency');
        $this->currencysymbol   = $this->session->userdata('currencysymbol');
        $this->presufsymbol = $this->session->userdata('presufsymbol');
        $this->decimalpoints = $this->session->userdata('decimalpoints');
        $this->taxband = $this->session->userdata('taxband');

        $this->checkloginid = $this->checksumgen($this->session->userdata('authenticationid'));
        $this->designation  = $this->session->userdata('designation');

        $this->userrole = $this->session->userdata('usertype');

        // $this->folderpath = trim($this->session->userdata('folderpath'),'./');

        $this->load->model('admin/businessunit_model', 'busunt');
        if ($this->userrole == 2) {
            $this->data['topbusinessunitdet'] = $this->topbusinessunitdet = $topbusinessunitdet = $this->busunt->getactiverows($this->businessid);
        } else {
            $this->data['topbusinessunitdet'] = $this->topbusinessunitdet = $topbusinessunitdet = $this->busunt->getuseractivebuints($this->businessid, $this->loggeduserid);
        }

        if ($this->buid == "") {
            if ($topbusinessunitdet) {
                $this->session->set_userdata('buid', $topbusinessunitdet[0]->bu_businessunitid);
                $this->buid = $topbusinessunitdet[0]->bu_businessunitid;
                if ($topbusinessunitdet) {
                    $this->global_bu_name = $topbusinessunitdet[0]->bu_unitname;
                    $this->gstno  = $topbusinessunitdet[0]->bu_gstnumber;
                    $this->currencyid = $topbusinessunitdet[0]->bu_currencyid;
                    $this->bulogo = $topbusinessunitdet[0]->bu_logo;
                    $this->currency = $topbusinessunitdet[0]->ap_showcurrency;
                    $this->currencysymbol = $topbusinessunitdet[0]->currency_symbol;
                    $this->presufsymbol = $topbusinessunitdet[0]->ap_sufprefixsymbol;
                    $this->decimalpoints = $topbusinessunitdet[0]->ap_noofdecimal;

                    $this->withoutlogin = $topbusinessunitdet[0]->bu_withoutlogin;
                    $this->composittax = $topbusinessunitdet[0]->bu_composittax;
                    $this->isvatgst = $topbusinessunitdet[0]->bu_isvat;

                    $this->session->set_userdata('currency', $topbusinessunitdet[0]->ap_showcurrency);
                    $this->session->set_userdata('currencysymbol', $topbusinessunitdet[0]->currency_symbol);
                    $this->session->set_userdata('presufsymbol', $topbusinessunitdet[0]->ap_sufprefixsymbol);
                    $this->session->set_userdata('decimalpoints', $topbusinessunitdet[0]->ap_noofdecimal);
                }
            }

        } else {
            $toppremdetail              = $this->busunt->getbusinessunitdetails($this->buid);
            $this->global_bu_name = $toppremdetail->bu_unitname;
            $this->gstno  = $toppremdetail->bu_gstnumber;
            $this->currencyid = $toppremdetail->bu_currencyid;
            $this->bulogo = $toppremdetail->bu_logo;
            $this->currency   = $toppremdetail->ap_showcurrency;
            $this->currencysymbol   = $toppremdetail->currency_symbol;
            $this->presufsymbol = $toppremdetail->ap_sufprefixsymbol;
            $this->decimalpoints = $toppremdetail->ap_noofdecimal;

            $this->withoutlogin = $toppremdetail->bu_withoutlogin;
            $this->composittax = $toppremdetail->bu_composittax;
            $this->isvatgst = $toppremdetail->bu_isvat;

            $this->session->set_userdata('currency', $toppremdetail->ap_showcurrency);
            $this->session->set_userdata('currencysymbol', $toppremdetail->currency_symbol);
            $this->session->set_userdata('presufsymbol', $toppremdetail->ap_sufprefixsymbol);
            $this->session->set_userdata('decimalpoints', $toppremdetail->ap_noofdecimal);
        }

        if($this->isvatgst == 0)
        {
            $this->isvatgstname = 'GST';
        }else{
            $this->isvatgstname = 'VAT';
        }

        if($this->finyearid == "")
        {
            $this->load->model('business/financialyears_model', 'fnyr');
            $finyeardetails = $this->fnyr->getcurrentfinancialyear($this->buid);
            if($finyeardetails)
            {
                $this->finyearid = $finyeardetails->ay_financialyearid;
                $this->finstartdate = $finyeardetails->ay_startdate;
                $this->finenddate = $finyeardetails->ay_enddate;
                $this->finname = $finyeardetails->ay_financialname;
            }
        }

        if($this->currency == 1)
        {
            $this->showcurrency = $this->currencysymbol;
        }else{
            $this->showcurrency = "";
        }

        $this->load->model('inventory/inventorysettings_model', 'invset');
        $this->data['inventorysettings'] = $this->invset->getinventorysettings($this->buid);

        $this->data['buid'] = $this->buid;

        // echo 'User role = ' . $this->userrole;exit;


        $pages = array(
            array('c' => 'welcome', 'm' => 'index'),
            array('c' => 'website', 'm' => 'contactus'),
            array('c' => 'welcome', 'm' => 'signinauthentication'),
            array('c' => 'welcome', 'm' => 'register_email_exists'),
            array('c' => 'welcome', 'm' => 'forgotpassword'),
            array('c' => 'welcome', 'm' => 'forgotpasswordprocess'),
            array('c' => 'welcome', 'm' => 'reset_login_password'),
            array('c' => 'welcome', 'm' => 'nojsavailable'),
            array('c' => 'welcome', 'm' => 'playerregistration'),
            array('c' => 'admin', 'm' => 'checkemail'),

            array('c' => 'welcome', 'm' => 'testingemail'),
            array('c' => 'welcome', 'm' => 'forgetpassword'),
            array('c' => 'welcome', 'm' => 'forgetpasswordrequest'),
            array('c' => 'welcome', 'm' => 'resetpassword'),
            array('c' => 'welcome', 'm' => 'signinusingauth'),
            array('c' => 'welcome', 'm' => 'resetpasswordprocess'),

            array('c' => 'welcome', 'm' => 'validchecksumcheck'),
            array('c' => 'dispatch', 'm' => 'invoiceexport'),
            array('c' => 'welcome', 'm' => 'userregistration'),
            array('c' => 'welcome', 'm' => 'userregistrationprocess'),
            array('c' => 'welcome', 'm' => 'userregistrationsuccess'),

        );

        foreach ($pages as $page) {
            $flg = 0;
            if ($this->data['controller_name'] == $page['c'] && $this->data['method_name'] == $page['m']) {
                $flg = 1;
                break;
            }
        }

        // var_dump($flg);exit;

        if ($flg == 0) {
            $this->check_isvalidated();

            $session_id = $this->session->userdata('authenticationid');

            if ($session_id) {

                $this->load->model('welcome/userauthentication_model', 'usersignin');
                $this->userlogged_data = $this->usersignin->getuserdetails(array('at_authid' => $session_id));
                

            }
        }


        // session vars
        $permissionmodulearrayspages = $this->session->userdata('permissionmodulearrayspages');

        // var_dump($permissionmodulearrayspages); exit;

        $this->permissionmodulearrayspages = $this->data['permissionmodulearrayspages'] = (array) $permissionmodulearrayspages;

        if($this->userrole == 1) {
            $imgsrc = base_url('components/images/faces/user.png');
        } else {
            $imgsrc = get_employee_img_url($this->session->userdata('profilepic'), $this->session->userdata('profilesalt'));
        }

        $this->data['profile_pic'] = $imgsrc;

        $notificationcount = 0;

        $this->data['notificationcount'] = $notificationcount;



    }

    public function render($content, $view = 'signindashboard/basic_view') {

        $this->data['content'] = &$content;

        $this->load->view("$view", $this->data);

    }

    public function dashboardrender($content, $view = 'userdashboard/base_view') {

        $this->data['content'] = &$content;

        $this->load->view("$view", $this->data);

    }

    public function framerender($content, $view = 'userdashboard/frame_view') {

        $this->data['content'] = &$content;

        $this->load->view("$view", $this->data);

    }

    private function check_isvalidated() {

        $session_id = $this->session->userdata('authenticationid');
        if ($session_id == false) {
            redirect('welcome/index');
        }

    }

    public function do_logout() {
        $this->session->sess_destroy();

        

        redirect('welcome/index');
    }

    public function checksumgen($val) {
        $checksum = sha1(HASHCODE . $val);
        return $checksum;
    }

    protected function validchecksumcheck($id, $hash) {

        $checksum = sha1(HASHCODE . $id);
        if ($id != '' && $hash != '') {
            if ($hash != $checksum) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function time_ago($timestamp) {
        $time_ago        = strtotime($timestamp);
        $current_time    = time();
        $time_difference = $current_time - $time_ago;
        $seconds         = $time_difference;
        $minutes         = round($seconds / 60); // value 60 is seconds
        $hours           = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
        $days            = round($seconds / 86400); //86400 = 24 * 60 * 60;
        $weeks           = round($seconds / 604800); // 7*24*60*60;
        $months          = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
        $years           = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return "Just Now";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } else if ($weeks <= 4.3) //4.3 == 52/12
        {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        } else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }

    // public function pushnitificationfirebase($fields)
    // {

    //     $headers = array(
    //         'Authorization:key=' . FIREBASEKEY,
    //         'Content-Type:application/json',
    //     );
    //     $path_to_firebase_cm = FIREBASEURL;
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     return $result;

    // }

    protected function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->data = curl_exec($ch);
        curl_close($ch);
        return $this->data;
    }

}
