<?php
/**
 * Plugin Name: Wordpress Plugin Starter
 * Description: Plugin for the this website. Built by Bobby Danklefsen.
 * Plugin URI: https://www.bobbydank.com/
 * Author: Bobby Danklefsen
 * Version: 1.0
 * Author URI: https://www.bobbydank.com/
 *
 * Text Domain: cl_main
 *
 * @package CL\NAMESPACE
 * @category Core
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; 
}

/* ------------------------------------------------------------
  Defines */

define( 'MAIN_TEMPLATES_DIR', plugin_dir_path( __FILE__ ) . '/templates/' );

/* ------------------------------------------------------------
  Requires */

require_once 'lib/Core.php';
require_once 'lib/FormBuilder.php';
require_once 'lib/Main.php';
require_once 'lib/DB.php';

/* ------------------------------------------------------------
  Global Vars */

use \CL\NAMESPACE\Main;
use \CL\NAMESPACE\DB;
global $wpdb;

$main_db = new DB( $wpdb );
$main_core = new \CL\NAMESPACE\Core;
$main_formbuilder = new \CL\NAMESPACE\FormBuilder;
$main = new Main( $main_db );

/* ------------------------------------------------------------
  Hooks */

require_once 'lib/Hooks.php';

