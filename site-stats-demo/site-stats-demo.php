<?php
/** 
Plugin Name: Site Stats Demo
Plugin URI: https://github.com/billrichards/wordpress-plugin-demo
Description: Demo plugin that displays site stat information.
Version: 1.0.0
Requires at least: 5.8
Requires PHP:      7.3
Author: Bill Richards
Author URI: https://github.com/billrichards
License: GPLv2

/**
Write a WordPress plugin that:
(1) demonstrates interacting with the WordPress plugin API, (https://codex.wordpress.org/Plugin_API)
(2) demonstrates object oriented programming and 
(3) has some basic interaction with the WordPress database. 
 */

require __DIR__ . DIRECTORY_SEPARATOR . 'SiteStats' . DIRECTORY_SEPARATOR . 'SiteStats.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'SiteStats' . DIRECTORY_SEPARATOR . 'Housekeeping.php';

global $wpdb;

// Register activation and deactivation hooks
$housekeeping = new \SiteStats\Housekeeping();
register_activation_hook(__FILE__, function() use ($housekeeping) { 
    $housekeeping->activationCheck(__FILE__, $_REQUEST['plugin']);
});
register_deactivation_hook(__FILE__, function() use ($housekeeping) { 
    $housekeeping->deactivationCheck(__FILE__, $_REQUEST['plugin']);
});

// Add the siteStatsDemo function to admin_notices
add_action( 'admin_notices', [(new \SiteStats\SiteStats($wpdb)), 'siteStatsDemo'] );   

// Enqueue the js that will show/hide site stats
wp_enqueue_script('site-stats-demo', plugin_dir_url(__FILE__) . 'site-stats-demo.js');
wp_enqueue_style('site-stats-demo', plugin_dir_url(__FILE__) . 'site-stats-demo.css');
