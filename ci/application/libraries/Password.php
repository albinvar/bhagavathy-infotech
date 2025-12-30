<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      Binil Kt
 * @copyright           Copyright (c) 2015, nfonics.
 * @license     
 * @link        
 * @since       Version 1.0
 * @filesource
 */

/**
 * Anil Labs core CodeIgniter class
 *
 * @package     CodeIgniter
 * @subpackage          Libraries
 * @category            binil 
 * @author      binil kt
 * @link        
 */
class Password{

	//Number of times to rehash
	private $rotations = 0 ;

	 function encrypt_password($password){

		$salt = hash('sha256', uniqid(mt_rand(), true) . "TOITLOYALTY");

		$hash = $salt . $password;


		for ( $i = 0; $i < $this->rotations; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
                
		return $salt . $hash;
	}


	 function is_valid_password($password,$dbpassword){
		$salt = substr($dbpassword, 0, 64);

		$hash = $salt . $password;

		for ( $i = 0; $i < $this->rotations; $i ++ ) {
				$hash = hash('sha256', $hash);
		}

		//Sleep a bit to prevent brute force
		time_nanosleep(0, 400000000);
		$hash = $salt . $hash;

		return $hash == $dbpassword;


	}


}