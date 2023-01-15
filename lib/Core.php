<?php

namespace CL\NAMESPACE;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Core
 * @package CL\FRCore
 */
class Core {

  protected $version = '';
  protected $assetsDir = '';

  /**
   * 
   */
  public function __construct( $ver = '' ) {
    if (empty($ver)) {
      $ver = time();
    }

    $this->version = $ver;
  }
 
  /**
   * register styles
   */
  function register_styles( $styles ) {
    if (empty($styles)) {
      return;
    }

    foreach ($styles as $key => $style) {
      wp_enqueue_style( 'clmain-'.$key, $style, array(), $this->version, false );
    }
  }

  /**
   * register scripts
   */
  function register_scripts( $scripts ) {
    if (empty($scripts)) {
      return;
    }

    foreach ($scripts as $key => $script) {   
      wp_enqueue_script( 'clmain-'.$key, $script, array(), $this->version, true );
    }
  }

  /**
   * Add shortcode
   */
  public function add_shortcodes( $shortcodes ) {
    if (empty($shortcodes)) {
      return;
    }

    foreach ( $shortcodes as $name => $callback ) {
      add_shortcode( $name, $callback );
    }
  }

  /**
   * Register elementor widgets
   */
  public function register_elementor_widgets( $widgets ) {
    if (class_exists('\Elementor\Plugin')) {
      foreach ( $widgets as $widget ) {
        if ( ! class_exists( $widget ) ) {
          continue;
        }
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $widget );
      }
    }	
  }
}

