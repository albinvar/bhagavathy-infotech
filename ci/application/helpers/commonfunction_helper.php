<?php

function generatenumericotp($n) {

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    // Return result
    return $result;
}

function pushnitificationfirebase($fields) {

    $headers = array(
        'Authorization:key=' . FIREBASEKEY,
        'Content-Type:application/json',
    );
    $path_to_firebase_cm = FIREBASEURL;
    $ch                  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (!function_exists('checkclubsubscribedornot')) {
    function checkclubsubscribedornot() {
        $CI = &get_instance();
        $CI->load->model('admin/Clubsubscription', 'clubsubs');
        $clubidauth  = $CI->session->userdata('clubidauth');
        $paymentdata = $CI->clubsubs->get_by(array('cs_clubid' => $clubidauth));

        if (!$paymentdata) {
            $CI->session->set_flashdata('nosubscription', 'Please subscribe our paid version to get more features.');
        } else if ($paymentdata->cs_paymentstatus == "0") {

            $CI->session->set_flashdata('nosubscriptionpayment', 'Please pay your subscription amount to get all features');
        }
    }
}

if (!function_exists('deletelocalstoragevalues')) {
    function deletelocalstoragevalues() {
        echo '<script type="text/javascript">
  window.localStorage.removeItem("nosubscription");
  window.localStorage.removeItem("nosubscriptionpayment");

  </script>';
    }
}

if (!function_exists('pagepermissionarraymerge')) {
    function pagepermissionarraymerge($array1 = array(), $array2 = array()) {
        if (is_array($array1)) {
            if (count($array1)) {
                $modulearray1         = array_unique($array1['moduleid']);
                $pageidarray1         = array_unique($array1['pageid']);
                $permissiontypearray1 = $array1['permissiontype'];
                if (!isset($array2)) {
                    $permissiontypearray = $permissiontypearray1;
                }
            }
        }
        if (is_array($array2)) {
            if (count($array2)) {
                $modulearray2         = array_unique($array2['moduleid']);
                $pageidarray2         = array_unique($array2['pageid']);
                $permissiontypearray2 = $array2['permissiontype'];

                if (!isset($array1)) {
                    $permissiontypearray = $permissiontypearray2;
                }
            }
        }

        if (is_array($array1) && is_array($array2)) {
            if (count($array1) > 0 && count($array2) > 0) {
                $modulearray         = array_merge($modulearray1, $modulearray2);
                $pageidarray         = array_merge($pageidarray1, $pageidarray2);
                $permissiontypearray = array_merge($permissiontypearray1, $permissiontypearray2);
            }
        }

        print_r($permissiontypearray);
    }
}
if (!function_exists('userauthmodulepermissions')) {
    function userauthmodulepermissions($clubid, $designation, $leaguedesignation) {

        $CI = &get_instance();
        $CI->load->model('facilities/Modulesnames', 'moduleite');
        $CI->load->model('facilities/Designationpagepermissions', 'desperm');
        $modulepermissions = $CI->desperm->usermodulepermissions($clubid, $designation, $leaguedesignation);
        $allmodules        = $CI->moduleite->get_many_by(array('modulestatus' => '0'));

        $moduleall = array();
        if ($allmodules) {

            foreach ($allmodules as $mod) {
                $moduleall[] = $mod->moduleid;
            }
        }
        $result = array_diff($moduleall, $modulepermissions);

        return $result;

    }

}

if (!function_exists('userauthmoduleshowingmenus')) {

    function userauthmoduleshowingmenus($clubid, $designation, $leaguedesignation) {

        $CI = &get_instance();
        $CI->load->model('facilities/Modulesnames', 'moduleite');
        $CI->load->model('facilities/Designationpagepermissions', 'desperm');
        $modulepermissions = $CI->desperm->usermodulepermissions($clubid, $designation, $leaguedesignation);
        $allmodules        = $CI->moduleite->get_many_by(array('modulestatus' => '0'));

        $moduleall      = array();
        $moduleallarray = array();
        if ($allmodules) {

            foreach ($allmodules as $mod) {
                $moduleall[]      = $mod->moduleid;
                $moduleallarray[] = array(
                    'moduleid'   => $mod->moduleid,
                    'modulename' => $mod->modulename);
            }
        }

        $result = array_diff($moduleall, $modulepermissions);

        $returnrray = array(
            'permissionmodules'    => $modulepermissions,
            'allmodule'            => $moduleallarray,
            'modulealllist'        => $moduleall,
            'nonpermissionmodules' => $result,
        );

        return $returnrray;

    }

}
if (!function_exists('sendemailusingses')) {

    function sendemailusingses($toemail, $subject, $data) {
        $CI = &get_instance();
        $CI->load->library('email');

        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://email-smtp.eu-west-1.amazonaws.com';
        $config['smtp_port'] = '465';

        $config['smtp_user'] = 'AKIAQHH3AOFG4FU5NFPW';
        $config['smtp_pass'] = 'BCotTTW3emOOphYsTf0ks+/oigC0e4ushaBPZkG2EU+z';
        $config['newline']   = "\r\n";
        $config['mailtype']  = 'html';

        $CI->email->initialize($config);
        $CI->email->from(ADMIN_EMAIL, SITE_NAME);
        $CI->email->to($toemail);
        $CI->email->subject($subject);
        $CI->email->message($data);
        $sendmessage = $CI->email->send();
        return $sendmessage;
    }
}

if (!function_exists('sendemailusingsesattachment')) {

    function sendemailusingsesattachment($toemail, $subject, $data, $attachmentpath, $cc = "") {
        $CI = &get_instance();
        $CI->load->library('email');

        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://email-smtp.eu-west-1.amazonaws.com';
        $config['smtp_port'] = '465';

        $config['smtp_user'] = 'AKIAQHH3AOFG4FU5NFPW';
        $config['smtp_pass'] = 'BCotTTW3emOOphYsTf0ks+/oigC0e4ushaBPZkG2EU+z';
        $config['newline']   = "\r\n";
        $config['mailtype']  = 'html';

        $CI->email->initialize($config);
        $CI->email->from(ADMIN_EMAIL, SITE_NAME);
        $CI->email->to($toemail);
        if ($cc != "") {
            $CI->email->cc($cc);
        }
        $CI->email->subject($subject);
        $CI->email->message($data);
        $CI->email->attach($attachmentpath);
        $sendmessage = $CI->email->send();
        return $sendmessage;
    }
}

if (!function_exists('playerprofiledetailsfetch')) {

    function playerprofiledetailsfetch($playerid) {
        $CI = &get_instance();
        $CI->load->model('player/Clubplayerregfeepayment', 'crfp');
        $CI->load->model('welcome/userauthentication_model', 'usersigin');
        $CI->load->model('facilities/Clubleagues', 'league');
        $CI->load->model('facilities/Playerleague', 'plaleag');
        $CI->load->model('admin/Clubs', 'clubs');
        $success = $CI->usersigin->getuserdetails(array('at_authid' => $playerid, 'at_isactive' => '0'));

        $plaleag          = $CI->plaleag->get_by(array('pl_playerid' => $success->at_authid, 'pl_status' => '0'));
        $playerleaguename = "";
        if ($plaleag) {

            $playerleaguedata = $CI->league->get_by(array('clubleagueid' => $plaleag->pl_leagueid, 'cl_status' => '0'));
            if ($playerleaguedata) {

                $playerleaguename = $playerleaguedata->cl_leaguename;
            }
        }
        $registrationfee     = $CI->crfp->get_by(array('crfp_playerid' => $success->at_authid, 'crfp_clubid' => $success->au_clubid));
        $crpf_paystatus      = "0";
        $crfp_payamount      = "0";
        $clubregfeepaymentid = "0";
        if ($registrationfee) {

            if (isset($registrationfee->crpf_paystatus)) {
                $crpf_paystatus = strval($registrationfee->crpf_paystatus);
            } else {
                $crpf_paystatus = "0";
            }

            if (isset($registrationfee->crfp_payamount)) {
                $crfp_payamount = $registrationfee->crfp_payamount;
            } else {
                $crfp_payamount = "0";
            }

            if (isset($registrationfee->clubregfeepaymentid)) {
                $clubregfeepaymentid = $registrationfee->clubregfeepaymentid;
            } else {
                $clubregfeepaymentid = "0";
            }
        }
        $albumpathfolder = FOLDERPATH . '/club';
        $image           = ($success->at_logo != "") ? base_url() . $albumpathfolder . '/' . $success->at_logo : base_url() . 'components/images/faces/user.png';
        $clublogo        = $CI->clubs->get_by(array('clubid' => $success->au_clubid));
        $clublogoimage   = ($clublogo->cb_logo != "") ? base_url() . FOLDERPATH . '/facilities/' . $clublogo->cb_logo : base_url() . 'components/images/faces/user.png';
        $data            = array(
            'playerid'         => $success->at_authid,
            'authenticationid' => $success->au_userappauthid,
            'firstname'        => $success->at_disptn,
            'surname'          => $success->at_dispti . ' ' . $success->au_cricks,
            'email'            => $success->at_dispte,
            'contactnumber'    => $success->at_disptpn,
            'at_logo'       => $image,
            'clublogo'         => $clublogoimage,
            'clubid'           => $success->au_clubid,
            'clubname'         => $clublogo->cb_clubname,
            'paymentstatus'    => strval($crpf_paystatus),
            'payamount'        => strval($crfp_payamount),
            'regpaymentrefid'  => strval($clubregfeepaymentid),
            'leagueid'         => ($plaleag) ? $plaleag->pl_leagueid : '',
            'leaguename'       => $playerleaguename,
        );

        return $data;

    }

}
