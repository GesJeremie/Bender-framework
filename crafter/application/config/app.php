<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| App
|--------------------------------------------------------------------------
|
| Here you can add some config vars only for your custom application
|
| Ex. 
| 
| $config['app_version'] = 0.1;
| $config['author'] = 'Luke Skywalker';
| 
*/

/*
|--------------------------------------------------------------------------
| App version
|--------------------------------------------------------------------------
|
| The current version of crafter
|
| 
*/
$config['app_version'] = '0.1';

/*
|--------------------------------------------------------------------------
| Pagination design bootstrap
|--------------------------------------------------------------------------
|
| Base config pagination for bootstrap 3.0 design
|
| 
*/
$config['pagination_design_bootstrap'] = array(

	'full_tag_open' => '<ul class="pagination">',
	'full_tag_close' => '</ul>',
	'cur_tag_open' => '<li class="disabled"><span>',
	'cur_tag_close' => '</span></li>',
	'num_tag_open' => '<li>',
	'num_tag_close' => '</li>',
	'prev_tag_open' => '<li>',
	'prev_tag_close' => '</li>',
	'next_tag_open' => '<li>',
	'next_tag_close' => '</li>',
	'first_tag_open' => '<li>',
	'first_tag_close' => '</li>',
	'last_tag_open' => '<li>',
	'last_tag_close' => '</li>',

	);

/* End of file app.php */
/* Location: ./application/config/app.php */