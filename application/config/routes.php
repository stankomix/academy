<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'dashboard';
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//timecard pagination
$route['timecard/(:num)'] = 'timecard/index/$1';
$route['timecard/update/(:num)'] = 'timecard/update/$1';

// route public assets in CI
$route['public/(:any)'] = 'public/$1';

$route['bb/(:any)'] = 'bulletin_board/$1';

### ADMIN ROUTES ###

// payroll pagination
$route['admin/payroll/(:num)'] = 'admin/payroll/index/$1';

// lock pages controller
$route['admin/pages/(:any)'] = 'admin/pages/index';

## BULLETIN BOARD
// edit bulletin routes
$route['admin/bb/(:num)/edit']['GET'] = 'admin/pages/edit_bulletin/$1';
$route['admin/bb/(:num)/edit']['POST'] = 'admin/bb/edit/$1';
// aad new bulletin route
$route['admin/bb/add']['GET'] = 'admin/pages/add_bulletin';
//delete bulletin routes
$route['admin/bb/(:num)/delete']['GET'] = 'admin/pages/delete_bulletin/$1';
$route['admin/bb/(:num)/delete']['POST'] = 'admin/bb/delete/$1';
// delete bb photo routes
$route['admin/delete/bb_photo/(:num)']['GET'] = 'admin/delete/bb_photo/$1';
$route['admin/delete/bb_photo/(:num)']['POST'] = 'admin/delete/bb_photo_delete/$1';

## FILES
// add
$route['admin/files/add']['GET'] = 'admin/pages/add_file';
// edit
$route['admin/files/(:num)/edit']['GET'] = 'admin/pages/edit_file/$1';
$route['admin/files/(:num)/edit']['POST'] = 'admin/files/edit/$1';
// delete
$route['admin/files/(:num)/delete']['GET'] = 'admin/pages/delete_file/$1';
$route['admin/files/(:num)/delete']['POST'] = 'admin/files/delete/$1';
// delete event photo
$route['admin/delete/photo/(:num)']['GET'] = 'admin/delete/photo/$1';
$route['admin/delete/photo/(:num)']['POST'] = 'admin/delete/photo_delete/$1';

## USERS
// add
$route['admin/users/add']['GET'] = 'admin/pages/add_user';
$route['admin/users/add']['POST'] = 'admin/users/add';
// edit
$route['admin/users/(:num)/edit']['GET'] = 'admin/pages/edit_user/$1';
$route['admin/users/(:num)/edit']['POST'] = 'admin/users/edit/$1';
// delete
$route['admin/users/(:num)/delete']['GET'] = 'admin/pages/delete_user/$1';
$route['admin/users/(:num)/delete']['POST'] = 'admin/users/delete/$1';

## TESTS
// add
$route['admin/tests/add']['GET'] = 'admin/pages/add_test';
$route['admin/tests/add']['POST'] = 'admin/tests/add';
// edit
$route['admin/tests/(:num)/edit']['GET'] = 'admin/pages/edit_test/$1';
$route['admin/tests/(:num)/edit']['POST'] = 'admin/tests/edit/$1';
// delete
$route['admin/tests/(:num)/delete']['GET'] = 'admin/pages/delete_test/$1';
$route['admin/tests/(:num)/delete']['POST'] = 'admin/tests/delete/$1';

## TEST QUESTIONS
// add 
$route['admin/questions/add/(:num)']['GET'] = 'admin/test_questions/index/$1';
$route['admin/questions/add/(:num)']['POST'] = 'admin/test_questions/add/$1'; 

// update
$route['admin/questions/edit/(:num)']['GET'] = 'admin/test_questions/edit/$1';
$route['admin/questions/update/(:num)']['POST'] = 'admin/test_questions/update/$1'; 

//Remove 
$route['admin/questions/delete/(:num)']['GET'] = 'admin/test_questions/remove/$1';
## ADMINS
// add
$route['admin/admins/add']['GET'] = 'admin/pages/add_admin';
$route['admin/admins/add/(:num)']['GET'] = 'admin/pages/confirm_admin/$1';
$route['admin/admins/add/(:num)']['POST'] = 'admin/admins/add/$1';
// edit
$route['admin/admins/(:num)/edit']['GET'] = 'admin/pages/edit_admin/$1';
$route['admin/admins/(:num)/edit']['POST'] = 'admin/admins/edit/$1';
// delete
$route['admin/admins/(:num)/delete']['GET'] = 'admin/pages/delete_admin/$1';
$route['admin/admins/(:num)/delete']['POST'] = 'admin/admins/delete/$1';

## Timecards
$route['admin/timecard']['POST'] = 'admin/timecard/create_timecard';

## Overtime
$route['admin/timecard/(:num)'] = 'admin/pages/timecards_user/$1';
$route['admin/overtime/(:num)'] = 'admin/overtime/index/$1';
$route['admin/overtime/mark/(:num)']['POST'] = 'admin/overtime/mark_overtime/$1';
