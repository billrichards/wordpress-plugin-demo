<?php
namespace SiteStats;

class Housekeeping {

    public function preActivationCheck(string $file, string $plugin)
    {
        if (!current_user_can('activate_plugins')) {
            die;
        }

        if (basename($file) !== basename($plugin) || !is_file($file)) {
            die;
        }
       
        check_admin_referer("activate-plugin_$plugin");
    }
}