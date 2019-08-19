<?
add_action('woocommerce_after_shop_loop', 'salp_add_load_trigger');
function salp_add_load_trigger()
{
  if( get_option('salp_type')=='scroll' )
  {
    $loader = plugin_dir_url(__FILE__) . 'front/assets/ajax-loader.svg';

    echo '<div class="sapl-scroll-loader"><img src="'. $loader .'" alt=""></div>';
    echo '<div class="sapl-scroll-trigger"></div>';
  }
}