<?php

namespace CL\NAMESPACE;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Class NAMESPACE
 * @package CL\NAMESPACE
 */
class Main {
  private $db;

  /**
   * Constructor function
   */
  public function __construct( $globaldb ) {
    $this->db = $globaldb;
  }

  /** 
   * Public Functions
   * ---------------------------------------------------------------
   */

  /**
   * Admin Func
   * 
   * fb - formbuilder object
   */
  public function admin_func( $fb ) {



    ob_start(); 
      
      require MAIN_TEMPLATES_DIR . 'admin-template.php';
    
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  /**
   * Subpage Func
   * 
   * fb - formbuilder object
   */
  public function subpage_func( $fb ) {



    ob_start(); 
      
      require MAIN_TEMPLATERS_DIR . 'subpage-template.php';
    
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  /**
   * Shortcode Func
   * 
   */
  public function shortcode_func(  ) {



    ob_start(); 
      
      require MAIN_TEMPLATERS_DIR . 'shortcode-template.php';
    
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  /** 
   * Private Functions
   * ---------------------------------------------------------------
   */

  /**
   * 
   */
  private function _front_form_messages( $type = 'error', $message = '' ) {
    if ( $type == 'marketing' ) {
      $message = '
        <h2>Find new recruits fast!</h2>
        <p>Looking to fill open positions in your public service organization? Sign up with us to access a pool of qualified candidates and easily post job listings. Find the perfect fit for your team with our user-friendly platform.</p>
        <a href="/pricing/" class="btn">See Pricing &raquo;</a>
      ';
    } 
    
    if ( empty($message) ) {
      return;
    }

    return '<div class="front-form-message '.$type.'">'.$message.'</div>';
  }

  /**
   * 
   */
  private function _check_key_existence($array, $keyvalue = '', $return = 'active') {
    if (empty($keyvalue)) return;
    if (count($array) == 0) return;

    //echo $keyvalue .' ';

    foreach ($array as $key => $value) {
      //echo $key .' ';
      if ( strpos($key, $keyvalue) !== false ) {
        //$number = substr($key,strrpos($key,'_'));
        return $return;
      }
    }
  }

  /**
   * 
   */
  private function _unserialize_print( $string, $slug = '' ) {
    if (empty($string)) return;
    $return = $seperator = '';

    $array = unserialize($string);
    foreach ($array as $value) {
      $new = str_replace($slug, '', $value);
      $new = str_replace('_', ' ', $new);

      $return .= $seperator . $this->_un_codify($new);
      $seperator = ', ';
    }
    return $return;
  }

  /**
   * 
   */
  private function _build_pagination( $full_count, $posts_per, $current_page_num, $front = false ) {
    $num_of_pages = ceil((intval($full_count) / intval($posts_per)));
    if ($num_of_pages <= 1) return '<div class="search-pagination"></div>';
    $get = $_GET;
    $current = intval($get['main_jobs_page']);

    if ($front) {
      $url = get_bloginfo('url').'/search/';
    } else {
      $url = esc_url( admin_url( 'admin.php' ) );
    }

    ob_start(); 
    
      require MAIN_TEMPLATES_DIR . 'components/pagination.php';

    $html = ob_get_contents();
    ob_end_clean();
    return '<div class="search-pagination">'.$html.'</div>';
  }

  /**
   * 
   */
  private function _build_flex_table( $jobs ) {
    if (empty($jobs)) return;
    $jobs = stripslashes_deep($jobs);

    ob_start(); 
    
      require MAIN_TEMPLATES_DIR . 'components/flex-table.php';

    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  /**
   * 
   */
  private function _un_codify( $val ) {
    return ucfirst(str_replace('_', ' ', $val));
  }

  /**
   * 
   */
  private function _build_simple_table( $jobs, $head = '' ) {
    if (empty($jobs)) return;
    $jobs = stripslashes_deep($jobs);

    ob_start(); 
    
      require MAIN_TEMPLATES_DIR . 'components/simple-table.php';

    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  /**
   * Gets the title of the media from the media library id
   */
  private function _get_media_title($id) {
    return basename(get_attached_file( $id ));
  }

  /**
   * 
   */
  private function _get_media_url($id) {
    return wp_get_attachment_url( $id );
  }

  /**
   * 
   * https://developer.wordpress.org/reference/hooks/admin_notices/
   */
  private function _display_admin_message($message_type, $message) {
    $type = '';
    $machine_type = '';

    switch ($message_type) {
      case 'error':
        $machine_type = "notice-error";
        $type = "Error:";
      break;
      case 'warning':
        $machine_type = "notice-warning";
        $type = "Warning:";
      break;
      case 'success':
        $machine_type = "notice-success";
        $type = "Success:";
      break;
      case 'info':
        $machine_type = "notice-info";
        $type = "Info:";
      break;
    }

    return '<div class="notice '.$machine_type.' is-dismissible"><p>'.$type.' '.$message.'</p></div>';
  }
}