<?
class Sapl_Requests {
  /* ==============================
   * # INIT
   * ============================== */
  public static function init()
  {
    add_action('wp_ajax_sapl_request_simple', array(__CLASS__, 'request'));
    add_action('wp_ajax_nopriv_sapl_request_simple', array(__CLASS__, 'request'));

    // add_filter('woocommerce_post_class', function($classes){
    //   if(is_shop() && is_ajax()){
    //     $classes[] = 'm-sapl-product-new';
    //   }
    //   return $classes;
    // });
  }

  /* ==============================
   * # PARAMS
   * ============================== */
  private static $default_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'order'          => 'DESC',
    'orderby'        => 'menu_order',
  );

  private function get_args(){
    return self::$default_args;
  }

  /* ==============================
   * # REQUEST
   * ============================== */
  private function get_request_type(){
    
  }

  public static function request()
  {
    // Debug
    error_log('Requst - Base');

    self::request_simple();
  }

  private static function request_simple()
  {
    // Debug
    error_log('Requst - Simple');

    $args = array(
      'page' => 'page'
    );

    // DB request for posts
    $posts = self::db_request($args);

    // Output DB request result
    self::request_responce($posts);
  }

  private static function request_responce($posts)
  {
    // Debug
    error_log('Request - Responce');

    include plugin_dir_path(__FILE__) . 'request_body.php';
  }

  /* ==============================
   * # DB
   * ============================== */
  private static function db_request($args)
  {
    // Debug
    error_log('DB - Request');

    $request_args = wp_parse_args( $args, self::$default_args );

    return $request = new WP_Query($request_args);
  }
}

// Requests Initialization
Sapl_Requests::init();