<?php

namespace Bs\Interfaces {

  interface IWPPost extends IWPObject
  {
    public function getTitle();
    public function getType();
    public function getAuthor();
    public function getPermalink();
    public function getThumbnail();
    public function getContent();

    public function getPublicationDate($format);
  }
}