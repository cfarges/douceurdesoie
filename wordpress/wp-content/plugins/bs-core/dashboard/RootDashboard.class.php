<?php

namespace Bs\Dashboard {
  use Bs\Bases;
  use Bs\Plugins;
  
  class RootDashboard extends Bases\DashboardBase {


    public function __construct($slug, $title, $menuTitle, $role="manage_options") {
      parent::__construct($slug, $title, $menuTitle, $role, null);
    }

    public function show() {
      ?>
      <div class="wrap">
        <h1><?php echo $this->title; ?></h1>
        <?php /*
        <ul>
          <?php foreach (Plugins\CorePlugin::getChildrenPages($this->slug) as $page) : ?>
          <li><a href="<?php menu_page_url($page->getSlug()); ?>" ><?php echo $page->getMenuTitle(); ?></a></li>
          <?php endforeach; ?>
        </ul>
        */?>
        <h2>Brainsonic Plugins</h2>
        <?php 
          $pluginList = get_plugins();
          $corePlugins = Plugins\CorePlugin::$plugins;
          $corePluginsV2 = \Bs\Core::$plugins;
          
        ?>
        <table class="wp-list-table widefat plugins">
          <thead><tr>
            <th class="manage-column check-column"></th>
            <td class="manage-column primary-column">Name</td>
            <td class="manage-column">Active</td>
            <td class="manage-column">Core</td>
            <td class="manage-column">Description</td>
          </tr></thead>
          <tbody>
            <?php
              foreach ($pluginList as $key => $plugin):
                if ($plugin['Author'] == "Brainsonic"):
                  $isActive = is_plugin_active($key);
                  $isCore = false;
                  $coreVersion = 0;
                  $isCoreV2 = false;
                  $keyBase = array_shift(explode('/', $key));
                  foreach($corePlugins as $core) {
                    if ($core->slug == $keyBase) {
                      $isCore = true;
                      $coreVersion = 1;
                      foreach($corePluginsV2 as $coreV2) {
                        if ($core->class == $coreV2->class) {
                          $coreVersion = 2;
                          break;
                        }
                      }
                      break;
                    }
                  }
            ?>
            <tr class="<?php echo ($isActive ? "active" : "inactive"); ?> <?php echo ($isActive && !$isCoreV2 ? "update" : ""); ?>">
              <th class="check-column"></th>
              <td><strong><?php echo($plugin['Name']); ?></strong></td>
              <td><?php echo($isActive ? 'Yes' : ''); ?></td>
              <td><?php echo($isCore ? ($coreVersion < 2 ? '<span style="color:darkred;">Yes (v1)</span>' : 'Yes (v2)') : ''); ?></td>
              <td><?php echo($plugin['Description']); ?>
            </tr>
            <?php
                endif;
              endforeach;
            ?>
          </tbody>
          <tfoot><tr>
            <th class="manage-column check-column"></th>
            <td class="manage-column primary-column">Name</td>
            <td class="manage-column">Active</td>
            <td class="manage-column">Core</td>
            <td class="manage-column">Description</td>
          </tr></tfoot>
        </table>
      </div>
      <?php
    }
    
  }
}