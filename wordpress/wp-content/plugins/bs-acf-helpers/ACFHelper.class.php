<?php

namespace Bs\Helpers {
  class ACFHelper {
    
    public static function registerGroup($group) {
      if (function_exists("register_field_group")) {
        register_field_group($group);
      }
    }
    
    public static function generateKey($name, $group='') {
      return ('field_'.md5($group.'/'.$name));
    }
    
    public static function createField($label, $name, $options) {
      return array_replace($options, array(
        'key' => null,
        'label' => $label,
        'name' => $name
      ));
    }
    public static function createTextField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'html',
        'maxlength' => '',
      ), $options));
    }
    public static function createTextAreaField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'textarea',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'formatting' => 'html',
      ), $options));
    }
    public static function createRichTextField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'wysiwyg',
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
      ), $options));
    }
    public static function createURLField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'url',
        'default_value' => '',
        'placeholder' => '',
      ), $options));
    }
    public static function createImageField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => "thumbnail",
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
      ), $options));
    }
    public static function createRepeaterField($label, $name, $fields, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'repeater',
        'min' => '',
        'max' => '',
        'layout' => 'block',
        'button_label' => 'Ajouter un élément',
        'sub_fields' => $fields,        
      ), $options));
    }

    public static function createSelectField($label, $name, $choices, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'select',
        'choices' => $choices,
        'default_value' => '',
        'allow_null' => false,
        'multiple' => 0,
        'ajax' => 0
      ), $options));

    }
    public static function createCheckboxField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'true_false',
        'default_value' => 0,
      ), $options));

    }
    public static function createColorPickerField($label, $name, $options=[]) {
      return self::createField($label, $name, array_replace(array(
        'type' => 'color_picker',
        'default_value' => '',
      ), $options));
    }

    public static function createGroup($id, $label, $fields, $location, $options) {
      $fields = self::generateMissingKeys($id, $fields);
      return array (
        'id' => $id,
        'title' => $label,
        'fields' => $fields,
        'location' => $location,
        'options' => $options,
        'menu_order' => 0,
      );
    }
    public static function createTemplatedGroup($id, $label, $templates, $fields) {
      $group_id = $id;
      $group_label = $label;
      $group_fields = $fields;
      $group_location = array(array(array()));
      $group_options = array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array ()
      );
      
      foreach($templates as $key => $values) {
        switch($key) {
          case 'postType' :
            $group_location[0][0] = array(
              'param' => 'post_type', 'value' => $values,
              'operator' => '==', 'order_no' => 0, 'group_no' => 0,
            );
            break;
          case 'userType' :
            $group_location[0][0] = array(
              'param' => 'ef_user', 'value' => $values,
              'operator' => '==', 'order_no' => 0, 'group_no' => 0,
            );
            break;
          case 'taxonomy' :
            $group_location[0][0] = array(
              'param' => 'ef_taxonomy', 'value' => $values,
              'operator' => '==', 'order_no' => 0, 'group_no' => 0,
            );
            break;
          case 'optionPage' :
            $group_location[0][0] = array(
              'param' => 'options_page', 'value' => $values,
              'operator' => '==', 'order_no' => 0, 'group_no' => 0,
            );
            break;
          case 'layout' :
            $group_options = array (
              'position' => (in_array('sidebox', $values) ? 'side' : (in_array('pre-content', $values) ? 'acf_after_title' : 'normal')),
              'layout' => (in_array('seamless', $values) ? 'no_box' : 'default'),
              'hide_on_screen' => array ()
            );
            break;
          default: // noop
        }
      }
      
      return self::createGroup($group_id, $group_label, $group_fields, $group_location, $group_options);
    }
    
    private static function generateMissingKeys($group, $fields) {
      foreach($fields as $i => $field) {
        if ($field['key'] == null) {
          $fields[$i]['key'] = self::generateKey($field['name'], $group);
          if ($field['type'] == 'repeater') {
            $fields[$i]['sub_fields'] = self::generateMissingKeys($group.'/'.$field['name'], $field['sub_fields']);
          } else if ($field['type'] == 'flexible_content') {
            foreach($field['layouts'] as $j => $layout) {
              $fields[$i]['layouts'][$j]['sub_fields'] = self::generateMissingKeys($group.'/'.$field['name'].'/'.$layout['key'], $layout['sub_fields']);
            }
          }
        }
      }
      return $fields;
    }
  }
}

namespace {
  class ACFHelper extends Bs\Helpers\ACFHelper {}
}