<?php

namespace Bs\Bases {
  class PluginBase {
    
    static function activate() {
      
    }
    static function deactivate() {
      
    }
    static function loaded($isAdmin) {
      
    }
    static function getIncludes($pluginRoot, $isAdmin) {
      
    }
    static function getLoadPaths() {
      return [];
    }
    static function enqueueScripts($path, $isAdmin) {
      
    }
    static function enqueueStyles($path, $isAdmin) {
      
    }
    
    /*** ***/
    
    static function getAssetsUrl($file) {
      return plugins_url('assets/'.$file, self::$plugins[get_called_class()]->script);
    }
    
    static function register() {
      if (!is_array(self::$plugins)) {
        self::$plugins = [];
      }
      $calledClass = get_called_class();
      $reflection = new \ReflectionClass($calledClass);
      $fileName = $reflection->getFileName();
      $pluginPath = dirname($fileName);
      $pluginSlug = dirname(plugin_basename($fileName));
      $pluginScript = $pluginSlug.'/'.$pluginSlug.'.php';
      
      self::$plugins[$calledClass] = (object)array(
        'class' => $calledClass,
        'slug' => $pluginSlug,
        'script' => $pluginScript,
        'path' => $pluginPath
      );

      register_activation_hook( $pluginScript, array( $calledClass, 'activate' ) );
      register_deactivation_hook( $pluginScript, array( $calledClass, 'deactivate' ) );
      
      $isAdmin = is_admin();
      static::getIncludes($pluginPath, $isAdmin);
      add_action( 'wp_enqueue_scripts', array($calledClass, '_enqueueScript') );
      add_action( 'admin_enqueue_scripts', array($calledClass, '_enqueueAdminScript') );
      static::loaded($isAdmin);
    }
    
    /*** ***/
    
    static function _enqueueScript() {
      static::enqueueScripts(static::getAssetsUrl('js/'), false);
      static::enqueueStyles(static::getAssetsUrl('css/'), false);
    }
    static function _enqueueAdminScript() {
      static::enqueueScripts(static::getAssetsUrl('js/'), true);
      static::enqueueStyles(static::getAssetsUrl('css/'), true);
    }
    
    
    static public $plugins;
  }
}

namespace {
  class BsPluginBase extends Bs\Bases\PluginBase{
    static function register() {
      if ($_GET['debug']) echo 'Plugin is using BsPluginBase';
      parent::register();
    }
  }
}
//