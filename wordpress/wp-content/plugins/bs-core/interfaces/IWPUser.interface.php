<?php

namespace Bs\Interfaces {

  interface IWPUser extends IWPObject
  {
    public function getFirstName();
    public function getLastName();
    public function getDisplayName();
    public function getNiceName();
    public function getEmail();
  }
}