<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


function my_resize_image($uploaded_data, $source_image, $width = 30) {
	$CI =& get_instance();

    $CI->load->library('image_lib');

	$config['image_library']  = 'gd2';
	$config['source_image']   = $source_image;
	$config['create_thumb']   = FALSE;
	$config['maintain_ratio'] = TRUE;
	$config['width']          = $width;
    // $config['height']         = 50;

	$new_file_name = md5(rand()*time()) . $uploaded_data['file_ext'];
	$config['new_image'] = $new_file_name;

	$CI->image_lib->initialize($config);
	$CI->image_lib->resize();
	$CI->image_lib->clear();



	return $new_file_name;
}