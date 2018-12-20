<?php

namespace Bs\Models {
  use Bs\Bases\PostBase;

  class Page extends PostBase
  {
    const POST_TYPE = 'page';

    public static function createType() {
      parent::createType(__CLASS__);
    }
  }
  
  Page::createType();
}
