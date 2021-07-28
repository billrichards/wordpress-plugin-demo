<?php
/**
Description:
Write a WordPress plugin that demonstrates:
(1) interacting with the WordPress plugin API, (https://codex.wordpress.org/Plugin_API)
(2) object oriented programming and 
(3) has some basic interaction with the WordPress database. 
 */
/** 

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

// Add this function to admin_notices
\add_action( 'admin_notices', ['SiteStats\siteStats', 'siteStatsDemo'] );

// For this plugin, there is no need to register any hooks for activation, deactivation, or uninstall