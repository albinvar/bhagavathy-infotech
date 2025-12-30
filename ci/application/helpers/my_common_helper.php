<?php

function getversion() {
    return 123456789;
}

function get_host_name() {
    return $_SERVER['HTTP_HOST'];
}

function show_currency_amount($amnt)
{
    $ci = &get_instance();
    $amount = number_format((float)$amnt, $ci->session->userdata('decimalpoints'), '.', '');
    //$amount = $amnt;
    if($ci->session->userdata('currency') == 1)
    {
        if($ci->session->userdata('presufsymbol') == 1)
        {
            $amount =  $amount . " " . $ci->session->userdata('currencysymbol');
        }
        else{
            $amount = $ci->session->userdata('currencysymbol') . " " . $amount;
        }
    }else{
        $amount = $amount;
    }
    return $amount;
}

function price_roundof($amnt)
{
    $ci = &get_instance();
    $amount = number_format((float)$amnt, $ci->session->userdata('decimalpoints'), '.', '');
    return $amount;
}

function convert_numbertowords($figure) {
        if (($figure < 0) || ($figure > 999999999)) {
            throw new Exception("Your Number is out of range");
        }
        $giga = floor($figure / 1000000);
        // Millions (giga)
        $figure -= $giga * 1000000;
        $kilo = floor($figure / 1000);
        // Thousands (kilo)
        $figure -= $kilo * 1000;
        $hecto = floor($figure / 100);
        // Hundreds (hecto)
        $figure -= $hecto * 100;
        $deca = floor($figure / 10);
        // Tens (deca)
        $n = $figure % 10;
        // Ones
        $result = "";
        if ($giga) {
            $result .= convert_numbertowords($giga) .  "Million";
        }
        if ($kilo) {
            $result .= (empty($result) ? "" : " ") .convert_numbertowords($kilo) . " Thousand";
        }
        if ($hecto) {
            $result .= (empty($result) ? "" : " ") .convert_numbertowords($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) {
                $result .= " and ";
            }
            if ($deca < 2) {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) {
            $result = "zero";
        }
        return $result;
    }

function assets_url($val = '') {
    if ($val) {
        return base_url($val);
    }
    return base_url();
}

function getipaddress() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function mandatory() {
    return '<span style="color:#ff0000 !important;">*</span>';
}

/*
creates a directory if not exists and sets the required permission;
default is write permission

 */

function create_directory($path, $permission = 0777) {

    if ($path) {
        if (!is_dir($path)) {
            try {
                $old_umask = umask(0);
                @mkdir('./' . $path, $permission, TRUE); // RECURSIVE TRUE (THIRD ARGUMENT);
                @copy('./uploads/index.html', $path . 'index.html');
                umask($old_umask);
            } catch (ErrorException $ex) {
                return ['status' => 1, 'msg' => $ex->getMessage()];
            }
        }
        return ['status' => 0];
    }
    return ['status' => 1, 'msg' => 'Path not there.'];
}

function path_not_set($stat) {
    $CI = &get_instance();
    if ($stat['status'] == 1) {
        $CI->session->set_flashdata('messageE', $stat['msg']);
    }
}

function get_login_id() {
    $ci = &get_instance();
    if ($ci->session->userdata('loginid') != "") {
        $updatedby = $ci->session->userdata('loginid');
    } else {
        $updatedby = 1;
    }
    return $updatedby;

}

function alert_messages() {
    $CI = &get_instance();
    if ($CI->session->flashdata('messageS') != "") {

        return array('success', $CI->session->flashdata('messageS'));

    } elseif ($CI->session->flashdata('messageE') != "") {

        return array('error', $CI->session->flashdata('messageE'));

    } elseif ($CI->session->flashdata('messageW') != "") {

        return array('warning', $CI->session->flashdata('messageW'));

    } elseif ($CI->session->flashdata('messageI') != "") {

        return array('info', $CI->session->flashdata('messageI'));
    } else {
        return false;
    }

}

function show_messages() {
    $CI = &get_instance();
    if ($CI->session->flashdata('messageS') != "") {

        return '<div  class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        ' . $CI->session->flashdata('messageS') . '
        </div>';
    } elseif ($CI->session->flashdata('messageE') != "") {

        return '<div  class="alert alert-error fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        ' . $CI->session->flashdata('messageE') . '
        </div>';

    } elseif ($CI->session->flashdata('messageW') != "") {

        return '<div  class="alert alert-warning fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        ' . $CI->session->flashdata('messageW') . '
        </div>';

    } elseif ($CI->session->flashdata('messageI') != "") {

        return '<div  class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        ' . $CI->session->flashdata('messageI') . '
        </div>';
    }

}

function default_image() {
    return base_url('components/img/photos/24.jpg');
}


function default_profile_image() {
    return base_url('components/img/profile-pic.jpg');
}

function user_image($value, $salt = '', $attributes = false) {
    if (!empty($value)) {
        $src = base_url() . 'uploads/userimage/' . $salt . '/' . $value;
        if (file_exists('./uploads/userimage/' . $salt . '/' . $value) === false) {
            $src = default_profile_image();
        }
    } else {
        $src = default_profile_image();
    }

    $img = '<img src="' . $src . '" ';

    if (is_array($attributes)) {
        foreach ($attributes as $key => $value) {
            $img .= $key . '="' . $value . '"';
        }
    }

    $img .= ' >';

    return $img;
}

function get_employee_img_url($value = '', $salt = '') {
    if (!empty($value)) {
        $src = base_url() . 'uploads/userimage/' . $salt . '/' . $value;
        if (file_exists('./uploads/userimage/' . $salt . '/' . $value) === false) {
            $src = default_profile_image();
        }
    } else {
        $src = default_profile_image();
    }

    return $src;
}
function get_resident_img_url($value) {
    if (!empty($value)) {
        $src = base_url() . 'uploads/resident/' .  $value;
        if (file_exists('./uploads/resident/' . $value) === false) {
            $src = default_profile_image();
        }
    } else {
        $src = default_profile_image();
    }

    return $src;
}

function get_img_url($value = '', $folder = '') {
    if (!empty($value)) {
        $src = base_url() . 'uploads/' . $folder . '/' . $value;
        if (file_exists('./uploads/' . $folder . '/' . $value) === false) {
            $src = default_profile_image();
        }
    } else {
        $src = default_profile_image();
    }

    return $src;
}

function resident_image($value, $attributes = false) {
    if (!empty($value)) {
        $src = base_url() . 'uploads/resident/' . '/' . $value;
        if (file_exists('./uploads/resident/' . '/' . $value) === false) {
            $src = default_profile_image();
        }
    } else {
        $src = default_profile_image();
    }

    $img = '<img src="' . $src . '" ';

    if (is_array($attributes)) {
        foreach ($attributes as $key => $value) {
            $img .= $key . '="' . $value . '"';
        }
    }

    $img .= ' >';

    return $img;
}

if (!function_exists('linktag')) {
    function linktag($src = '') {
        return '<link href="' . assets_url($src) . '" rel="stylesheet">';
    }
}

if (!function_exists('script_tag')) {
    function script_tag($src = '', $language = 'javascript', $type = 'text/javascript', $index_page = FALSE) {
        $CI     = &get_instance();
        $script = '<scr' . 'ipt';
        if (is_array($src)) {
            foreach ($src as $k => $v) {
                if ($k == 'src' AND strpos($v, '://') === FALSE) {
                    if ($index_page === TRUE) {
                        $script .= ' src="' . assets_url($v) . '"';
                    } else {
                        $script .= ' src="' . $CI->config->slash_item('base_url') . $v . '"';
                    }
                } else {
                    $script .= "$k=\"$v\"";
                }
            }

            $script .= "></scr" . "ipt>\n";
        } else {
            if (strpos($src, '://') !== FALSE) {
                $script .= ' src="' . $src . '" ';
            } elseif ($index_page === TRUE) {
                $script .= ' src="' . assets_url($src) . '" ';
            } else {
                $script .= ' src="' . $CI->config->slash_item('base_url') . $src . '" ';
            }

            $script .= 'language="' . $language . '" type="' . $type . '"';
            $script .= ' /></scr' . 'ipt>' . "\n";
        }
        return $script;
    }
}

function listing_actions_styles($assessmentpagepermissionarray = [], $usertype = 0) {

    if ($usertype == 2) {

        $output = '<style>';
        if (!empty($assessmentpagepermissionarray)) {
            if (!in_array(1, $assessmentpagepermissionarray)) {
                $output .= '.add-permission { display: none !important; }';

            }
            if (!in_array(2, $assessmentpagepermissionarray)) {
                $output .= '.view-permission {  display: none !important; }';

            }
            if (!in_array(3, $assessmentpagepermissionarray)) {
                $output .= '.edit-permission {  display: none !important; }';

            }
            if (!in_array(4, $assessmentpagepermissionarray)) {
                $output .= '.delete-permission { display: none !important;} ';

            }
            if (!in_array(5, $assessmentpagepermissionarray)) {
                $output .= '.export-permission { display: none !important;}';

            }
            if (!in_array(6, $assessmentpagepermissionarray)) {
                $output .= '.review-permission{ display: none !important;}';

            }
        } elseif ($assessmentpagepermissionarray == "" || count_variable($assessmentpagepermissionarray) <= 0) {

            $output .= '.add-permission { display: none !important;}';
            $output .= '.view-permission { display: none !important;} ';
            $output .= '.edit-permission { display: none !important; }';
            $output .= '.delete-permission {display: none !important; }';
            $output .= '.export-permission { display: none !important; } ';
            $output .= '.review-permission { display: none !important; } ';

        }
        $output .= '</style>';

        return $output;

    }

}

// removes white spaces & other special charaters

function clean_filename($filename) {
    return preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($filename));
}

function check_ajax_call() {
    $CI =& get_instance();
    if(!$CI->input->is_ajax_request()) {
        show_404();
    }
}