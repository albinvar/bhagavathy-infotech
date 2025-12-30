<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
 */
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
 */
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('ADMIN_FOLDER', 'admin');
define('UPLOAD_FILE_MAX_SIZE', '5120'); /* Whenever modify this ,should modify UPLOAD_FILE_MAX_SIZE_VIEW also */
define('UPLOAD_FILE_MAX_SIZE_VIEW', '5MB');
define('MSG_FOR_NOTALLOWED_PAGES', 'You are not allowed to access this page'); /* Whenever modify this ,should modify UPLOAD_FILE_MAX_SIZE also */

define('WEBSITE_NAME', 'Use BIller Application');

define('WEBSITE_ADDRESS', 'Palakkad <br> Kerala');
define('SITE_NAME', 'Usebiller Application');
define('SITE_URL', 'http://usebiller.com/');
define('EMAIL_NAME', 'Use Admin');
define('ADMIN_EMAIL', 'info@usebiller.com');
define('CONTACT_EMAIL', 'info@usebiller.com');
define('SALES_EMAIL', 'info@usebiller.com');
define('KEY', 'key');
define('WEBSITE_NAME_EMAIL', 'Usebiller');
define('BREADCRUMB', true);
define('DEVELOPEDBY', 'Dip');
define('HASHCODE', 'UseBiller@#$%^');
define('EncriptKey', 'UseBiller2022');
define('QUERYLIMIT', '10');
define('VERSION', '1.0.0');
define('APIPRIVATEKEY', 'Usebill$%^$#@GH#$');
define('PAGINATIONPERPAGECOUNT', '6');
define('FOLDERPATH', 'uploads');
// define('FIREBASEKEY', 'AAAA111629M:APA91bGO1xP0Lu_C32eitN19FTZNEZIQwg_7dXmZtWZbOSXqIbR9fhVk9paq0z5FV5-TZSS81FZRPGT_udJiDncYFNRuXpVN3HC53tQyRnWw-BMBHCNSzuEbSVEvu3_q2c4ClwDSeBWx');

// define('FIREBASEURL', 'https://fcm.googleapis.com/fcm/send');
