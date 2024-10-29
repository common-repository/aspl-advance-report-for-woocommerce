<?php 
if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}
global $wpdb;
$table_name = $wpdb->prefix . "advance_report_visit_count";
// $my_products_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            `LogID` int(11) NOT NULL AUTO_INCREMENT,
        	`IP` varchar(20) NOT NULL,
        	`Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
         	PRIMARY KEY (`LogID`)
    )$charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    // add_option( my_db_version', $my_products_db_version );
}


 ?>