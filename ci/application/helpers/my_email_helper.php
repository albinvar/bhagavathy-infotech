<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function multi_attach_mail($to, $subject, $message, $files = [], $senderMail = "info@compliancemonitoringsystem.com", $senderName = "Firesafetyonlineweb") {

    // sendemailusingses($to, $subject, $message, $files);
    // return true;

    $from    = $senderName . " <" . $senderMail . ">";
    $headers = "From: $from";

    // boundary
    $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";

    /*$files = array(
    FCPATH . '/public/upload/email-attachments/10_023519d79b28b781daf41965a8e108c6.jpg',FCPATH . '/public/upload/email-attachments/datatables_57f5431d6dcfdafbeb03a536aaa6ba09.css'

    );*/

    // preparing attachments
    if (count($files) > 0) {
        for ($i = 0; $i < count($files); $i++) {
            if (is_file($files[$i])) {
                $message .= "--{$mime_boundary}\n";
                $fp   = @fopen($files[$i], "rb");
                $data = @fread($fp, filesize($files[$i]));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"" . basename($files[$i]) . "\"\n" .
                "Content-Description: " . basename($files[$i]) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($files[$i]) . "\"; size=" . filesize($files[$i]) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
    }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $senderMail;

    //send email
    $mail = @mail($to, $subject, $message, $headers, $returnpath);
    // $mail = @mail('rahul.nova.bin@gmail.com', "This is test", $message, $headers, $returnpath);

    //function return true, if email sent, otherwise return fasle
    if ($mail) {return TRUE;} else {return FALSE;}

}

function send_mail_fun($to, $subject, $message, $senderMail = "info@compliancemonitoringsystem.com", $senderName = WEBSITE_NAME) {
    $from    = $senderName . " <" . $senderMail . ">";
    $headers = "From: $from";

    // boundary
    $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";

    /*$files = array(
    FCPATH . '/public/upload/email-attachments/10_023519d79b28b781daf41965a8e108c6.jpg',FCPATH . '/public/upload/email-attachments/datatables_57f5431d6dcfdafbeb03a536aaa6ba09.css'

    );*/

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $senderMail;

    //send email
    $mail = @mail($to, $subject, $message, $headers, $returnpath);
    // $mail = @mail('rahul.nova.bin@gmail.com', "This is test", $message, $headers, $returnpath);

    //function return true, if email sent, otherwise return fasle
    if ($mail) {return TRUE;} else {return FALSE;}

}

function message_format($message) {
    $CI =& get_instance();
    $bc = $CI->session->userdata('panelcolor');
    $message = '<div style="padding:10px;">
        <div style="background-color:#F8F8F8; padding: 10px;">
        <div style="background-color: ' . $bc .  ';padding: 5px;"">
        <img src="' . base_url('components/img/logo.png') . '" width="50" height="50"></div>
        <div style="width:100%; border-top:1px solid #1D89CD; height:2px;"></div>
        <p style="margin-left:10px;">
        ' . $message . '
        </p>
        </div>
        </div>';

    return $message;
}



if (!function_exists('sendemailusingses')) {

    function sendemailusingses($toemail, $subject, $data, $attachmentpath = []) {
        if (get_host_name() == 'localhost') {
            return true;
        }
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
        $CI->email->from('hosting@novahealthcare.ie', SITE_NAME);
        $CI->email->to($toemail);
        $CI->email->subject($subject);
        $CI->email->message($data);

        if (!empty($attachmentpath)) {
            foreach ($attachmentpath as $value) {
                $CI->email->attach(FCPATH . $value);
            }

        }

        $sendmessage = $CI->email->send();
        return $sendmessage;
    }
}
