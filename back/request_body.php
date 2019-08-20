<?
error_log('Responce - Body');
$responce = array( );

if($posts->have_posts()) {

  ob_start();
  while($posts->have_posts()): $posts->the_post();

    include get_template_directory() . '/woocommerce/content-product.php';

  endwhile;
  $responce['posts_data'] = ob_get_clean();

  wp_send_json($responce);
} else {
  ob_start();
  ?>

  <!-- No Posts Were Found! -->

  <?
  $responce['posts_data'] = ob_get_clean();

  wp_send_json($responce);
}