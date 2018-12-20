<?php
/**
 * @author Grasset Florian <florian.grasset@brainsonic.com>
 */

require_once dirname(__DIR__) . '/interfaces/IWPObject.interface.php';

class BsTaxonomyBase implements IWPObject, IMetaContainer
{
  const TAXONOMY_TYPE = null;
  const TAXONOMY_POST_TYPE = null;
   
  private static $types;
  
  protected $id;
  protected $termData;
  
  /**
   * Constructor
   *
   * @param string $slug Slug of the new post type
   * @param array $options Options of the new post type
   */
  public static function createType($class = null, $options = null)
  {
    if (!is_array(self::$types)) {
      self::$types = array();
    }
    if (!isset(self::$types[static::TAXONOMY_TYPE])) {
      self::$types[static::TAXONOMY_TYPE] = array('class' => $class, 'options' => $options);

      if(!taxonomy_exists(static::TAXONOMY_TYPE)) {
        add_action('init', array($class, 'registerType'), 0);
      }
      if (class_exists('ACFHelper')) {
        self::registerACF($class);
      }
    }
  }

  /**
   * Register new post type with configuration
   */
  public static function registerType()
  {
    register_taxonomy(static::TAXONOMY_TYPE, explode(',', static::TAXONOMY_POST_TYPE), self::$types[static::TAXONOMY_TYPE]['options']);
  }
  
  /**
   * Register ACF if plugin is active
   */
  public static function getACFGroups()
  {
    return array();
  }
  private static function registerACF($class) {
    $groups = $class::getACFGroups();
    foreach($groups as $group) {
      ACFHelper::registerGroup($group);
    }
  }
  
  public static function create($source) {
    if ($source == null) {
      return null;
    }
    if (is_array($source)) {
      $return = array();
      foreach($source as $post) {
        $return[] = static::create($post);
      }
      return $return;
    }
    // else
    if (!($source instanceof WP_Term)) {
      $source = get_term( $source );
    }
    $taxonomyType = $source->taxonomy;
    if (isset(self::$types[$taxonomyType])) {
      return new self::$types[$taxonomyType]['class']($source);
    }
    return new BsTaxonomyBase($source);
  }
  /**********************/

  public function __construct($idOrTerm=null) {
    if ($idOrTerm instanceof WP_Term) {
      $this->id = $idOrTerm->term_id;
      $this->termData = $idOrTerm;
    } else {
      $this->id = $idOrTerm;
    }
  }
  
  public function getName() {
    return $this->getWpData('name');
  }
  public function getSlug() {
    return $this->getWpData('slug');
  }
  public function getDescription() {
    return $this->getWpData('description');
  }
  public function getPermalink() {
    return get_term_link($this->wpId());
  }
  
  /**
   * implements interface : IWPObject
   */
  public function wpId() {
    return $this->id;
  }
  public function getWpData($key) {
    if (!isset($this->termData)) {
      $this->termData = get_term( $this->id, static::TAXONOMY_TYPE );
    }
    return $this->termData->$key;
  }
  
  /**
   * implements interface : IMetaContainer
   */
  public function getMetadata($key) {
    if (function_exists("get_field")) {
      $field = get_field_object($key, static::TAXONOMY_TYPE.'_'.$this->id);
      if (!empty($field)) {
        return $field['value'];
      }
    }
    return null;
  }
  public function setMetadata($key, $value) {
    if (function_exists("update_field")) {
      $field = get_field_object($key, static::TAXONOMY_TYPE.'_'.$this->id);
      if (!empty($field)) {
        update_field($field['key'], $value, static::TAXONOMY_TYPE.'_'.$this->id);
        return;
      }
    }
  }
}
