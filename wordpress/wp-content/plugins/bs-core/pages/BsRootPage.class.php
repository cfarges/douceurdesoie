<?php

class BsRootPage extends BsPageBase {
  
  public function __construct($slug, $title, $menuTitle, $role="manage_options") {
    parent::__construct($slug, $title, $menuTitle, $role, null);
  }
  public function show() {
    ?>
    <div><h1><?php echo $this->title; ?></h1>
      <ul>
        <?php foreach (BsCorePlugin::getChildrenPages($this->slug) as $page) : ?>
        <li><a href="<?php menu_page_url($page->getSlug()); ?>" ><?php echo $page->getMenuTitle(); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php
  }
  
}