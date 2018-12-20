<?php

/*
Plugin Name: WP Core
Plugin URI: 
Description: 
Author: 
Version: 
Author URI: 
*/

// ensure core is loaded first
add_action("activated_plugin", function() {
	// ensure path to this file is via main wp plugin path
  $filePath = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$pluginName = plugin_basename(trim($filePath));
	$activePlugins = get_option('active_plugins');
	$pluginId = array_search($pluginName, $activePlugins);
	if ($pluginId) { // if it's 0 it's the first plugin already, no need to continue
		array_splice($activePlugins, $pluginId, 1);
		array_unshift($activePlugins, $pluginName);
		update_option('active_plugins', $activePlugins);
	}
});

require_once(__DIR__.'/BsCore.class.php');
Bs\Core::setup();
Bs\Core::registerPlugin('CorePlugin', __DIR__);