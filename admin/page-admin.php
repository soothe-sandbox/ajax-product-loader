<?
class Sapl_Ajax_Page_Admin {

  /*
   * Initialization
   */
  public static function init_page()
  {
    add_filter(
      'woocommerce_settings_tabs_array',
      array( __CLASS__, 'add_settings_tab' ),
      50
    );

    self::init_settings();
    self::init_options();
  }

  public static function init_settings()
  {
    add_action(
      'woocommerce_settings_tabs_sapl_admin_page',
      array( __CLASS__, 'populate_settings_tab' )
    );
  }

  public static function init_options()
  {
    add_action(
      'woocommerce_update_options_sapl_admin_page',
      function(){
        woocommerce_update_options( self::get_settings() );
      }
    );
  }

  /*
   * Create Fields
   */
  public static function add_settings_tab( $settings_tabs ) {
    $settings_tabs['sapl_admin_page'] = __( 'Ajax Product Loader', 'soothe-ajax-product-loader' );
    return $settings_tabs;
  }

  public static function populate_settings_tab() {
    woocommerce_admin_fields( self::get_settings() );
  }

  public static function get_settings() {
    $settings = array(
      'section_main' => array(
        'title' => __( 'Main Settings', 'soothe-ajax-product-loader' ),
        'type'  => 'title',
        'desc'  => 'This is main settings which are required for Ajax Loader to work properly.',
        'id'    => 'salp_section_main'
      ),
      'type' => array(
        'name'    => __( 'Type', 'soothe-ajax-product-loader' ),
        'type'    => 'radio',
        'id'      => 'salp_type',
        'options' => array(
          'scroll' => 'Infinite Scroll',
          'button' => 'Load More Button'
        ),
        'default'  => 'scroll'
      ),
      'product_amount' => array(
        'name' => __( 'Product per Page', 'soothe-ajax-product-loader' ),
        'type' => 'number',
        'id'   => 'salp_product_amount',
        'css'  => 'width: 50px;',
        'desc_tip' =>'Products amount initially displayed on Shop page.'
      ),
      'product_load_amount' => array(
        'name' => __( 'Product per Load', 'soothe-ajax-product-loader' ),
        'type' => 'number',
        'id'   => 'salp_product_load_amount',
        'css'  => 'width: 50px;',
        'desc_tip' =>'Products amount that will be loaded with Ajax on Shop page.'
      ),
      'section_main_end' => array(
        'type' => 'sectionend',
        'id'   => 'salp_section_main'
      ),

      'section_effects' => array(
        'title' => __('Effects Settings', 'soothe-ajax-product-loader'),
        'type'  => 'title',
        'desc'  => 'Additional Effects to prettify loading',
        'id'    => 'salp_section_effects'
      ),
      'product_load_animation' => array(
        'name' => __('Loader', 'soothe-ajax-product-loader'),
        'type' => 'radio',
        'id'   => 'sapl_product_loader',
        'options' => array(
          'yes'   => 'Yes',
          'no'   => 'No'
        ),
        'default'  => 'no',
        'desc_tip' => 'While products is loading, nice svg/gif loader may be showing.'
      ),
      'proudct_show_animation' => array(
        'name' => __('Show Animation', 'soothe-ajax-product-loader'),
        'type' => 'radio',
        'id'   => 'sapl_product_show_animation',
        'options' => array(
          'yes'   => 'Yes',
          'no'   => 'No'
        ),
        'default'  => 'no',
        'desc_tip' => 'Product can load with cute animation.'
      ),
      'section_effects_end' => array(
        'type' => 'sectionend',
        'id'   => 'salp_section_effects'
      )
    );
    return apply_filters( 'wc_settings_tab_demo_settings', $settings );
  }

}

Sapl_Ajax_Page_Admin::init_page();