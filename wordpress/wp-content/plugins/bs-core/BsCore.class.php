<?php

namespace Bs{
  require_once(__DIR__.'/bases/PluginBase.class.php');
  
  class Core {
    public static $plugins = [];
    public static $themes = [];
    
    public static function setup() {
      spl_autoload_register('Bs\Core::autoloadCallback');

      if (PHP_MAJOR_VERSION >= 7) {
        set_error_handler(function ($errno, $errstr) {
          return strpos($errstr, 'Declaration of') === 0;
        }, E_WARNING);
      }
    }

    public static function autoloadCallback($class) {
      $namespace = explode('\\', $class);
      
      if(count($namespace) > 1 && $namespace[0] == 'Bs') {
        // V2 Format - With Namespace
        $className = array_pop($namespace);
      } else if(count($namespace) == 1 && (substr($class, 0, 2) == 'Bs' || substr($class, 0, 3) == 'IBs')) {
        // V1 Format - No Namespace
        $className = substr($class, 2);
      } else {
        return; // Not a Bs Class
      }
      
      if (substr($className, 0, 1) == 'I' && ctype_upper(substr($className, 1, 1))) {
        $fileNames = [
          $className.'.interface.php',
          $className.'.class.php',
          $className.'.trait.php',
          $className.'.php'
        ];
      } else {
        $fileNames = [
          $className.'.class.php',
          $className.'.interface.php',
          $className.'.trait.php',
          $className.'.php'
        ];
      }


      if (!self::tryLoading(self::$themes, $fileNames)) {
        $plugins = array_diff_key(self::$plugins, ['CorePlugin']);
        if (!self::tryLoading($plugins, $fileNames)) {
          self::tryLoading([self::$plugins['CorePlugin']], $fileNames);
        }
      }
      /*
      // Try Loading from Theme
      foreach(self::$themes as $theme) {
        $themeClass = $theme->class;
        foreach($themeClass::getLoadPaths() as $path) {
          foreach($fileNames as $fileName) {
            $filePath = $theme->root . '/' . (strlen($path) > 0 ? $path . '/' : '') . $fileName;
            if (file_exists($filePath)) {
              require_once($filePath);
              return;
            }
          }
        }
      }

      // Try Loading from Plugins
      foreach(self::$plugins as $name => $plugin) {
        if ($name != 'CorePlugin') {
          $pluginClass = $plugin->class;
          foreach($pluginClass::getLoadPaths() as $path) {
            $filePath = $plugin->root.'/'.$path.'/'.$fileName;
            if (file_exists($filePath)) {
              require_once($filePath);
              return;
            }
          }
        }
      }

      // Try Loading from Core
      if (isset(self::$plugins['CorePlugin'])) {
        $plugin = self::$plugins['CorePlugin'];
        $pluginClass = $plugin->class;
        foreach($pluginClass::getLoadPaths() as $path) {
          $filePath = $plugin->root.'/'.$path.'/'.$fileName;
          if (file_exists($filePath)) {
            require_once($filePath);
            return;
          }
        }
      }
      */
    }
    private static function tryLoading($sources, $fileNames) {
      foreach($sources as $source) {
        $sourceClass = $source->class;
        foreach($sourceClass::getLoadPaths() as $path) {
          foreach($fileNames as $fileName) {
            $filePath = $source->root . '/' . (strlen($path) > 0 ? $path . '/' : '') . $fileName;
            if (file_exists($filePath)) {
              require_once($filePath);
              return true;
            }
          }
        }
      }
      return false;
    }
    
    public static function registerPlugin($name, $dir) {
      if (!isset(self::$plugins[$name])) {
        $className = 'Bs\\Plugins\\'.$name;
        $fileName = 'Bs'.$name.'.class.php';
        require_once($dir.'/'.$fileName);
        if(class_exists($className)) {
          self::$plugins[$name] = (object)array(
            'name' => $name,
            'class' => $className,
            'root' => $dir
          );
          $className::register();
        }
      }
    }
    
    public static function registerTheme($name, $class, $dir) {
      if(class_exists($class)) {
        self::$themes[$name] = (object)array(
          'name' => $name,
          'class' => $class,
          'root' => $dir
        );
      }
    }
  }
}