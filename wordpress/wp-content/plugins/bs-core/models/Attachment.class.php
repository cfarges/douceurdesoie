<?php

namespace Bs\Models {
  use Bs\Bases\PostBase;

  class Attachment extends PostBase
  {
    const POST_TYPE = 'attachment';
    
    public static function createType() {
      parent::createType(__CLASS__);
    }
    
    public function getSourceUrl($size="thumbnail", $icon=false) {
      $data = wp_get_attachment_image_src($this->wpId(), $size, $icon);
      return $data[0];
    }
    
    public function getLegend() {
      return $this->getExcerpt(true);
    }
    
    public function getAlternateText() {
      return $this->getMetadata('_wp_attachment_image_alt');
    }
  }
  Attachment::createType();
}