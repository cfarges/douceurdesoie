<?php

namespace Bs\Bases {
  class DashboardBase {
  
    public function __construct($slug, $title, $menuTitle, $role="administrator", $parent=null) {
      $this->slug = $slug;
      $this->title = $title;
      $this->menuTitle = $menuTitle;
      $this->role = $role;
      $this->parent = $parent;
    }
    
    public function getSlug() {
      return $this->slug;
    }
    public function getTitle() {
      return $this->title;
    }
    public function getMenuTitle() {
      return $this->menuTitle;
    }
    public function getRole() {
      return $this->role;
    }
    public function getParent() {
      return $this->parent;
    }
    public function getParentSlug() {
      if ($this->parent != null && $this->parent instanceof DashboardBase) {
        return $this->parent->getSlug();
      }
      return $this->parent;

    }

    public function getPageId() {
      return $this->pageId;
    }
    public function setPageId($pageId) {
      $this->pageId = $pageId;
    }
    
    public function show() {
      
    }
    
    protected $slug;
    protected $title;
    protected $menuTitle;
    protected $role;
    protected $parent;
    protected $pageId;
  }
}