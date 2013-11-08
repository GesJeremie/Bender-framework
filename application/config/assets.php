<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Environment compress
|--------------------------------------------------------------------------
|
| Here you can choose if you want use the compress system in :
| development / testing / production mode
| 
*/
$assets['compress'] = array(

	'development' => TRUE,
	'testing'     => FALSE,
	'production'  => FALSE
 
	);

/*
|--------------------------------------------------------------------------
| Register css
|--------------------------------------------------------------------------
|
| Here you can register all css used by your application
| 
| Note : You must put all files into the folder /assets/
| 
| Example of use :
|
| $assets['css'] = array(
| 
| 	array(
| 
| 		'name' => 'layout',
| 		'version' => 0.1,
| 		'src' => 'css/layout.css',
| 		'compress' => TRUE
| 
| 		),
| 
| 	array(
| 
| 		'name' => 'bootstrap',
| 		'version' => 0.2,
| 		'src' => 'libs/css/bootstrap/bootstrap.css'
| 		'compress' => TRUE
| 	)
| 
| 	);
| 
*/
$assets['css'] = array(

	array(

		'name' => 'layout',
		'version' => '',
		'compress' => FALSE

		)

	);


/*
|--------------------------------------------------------------------------
| Register js
|--------------------------------------------------------------------------
|
| Here you can register all js used by your application
| 
| Note : You must put all files into the folder /assets/
| 
| Example of use :
|
| $assets['js'] = array(
| 
| 	array(
| 
| 		'name' => 'toast',
| 		'version' => '',
| 		'src' => 'libs/js/toast.js',
| 		'compress' => TRUE
| 
| 		)
| 	);
| 
*/
 $assets['js'] = array(
 
 	array(
 
		'name' => 'toast',
 		'version' => '0.1',
		'src' => 'js/toast.js',
 		'compress' => FALSE

		)
	);

/* End of file assets.php */
/* Location: ./application/config/assets.php */