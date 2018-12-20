<?php
/**
 * @author Grasset Florian <florian.grasset@brainsonic.com>
 */

require_once dirname(__DIR__) . '/interfaces/IMetaContainer.interface.php';
require_once dirname(__DIR__) . '/interfaces/IWPPost.interface.php';

class BsPostBase implements IWPPost, IMetaContainer
{
  const POST_TYPE = null;

  private static $types;

  protected $id;
  protected $postData;

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
    if (!isset(self::$types[static::POST_TYPE])) {
      self::$types[static::POST_TYPE] = array('class' => $class, 'options' => $options);

      if(!post_type_exists(static::POST_TYPE)) {
        add_action('init', array($class, 'registerType'));
      } else {
        add_action('init', array($class, 'alterType'));
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
    register_post_type(static::POST_TYPE, self::$types[static::POST_TYPE]['options']);
  }
  
  public static function alterType() {
    
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
    $postType = get_post_type($source);
    if (isset(self::$types[$postType])) {
      return new self::$types[$postType]['class']($source);
    }
    return new BsPostBase($source);
  }

  public static function query($args) {
    $posts = array();

    if (static::POST_TYPE != null) {
      $class = self::$types[static::POST_TYPE]['class'];
      $args['post_type'] = static::POST_TYPE;
      $query = new WP_Query($args);
      foreach ($query->posts as $p) {
        $posts[] = new $class($p);
      }
    } else {
      $query = new WP_Query($args);
      $posts = self::create($query->posts);
      foreach ($query->posts as $p) {
        $posts[] = self::create($p);
      }
    }

    return (object)array('query' => $query, 'posts' => $posts, 'post_count' => count($posts));
  }
  
  public static function queryOne($args) {
    if (!isset($args['posts_per_page'])) {
      $args['posts_per_page'] = 1;
    }
    $query = self::query($args);
    if (isset($query->posts[0])) {
      return $query->posts[0];
    }
    return null;
  }


  /**********************/

  public function __construct($idOrPost=null) {
    if ($idOrPost instanceof WP_Post) {
      $this->id = $idOrPost->ID;
      $this->postData = $idOrPost;
    } else {
      $this->id = $idOrPost;
    }
  }


  /**
   * implements interface : IWPPost
   */
  public function getTitle() {
    return $this->getWpData('post_title');
  }
  public function getName() {
    return $this->getWpData('post_name');
  }
  public function getType() {
    return $this->getWpData('post_type');
  }
  public function getAuthor() {
    return BsUserBase::create($this->getWpData('post_author'));
  }
  public function getPermalink() {
    return get_permalink($this->id);
  }
  public function getThumbnail() {
    return Attachment::create(get_post_thumbnail_id($this->id));
  }
  public function getThumbnailUrl($size) { // DEPRECATED
    $thumbnail = get_post_thumbnail_id($this->id);
    if ($thumbnail != null) {
      return wp_get_attachment_image_src($thumbnail, $size)[0];
    }
    return null;
  }
  public function getContent($raw=false) {
    $content = $this->getWpData('post_content');
    if ($raw) {
      return $content;
    }
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
  }
  public function getExcerpt($raw=false) {
    $excerpt = $this->getWpData('post_excerpt');
    if ($raw) {
      return $excerpt;
    }
    return apply_filters( 'get_the_excerpt', $excerpt );
  }
  public function getPublicationDate($format=null) {
    if (!empty($format)) {
      return mysql2date($format, $this->getWpData('post_date'));
    }
    return mysql2date(get_option('date_format'), $this->getWpData('post_date'));
  }


  /**
   * implements interface : IWPObject
   */
  public function wpId() {
    return $this->id;
  }
  public function getWpData($key) {
    if (!isset($this->postData)) {
      $this->postData = get_post( $this->id );
    }
    return $this->postData->$key;
  }

  /**
   * implements interface : IMetaContainer
   */
  public function getMetadata($key) {
    if (function_exists("get_field")) {
      $field = get_field_object($key, $this->id);
      if (!empty($field)) {
        return $field['value'];
      }
    }
    return get_post_meta($this->id, $key, true);
  }
  public function setMetadata($key, $value) {
    if (function_exists("update_field")) {
      $field = get_field_object($key, $this->id);
      if (!empty($field)) {
        update_field($field['key'], $value, $this->id);
        return;
      }
    }
    update_post_meta($this->id, $key, $value);
  }
}
