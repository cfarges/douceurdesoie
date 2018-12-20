<?php

namespace Bs\Models {
  use Bs\Bases\PostBase;
  
  class Post extends PostBase
  {
    const POST_TYPE = 'post';

    public static function createType() {
      parent::createType(__CLASS__);
    }
  }
  
  Post::createType();
}