<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Share config
|--------------------------------------------------------------------------
|
| Crafter use critical constants of your base application.
| With this file you can config some vars.
| 
*/

/*
 *---------------------------------------------------------------
 * Application folder name of your base application
 *---------------------------------------------------------------
 *
 * If you changed the value of $application_folder in :
 * ROOT_PROJECT/index.php, copy the value in this var
 *
 */
$app_application_folder = 'application';


// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------


// Path to the front controller of the base application (not crafter)
// We will guess value, we drop the "crafter\" of current FCPATH 
define('APP_FCPATH', substr(FCPATH, 0, -8));

$app_apppath = APP_FCPATH . trim($app_application_folder, '/') . '/';

// Valid config ?
if ( ! is_dir($app_apppath)) {

	exit("Your crafter application folder path does not appear to be set correctly. Please open the following file and correct this: " . SELF);

}

// App path of the base application
define('APP_APPPATH', $app_apppath);


/* End of file share_config.php */
/* Location: ./application/config/share_config.php */