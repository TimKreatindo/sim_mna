<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['verify/(:any)'] = 'auth/verify/$1';
$route['verify_your_email']['POST'] = 'auth/verify_email';


//master periode
$route['act_master_periode'] = 'ajax/act_periode';

//menu group
$route['list_pemlap'] = 'dashboard/pemlap';
$route['list_group'] = 'dashboard/group';
$route['act_master_pemlap']['POST'] = 'ajax/master_pemlap';
$route['load_list_mahasiswa_table']['POST'] = 'ajax/list_mahasiswa_group';
$route['load_list_pemlap_table']['POST'] = 'ajax/list_pemlap_group';
$route['validation_group']['POST'] = 'ajax/validation_group';
$route['table_group']['POST'] = 'ajax/table_group';
$route['act_group']['POST'] = 'ajax/act_group';


//menu mylogbook
$route['mhs/my-logbook'] = 'dashboard/logbook_mhs';
$route['mhs/my-logbook/(:any)'] = 'dashboard/detail_mhs_logbook/$1';
$route['mhs/update-mylogbook/(:any)'] = 'dashboard/mhs_edit_logbook/$1';

$route['mhs/new-logbook'] = 'dashboard/add_mhs_logbook';
$route['validation_mylogbook'] = 'ajax_logbook/validation_mhs';
$route['mhs/load_my_logbook']['POST'] = 'ajax_logbook/mhs_load_logbook';
$route['edit_mylogbook']['POST'] = 'ajax_logbook/mhs_edit_logbook';
$route['mhs/show_log_activity']['POST'] = 'ajax_logbook/mhs_show_log';

//menu logbook mahasiswa 
$route['logbook-mahasiswa'] = 'dashboard/logbook_mahasiswa_list';
$route['load-list-mahasiswa']['POST'] = 'ajax_logbook/get_list_mahasiswa';
$route['logbook-mahasiswa/list/(:any)'] = 'dashboard/list_logbook_mhs/$1';
$route['logbook-mahasiswa/detail/(:any)'] = 'dashboard/detail_logbook_mhs/$1';
$route['table-list-logbook']['POST'] = 'ajax_logbook/load_tbl_list_logbook';
$route['action-logbook']['POST'] = 'ajax_logbook/act_logbook';

//menu laporan milik pemlap
$route['report-pemlap'] = 'dashboard/lap_pemlap';
$route['add-report'] = 'dashboard/add_report';
$route['detail-report/(:any)'] = 'dashboard/detail_report/$1';
$route['edit-report/(:any)'] = 'dashboard/edit_report/$1';
$route['add_report']['POST'] = 'ajax_logbook/add_report';
$route['table_report']['POST'] = 'ajax_logbook/load_report';
$route['act_laporan']['POST'] = 'ajax_logbook/act_laporan';
$route['edit-report']['POST'] = 'ajax_logbook/edit_laporan';

//menu laporan pembimbing di bagian super admin & dosen
$route['report-pemlap/user/(:any)'] = 'dashboard/list_laporan_pemlap/$1';
$route['report-pemlap/detail/(:any)'] = 'dashboard/detail_laporan_pemlap/$1';
$route['table-list-pemlap']['POST'] = 'ajax_logbook/load_data_report';
$route['table-list-report']['POST'] = 'ajax_logbook/list_laporan_pemlap';
$route['act-report']['POST'] = 'ajax_logbook/act_report_admin';