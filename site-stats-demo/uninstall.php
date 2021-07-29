<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Delete this plugin's files
wp_delete_file(__DIR__ . DIRECTORY_SEPARATOR . 'site-stats-demo.php');
wp_delete_file(__DIR__ . DIRECTORY_SEPARATOR . 'site-stats-demo.js');
wp_delete_file(__DIR__ . DIRECTORY_SEPARATOR . 'site-stats-demo.css');
wp_delete_file(__DIR__ . DIRECTORY_SEPARATOR . 'SiteStats' . DIRECTORY_SEPARATOR . 'SiteStats.php');   
wp_delete_file(__DIR__ . DIRECTORY_SEPARATOR . 'SiteStats' . DIRECTORY_SEPARATOR . 'Housekeeping.php');