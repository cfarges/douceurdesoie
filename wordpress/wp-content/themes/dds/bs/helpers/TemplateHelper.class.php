<?php

namespace Bs\Helpers {
  class TemplateHelper {
    
    public static function getPart($slug, $name=null, $params=array()) {
      
      do_action( "get_template_part_{$slug}", $slug, $name );

      $templates = array();
      $name = (string) $name;
      if ( '' !== $name )
        $templates[] = "{$slug}-{$name}.php";

      $templates[] = "{$slug}.php";

      $templatePath = locate_template($templates, false, false);
      
      if (!empty($templatePath)) {
        self::loadPart($templatePath, $params);
        return true;
      }
      return false;
    }
    
    private static function loadPart($templatePath, $params) {
      extract($params, EXTR_SKIP);
      include($templatePath);
    }
  }
}