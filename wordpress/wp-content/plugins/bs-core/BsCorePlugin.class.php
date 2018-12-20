<?php

namespace Bs\Plugins {
  use Bs\Bases;
  use Bs\Dashboard;
  
  class CorePlugin extends Bases\PluginBase {
    
    public static function getLoadPaths() {
      return ['bases', 'interfaces', 'models', 'traits', 'dashboard'];
    }
    
    public static function loaded($isAdmin) {
      if ($isAdmin) {
        self::registerDashboardPage(new Dashboard\RootDashboard('bs-options', 'Brainsonic Options', 'BS Options'));
        
        add_action( 'admin_menu', array(__class__, '_addMenu') );
      }
    }
    public static function registerDashboardPage($page){
      if (!is_array(self::$pages)) {
        self::$pages = [];
      }
      self::$pages[] = $page;
    }
    public static function getChildrenPages($parentSlug) {
      $return = [];
      foreach(self::$pages as $page) {
        if ($page->getParent() == $parentSlug) {
          $return[] = $page;
        }
      }
      return $return;
    }
    
    public static function _addMenu() {
      // main pages
      foreach(self::$pages as $page) {
        if ($page->getParent() == null) {
          $page->setPageId(add_menu_page($page->getTitle(), $page->getMenuTitle(), $page->getRole(), $page->getSlug(), array($page, 'show')));
        }
      }
      // sub pages
      foreach(self::$pages as $page) {
        if ($page->getParent() != null) {
          $page->setPageId(add_submenu_page($page->getParent(), $page->getTitle(), $page->getMenuTitle(), $page->getRole(), $page->getSlug(), array($page, 'show')));
        }
      }
    }
    private static $pages;
  }
}

namespace {
  class BsCorePlugin extends Bs\Plugins\CorePlugin {
    
  }
}