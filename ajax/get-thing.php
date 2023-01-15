<?php
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php'); // file in root wordpress folder
$return = array();
$return['response'] = 200;
global $wpdb;


if (isset($_POST['p'])) {
    $cities = $wpdb->get_results("SELECT * FROM TABLE WHERE `column` = ".$_POST['p']." ORDER BY COLUMN ASC"); 
		
    //die('<pre>'.print_r($counties, true).'</pre>');
    echo json_encode($cities);
}