<?php

/*
Plugin Name: ACF Helpers
Plugin URI: 
Description: 
Author: 
Version: 
Author URI: 
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$dependencies_ok = true;
if (!is_plugin_active('bs-core/bs-core.php')) {
  if (is_wp_error(activate_plugin( 'bs-core/bs-core.php', null))) {
    $dependencies_ok = false;
    add_action( 'admin_notices', function() {echo ' <div class="error"><p>'.__("Can't load Brainsonic ACF Helpers : Brainsonic Core required").'</p></div>';});
  } else {
    add_action( 'admin_notices', function() {echo ' <div class="updated notice is-dismissible"><p>'.__("Brainsonic Core activated by Brainsonic ACF Helpers").'</p></div>';});
  }
}
if (!is_plugin_active('advanced-custom-fields-pro/acf.php') && !is_plugin_active('advanced-custom-fields/acf.php')) {
  if (is_wp_error(activate_plugin( 'advanced-custom-fields-pro/acf.php', null))) {
    if (is_wp_error(activate_plugin( 'advanced-custom-fields/acf.php', null))) {
      $dependencies_ok = false;
      add_action( 'admin_notices', function() {echo ' <div class="error"><p>'.__("Can't load Brainsonic ACF Helpers : Advanced Custom Fields or Advanced Custom Fields Pro required").'</p></div>';});
    } else {
      add_action( 'admin_notices', function() {echo ' <div class="updated notice is-dismissible"><p>'.__("Advanced Custom Fields activated by Brainsonic ACF Helpers").'</p></div>';});
    }
  } else {
    add_action( 'admin_notices', function() {echo ' <div class="updated notice is-dismissible"><p>'.__("Advanced Custom Fields Pro activated by Brainsonic ACF Helpers").'</p></div>';});
  }
}
if ($dependencies_ok) {
  Bs\Core::registerPlugin('ACFHelpersPlugin', __DIR__);
}
