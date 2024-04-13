<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'business_registration';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Define custom routes for business registration
$route['business-registration'] = 'business_registration/index';
$route['save-registration'] = 'business_registration/save_registration';
$route['mail'] = ' mail';
