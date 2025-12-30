<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
    #https://stackoverflow.com/questions/9540576/header-and-footer-in-codeigniter
    public function admintemplate($template_name, $vars = array(), $return = FALSE) {
        if ($return):
            $content = $this->view('userdashboard/header', $vars, $return);
            $content = $this->view('userdashboard/menu', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('userdashboard/footer', $vars, $return);

            return $content;
        else:
            $this->view('userdashboard/header', $vars);
            $this->view('userdashboard/menu', $vars);
            $this->view($template_name, $vars);
            $this->view('userdashboard/footer', $vars);
        endif;
    }

    public function template($template_name, $vars = array(), $return = FALSE) {
        if ($return):
            $content = $this->view('userdashboard/header', $vars, $return);
            $content = $this->view('userdashboard/businessmenu', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('userdashboard/footer', $vars, $return);

            return $content;
        else:
            $this->view('userdashboard/header', $vars);
            $this->view('userdashboard/businessmenu', $vars);
            $this->view($template_name, $vars);
            $this->view('userdashboard/footer', $vars);
        endif;
    }

    public function signintemplate($template_name, $vars = array(), $return = FALSE) {
        if ($return):
            $content = $this->view('signindashboard/header', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('signindashboard/footer', $vars, $return);

            return $content;
        else:
            $this->view('signindashboard/header', $vars);
            $this->view($template_name, $vars);
            $this->view('signindashboard/footer', $vars);
        endif;
    }

    public function postemplate($template_name, $vars = array(), $return = FALSE) {
        if ($return):
            $content = $this->view('pos/header', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('pos/footer', $vars, $return);

            return $content;
        else:
            $this->view('pos/header', $vars);
            $this->view($template_name, $vars);
            $this->view('pos/footer', $vars);
        endif;
    }

    

}