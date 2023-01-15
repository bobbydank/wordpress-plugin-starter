<?php

/** ------------------------------------------------------------
 * ADMIN PAGES */

function main_admin_simple_entries() {
  global $main;
  echo $main->admin_simple_entries();
}

function main_subpage_func() {
  global $main, $main_formbuilder;
  echo $main->subpage_func( $main_formbuilder );
}

function main_admin_func() {
  global $main, $main_formbuilder;
  echo $main->admin_func( $main_formbuilder );
}

function main_admin_page() {
  //add a settings page
	add_menu_page('Title', 'title', 'moderate_comments', 'main_admin', 'main_admin_func');

  //subpage
	add_submenu_page( 'main_admin', 'Title', 'Title', 'moderate_comments', 'main_title', 'main_subpage_func' );
}
add_action('admin_menu', 'main_admin_page');

/** ------------------------------------------------------------
 * SHORTCODES */

function main_shortcode_func() {
  global $main;
  return $main->shortcode_func();
}
add_shortcode('main_shortcode', 'main_shortcode_func');

/** ------------------------------------------------------------
 * SCRIPT AND STYLE ENQUEUES */

// frontend enqueues
function main_frontend_enqueues() {
  global $main_core;
  $dir = plugin_dir_url( __FILE__ ) . '../assets/';

  $scripts = array(
    'main_scripts'       => $dir . 'js/scripts.js',
  );
  $styles = array('main_form' => $dir . 'css/form.css');

  //the work
  $main_core->register_scripts( $scripts );
  $main_core->register_styles( $styles );
}
add_action( 'wp_enqueue_scripts', 'main_frontend_enqueues' );

// admin enqueues
function main_admin_enqueues() {
  global $main_core;
  $dir = plugin_dir_url( __FILE__ ) . '../assets/';

  //for media picker
  wp_enqueue_media();

  $scripts = array(
    'main_admin_scripts' => $dir . 'js/admin-scripts.js'
  );
  if ($_GET['page'] === 'main_add_job') {
    $scripts['main_admin_gmap'] = 'https://maps.googleapis.com/maps/api/js?key=';
    $scripts['main_map_scripts'] = $dir . 'js/admin-map.js';
  }
  
  $styles = array(
    'main_admin_form'   => $dir . 'css/form.css',
    'main_admin_styles' => $dir . 'css/admin.css'
  );

  //the work
  $main_core->register_scripts( $scripts );
  $main_core->register_styles( $styles );
}
add_action( 'admin_enqueue_scripts', 'main_admin_enqueues' );