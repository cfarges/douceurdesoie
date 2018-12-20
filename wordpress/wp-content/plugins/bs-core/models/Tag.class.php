<?php

namespace Bs\Models {
  use Bs\Bases\TaxonomyBase;
  
  class Tag extends TaxonomyBase
  {
    const TAXONOMY_TYPE = 'post_tag';
    const TAXONOMY_POST_TYPE = 'post';

    public static function createType()
    {
      parent::createType(__CLASS__);
    }
  }

  Tag::createType();
}