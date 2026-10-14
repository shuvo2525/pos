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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['subscription'] = 'subscribers';
$route['subscription/index'] = 'subscribers/index';
$route['subscription/add'] = 'subscribers/add';
$route['subscription/add/(:any)'] = 'subscribers/add/$1';
$route['subscription/add/(:any)/(:any)'] = 'subscribers/add/$1/$2';
$route['subscription/plan/(:any)'] = 'subscribers/plan/$1';
$route['subscription/list/(:any)'] = 'subscribers/list/$1';
$route['subscription/get_category'] = 'subscribers/get_category';
$route['subscription/ajax_list'] = 'subscribers/ajax_list';
$route['subscription/ajax_package_list'] = 'subscribers/ajax_package_list';
$route['subscription/update_status'] = 'subscribers/update_status';
$route['subscription/authorize_subscription'] = 'subscribers/authorize_subscription';
$route['subscribers/authorize_subscription'] = 'subscribers/authorize_subscription';
$route['subscription/unsubscribe_subscription'] = 'subscribers/unsubscribe_subscription';
$route['subscribers/unsubscribe_subscription'] = 'subscribers/unsubscribe_subscription';
$route['subscription/delete_subscription'] = 'subscribers/delete_subscription';
$route['subscription/multi_delete'] = 'subscribers/multi_delete';
$route['subscription/(:any)'] = 'subscribers/$1';

// HR / Employee Routes
$route['employee'] = 'employee/index';
$route['employee/add'] = 'employee/add';
$route['employee/edit/(:any)'] = 'employee/edit/$1';
$route['employee/view/(:any)'] = 'employee/view_profile/$1';
$route['employee/pdf/(:any)'] = 'employee/pdf/$1';
$route['employee/print/(:any)'] = 'employee/print_profile/$1';
$route['employee/ajax_list'] = 'employee/ajax_list';
$route['employee/save_or_update'] = 'employee/save_or_update';
$route['employee/delete_employee'] = 'employee/delete_employee';
$route['employee/update_status'] = 'employee/update_status';

// Invoice & PDF routes
$route['pdf/sales/(:any)'] = 'pdf/sales/$1';
$route['sales/pdf/(:any)'] = 'pdf/sales/$1';
$route['pos/print_invoice_pos/(:any)'] = 'pos/print_invoice_pos/$1';
$route['sales/print_invoice_pos/(:any)'] = 'pos/print_invoice_pos/$1';

// Public Invoice Verification routes (No login required)
$route['verify'] = 'verify/invoice';
$route['verify/invoice'] = 'verify/invoice';
$route['verify/invoice/(:any)'] = 'verify/invoice/$1';
$route['verify/print_original'] = 'verify/print_original';
$route['verify/print_original/(:any)'] = 'verify/print_original/$1';
$route['verify/pos_receipt'] = 'verify/pos_receipt';
$route['verify/pos_receipt/(:any)'] = 'verify/pos_receipt/$1';
$route['verify/(:any)'] = 'verify/invoice/$1';

