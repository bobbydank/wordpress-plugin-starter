<?php

namespace CL\NAMESPACE;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Class DB
 * @package CL\DB
 */
class DB {
  private $wpdb;

  public function __construct( $globaldb ) {
    $this->wpdb = $globaldb;
  }

  /** 
   * Public Functions
   * ---------------------------------------------------------------
   */

  

  /**
   * 
   */
  public function get_single( $id ) {
    $query = "SELECT * FROM " . $this->wpdb->prefix ."TABLE WHERE id = " . $id . " ORDER BY created DESC";
    $results = $this->wpdb->get_results( $query );
    return $results[0];
  }

  /**
   * 
   */
  public function get_many( $id ) {
    $query = "SELECT * FROM " . $this->wpdb->prefix ."TABLE WHERE id = " . $id . " ORDER BY created DESC";
    return $this->wpdb->get_results( $query );
  }

  /**
   * 
   */
  public function update_data( $id, $data ) {
    $save = $this->_prep_data_for_save( $data );

    $return = $this->wpdb->update(
      $this->wpdb->prefix . "jobs",
      $save,
      array( 'id' => $id )
    );

    //echo '<pre>'.print_r($save, true).'</pre>';
    return $return;
  }

  /**
   * 
   */
  public function save_data( $data ) {
    $save = $this->_prep_data_for_save( $data );

    $return = $this->wpdb->insert(
      $this->wpdb->prefix . "jobs",
      $save
    );

    //echo '<pre>'.print_r($save, true).'</pre>';
    return $return;
  }

  /**
   * 
   */
  public function simple_query( $query ) {
    if ( empty($query) ) return;
    return $this->wpdb->get_results($query); 
  }

  /** 
   * Private Functions
   * ---------------------------------------------------------------
   */

  /**
   * 
   */
  private function _prep_data_for_save( $data ) {
    $save = array();

    foreach ($data as $key => $v) {
      $value = $v;

      if (is_array($v)) {
        $value = serialize($v);
      } 

      $save[$key] = $value;
    }

    return $save;
  }
}