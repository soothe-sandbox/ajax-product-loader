<?
add_action('wp_enqueue_scripts', 'salp_add_front_assets');
function salp_add_front_assets()
{
  wp_register_script(
    'js-salp-front',
    plugin_dir_url(__FILE__) . 'assets/salp-front.js',
    array( 'jquery', 'js-anime' ),
    plugin_dir_path(__FILE__) . 'assets/salp-front.js',
    true
  );
  wp_enqueue_script( 'js-salp-front' );

  wp_register_script(
    'js-anime',
    plugin_dir_url(__FILE__) . 'assets/lib/anime.min.js',
    array(  ),
    '',
    true
  );
  wp_enqueue_script( 'js-anime' );

  wp_localize_script(
    'js-salp-front',
    'wpSapl',
    array(
      'type'          => get_option('salp_type'),
      'ppp'           => get_option('salp_product_load_amount'),
      'loadPrdAmount' => get_option('salp_product_load_amount'),
      'loadAnimation' => get_option('salp_product_loader'),
      'ajaxUrl'       => admin_url('admin-ajax.php')
    )
  );

  wp_register_style(
    'css-salp-front',
    plugin_dir_url(__FILE__) . 'assets/salp-front.css',
    array(  ),
    plugin_dir_path(__FILE__) . 'assets/salp-front.css'
  );
  wp_enqueue_style( 'css-salp-front' );
}