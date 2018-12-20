<?php

namespace Bs\Interfaces {

  interface IWPObject
  {
    public function wpId();
    public function getWpData($key);
  }
}