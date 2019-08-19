<?
add_action('wp_ajax_sapl_request_simple', 'sapl_request_simple');
add_action('wp_ajax_nopriv_sapl_request_simple', 'sapl_request_simple');
function sapl_request_simple()
{
  echo 'Success';
  wp_die();
}