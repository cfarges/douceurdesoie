<?php

namespace Bs\Models {
  use Bs\Bases\PostBase;
  use Bs\Helpers\ACFHelper;
  
  class Sample extends PostBase
  {
    const POST_TYPE = 'Sample';

    public static function createType($class = NULL, $options = NULL) {
      parent::createType(__CLASS__, array(
        'hierarchical'          => false,
        'public'                => true,
        'has_archive'           => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'capability_type'       => 'post',
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-chart-bar',
        'labels'                => array(
          'name'          => __('Sample'),
          'menu_name'     => __('Samples'),
          'singular_name' => __('Sample'),
          'add_new'       => __('Ajouter un Sample'),
          'add_new_item'  => __('Ajouter un nouveau Sample'),
          'edit_item'     => __('Modifier le Sample'),
          'new_item'      => __('Nouveau Sample'),
          'all_items'     => __('Tous les Samples'),
          'view_item'     => __('Afficher le Sample'),
        )
      ));
    }
    public static function getACFGroups() {
      return array(
        ACFHelper::createTemplatedGroup('acf_survey-entity_id', 'Entity ID', array(
          'postType' => self::POST_TYPE,
          'layout' => array('sidebox')
        ), array(
          ACFHelper::createTextField('field_1234561234567', 'Entity ID', 'entity_id'),
        ))
      );
    }
    public function getEntity() {
      return $this->getMetadata('entity_id');
    }
  }
}