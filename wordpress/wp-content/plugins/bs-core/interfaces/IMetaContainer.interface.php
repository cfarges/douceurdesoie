<?php

namespace Bs\Interfaces {

  interface IMetaContainer
  {
    public function getMetadata($key);
    public function setMetadata($key, $value);
  }
}