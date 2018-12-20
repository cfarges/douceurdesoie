<?php

namespace Bs\Models {
  use Bs\Bases\TaxonomyBase;
  
  class Category extends TaxonomyBase
  {
    const TAXONOMY_TYPE = 'category';
    const TAXONOMY_POST_TYPE = 'post';

    public static function createType()
    {
      parent::createType(__CLASS__);
    }
  }
  Category::createType();
}