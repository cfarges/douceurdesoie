<?php
/**
 * @author Grasset Florian <florian.grasset@brainsonic.com>
 */

require_once dirname(__DIR__) . '/interfaces/IMetaContainer.interface.php';
require_once dirname(__DIR__) . '/interfaces/IWPUser.interface.php';
 
class BsUserBase implements IWPUser, IMetaContainer
{
  const FORCE_REFRESH = false;
  
  const USER_TYPE = null;
  const USER_TYPE_NAME = null;
  
  private static $types;
  
  protected $id;
  protected $userData;
  
  /**
   * Constructor
   *
   * @param string $slug Slug of the new post type
   * @param array $options Options of the new post type
   */
  public static function createType($class = null, $capabilities = null)
  {
    if (!is_array(self::$types)) {
      self::$types = array();
    }
    if (!isset(self::$types[static::USER_TYPE])) {
      self::$types[static::USER_TYPE] = array('class' => $class, 'capabilities' => $capabilities);;

      if(get_role(static::USER_TYPE) == null) {
        add_role(static::USER_TYPE, static::USER_TYPE_NAME, $capabilities);
      } else if (static::FORCE_REFRESH) {
        remove_role(static::USER_TYPE);
        add_role(static::USER_TYPE, static::USER_TYPE_NAME, $capabilities);
      }
    
      if (class_exists('ACFHelper')) {
        self::registerACF($class);
      }
    }
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
    if (is_array($source)) {
      $return = array();
      foreach($source as $user) {
        $return[] = static::create($user);
      }
      return $return;
    }
    // else
    if (!($source instanceof WP_User)) {
      $source = new WP_User( $source );
    }
    $roles = $source->roles;
    
    if (is_array(self::$types)) {
      foreach(self::$types as $type => $data) {
        if (in_array($type, $roles)) {
          return new self::$types[$type]['class']($source);
        }
      }
    }
    return new BsUserBase($source);
  }
  
  public static function query($args) {
    $users = array();
    
    if (static::USER_TYPE != null) {
      $class = self::$types[static::USER_TYPE]['class'];
      $args['role'] = static::USER_TYPE;
      $query = new WP_User_Query($args);
      foreach ($query->results as $u) {
        $users[] = new $class($u);
      }
    } else {
      $query = new WP_User_Query($args);
      $users = self::create($query->results);
    }
    
    return (object)array('query' => $query, 'users' => $users);
  }
  /**********************/
  
  public function __construct($idOrUser=null) {
    if ($idOrUser instanceof  WP_User) {
      $this->id = $idOrUser->ID;
      $this->userData = $idOrUser;
    } else {
      $this->id = $idOrUser;
    }
  }
  
  /**
   * implements interface : IWPUser
   */
  public function getFirstName() {
    return $this->getMetaData('first_name');
  }
  public function getLastName() {
    return $this->getMetaData('last_name');
  }
  public function getDisplayName() {
    return $this->getWpData('display_name');
  }
  public function getNiceName() {
    return $this->getWpData('user_nicename');
  }
  public function getEmail() {
    return $this->getWpData('user_email');
  }
  public function getDescription() {
    return $this->getWpData('user_description');
  }
  public function getPermalink() {
    return get_author_posts_url($this->wpId(), $this->getNiceName()); // TODO : rework ?
  }
  
  /**
   * implements interface : IWPObject
   */
  public function wpId() {
    return $this->id;
  }
  public function getWpData($key) {
    if (!isset($this->userData)) {
      $this->userData = get_userdata( $this->id );
    }
    return $this->userData->$key;
  }
  
  
  /**
   * implements interface : IMetaContainer
   */
  public function getMetadata($key) {
    if (function_exists("get_field")) {
      $field = get_field_object($key, 'user_'.$this->id);
      if (!empty($field)) {
        return $field['value'];
      }
    }
    return get_user_meta($this->id, $key, true);
  }
  public function setMetadata($key, $value) {
    if (function_exists("update_field")) {
      $field = get_field_object($key, 'user_'.$this->id);
      if (!empty($field)) {
        update_field($field['key'], $value, 'user_'.$this->id);
        return;
      }
    }
    update_user_meta($this->id, $key, $value);
  }
}
