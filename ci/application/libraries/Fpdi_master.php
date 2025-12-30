<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fpdi_master {
		
	public function __construct() {
		
		require_once APPPATH.'third_party/fpdi/fpdi.php';
		
		$fpdi = new FPDI();
		$fpdi->AddPage();
		
		$CI =& get_instance();
		$CI->fpdi = $fpdi;
		
	}
	
}