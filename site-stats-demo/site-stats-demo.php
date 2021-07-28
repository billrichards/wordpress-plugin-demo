<?php
// namespace SiteStats;
 /*
write a WordPress plugin that demonstrates:
(1) DONE interacting with the WordPress plugin API, (https://codex.wordpress.org/Plugin_API)
(2) object oriented programming and 
(3) has some basic interaction with the WordPress database. 
 */
/*
 // https://developer.wordpress.org/plugins/plugin-basics/header-requirements/
Plugin Name: Site Stats Demo
 
Plugin URI: 
 
Description: Displays site stats
 
Version: 1.0.0

Requires at least: 5.8

Requires PHP:      7.3
 
Author: Bill Richards
 
Author URI: https://github.com/billrichards
 
License: GPLv2 or later

*/
require __DIR__ . '/SiteStats/SiteStats.php';

// we might need a function here called site-stats-demo
\add_action( 'admin_notices', ['SiteStats\siteStats', 'siteStatsDemo'] );

// register_activation_hook()
// register_deactivation_hook()
// register_uninstall_hook()
// do_action() https://developer.wordpress.org/reference/functions/do_action/
// add_action() https://developer.wordpress.org/reference/functions/add_action/