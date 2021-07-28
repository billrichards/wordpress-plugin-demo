<?php
/**
Description:
Write a WordPress plugin that:
(1) demonstrates interacting with the WordPress plugin API, (https://codex.wordpress.org/Plugin_API)
(2) demonstrates object oriented programming and 
(3) has some basic interaction with the WordPress database. 
 */
/** 

Plugin Name: Site Stats Demo
Plugin URI: 
Description: Demo plugin that displays site stat information
Version: 1.0.0
Requires at least: 5.8
Requires PHP:      7.3
Author: Bill Richards
Author URI: https://github.com/billrichards
License: GPLv2 or later

*/
require __DIR__ . '/SiteStats/SiteStats.php';

// instantiate the SiteStats object
$siteStats = new \SiteStats\SiteStats($wpdb);

// Add the siteStatsDemo function to admin_notices
add_action( 'admin_notices', [$siteStats, 'siteStatsDemo'] );
add_action( 'admin_footer', [$siteStats, 'echoJavascript']);

// For this plugin, there is no need to register any hooks for activation, deactivation, or uninstall