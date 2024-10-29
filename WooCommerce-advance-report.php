<?php
/*Plugin Name: ASPL Advance Report for Woocommerce
	Plugin URI: https://acespritech.com/services/wordpress-extensions/
	Description:  Woocommerce Advance Report plugin shows you all sales and order  information in one report dashboard in very easy to understand graph view format .
	Author: Acespritech Solutions Pvt. Ltd.
	Author URI: https://acespritech.com/
	Version: 1.1.0
	Domain Path: /languages/
	Requires WooCommerce: 4.9
 *  WC requires at least: 3.0.0
 *  WC tested up to: 3.8.1
*/
if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}
function war_installer(){
    include('include/war_db.php');
}
register_activation_hook( __file__, 'war_installer' );

add_action( 'init', 'war_log_user' );

function war_log_user() {
     
    if(!war_check_ip_exist($_SERVER['REMOTE_ADDR'])){

        global $wpdb;

        $table_name = $wpdb->prefix . 'advance_report_visit_count';

        $sqlQuery = "INSERT INTO $table_name VALUES (NULL,'".$_SERVER['REMOTE_ADDR']."' , NULL ) ";
        $sqlQueryResult = $wpdb -> get_results($sqlQuery);

    }
}

function war_check_ip_exist($ip)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'advance_report_visit_count';

    $sql = "SELECT COUNT(*) FROM $table_name WHERE IP='".$ip."' AND DATE(Time)='".date('Y-m-d')."'";

    $count = $wpdb -> get_var($sql);
   
    return $count;
}


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) 
{
  add_action('wp_enqueue_scripts', 'war_register_script');
  add_action('admin_enqueue_scripts', 'war_script_admin');
}
else{ 
    deactivate_plugins(plugin_basename(__FILE__));
    add_action( 'admin_notices', 'war_woo_not_installed' );
}
add_action('admin_menu', 'war_add_menu');

function war_add_menu() 
{
    add_menu_page('Woocommerce Reports', 'Woocommerce Reports', 'manage_options', 'advance_report', 'war_advance_report_dashboard' , 'dashicons-format-aside');
}

include('include/dashboard.php');

function war_woo_not_installed()
{
    ?>
    <div class="error notice">
      <p><?php _e( 'You need to install and activate WooCommerce to use WooCommerce Advance Report!', 'WooCommerce-Advance-Report' ); ?></p>
    </div>
    <?php
}

function war_script_admin($hook_suffix){
  if($hook_suffix == 'toplevel_page_advance_report'){
   
    wp_enqueue_style( 'advance_report_admin_style', plugins_url('/css/style.css', __FILE__) );
    wp_enqueue_style( 'advance_report_admin_bootstrap', plugins_url('/css/bootstrap.min.css', __FILE__) );
    wp_enqueue_style( 'advance_report_fa_admin_style', plugins_url('/css/font-awesome.min.css', __FILE__) );
    
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
    wp_enqueue_script( 'advance_report_custom', plugins_url('/js/custom.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'advance_report_chart', plugins_url('/js/Chart.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'advance_report_gchart_loader', plugins_url('/js/gchart_loader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'advance_report_fa_admin_script', plugins_url('/js/fontawesome.min.js', __FILE__), array('jquery') );
    
  }
}

function war_register_script()
{
  global $post;
  global $wp;
  $current_url = home_url( $wp->request );    
}








