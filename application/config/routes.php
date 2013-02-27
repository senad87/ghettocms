<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There is one reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
*/

$route['default_controller'] = "menu";
$route['(:any)/api/(:any)'] = "$1/api/$2";//used for rest interface, api requests
$route['(:any)/ajax/(:any)'] = "$1/$2";//used for all ajax requests

$route['story/(:num)/(:num)/(:any)'] = "stories/index/$1/$2/$3";//for single story page
$route['game/(:num)/(:num)/(:any)'] = "games/index/$1/$2/$3";//for single game page
$route['gallery/(:num)/(:num)/(:any)'] = "gallery/index/$1/$2/$3";//for single game page
$route['tag/(:num)/(:num)/(:any)'] = "tags/index/$1/$2/$3";//for articles by tag list
$route['(:any)/(:num)/(:num)'] = "menu/index/$2/$3";
$route['(:any)/(:num)'] = "menu/index/$2";


/* End of file routes.php */
/* Location: ./application/config/routes.php */