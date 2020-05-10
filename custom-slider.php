<?php
/*
	Plugin Name: Custom-slider
*/

add_action('admin_menu', 'my_menu_pages');
function my_menu_pages(){
    add_menu_page('Custom Slider', 'Custom Slider', 'manage_options', 'my-menu', 'my_menu_output','dashicons-slides' );
    add_submenu_page('my-menu', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
}

function wpdocs_selectively_enqueue_admin_script( $hook ) {
    wp_enqueue_media();
    
    wp_enqueue_style( 'style-css', plugin_dir_url( __FILE__ ) . 'asset/css/style.css' );
    wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'asset/js/myscript.js', array('jquery'), '1.0' );
    wp_localize_script( 'my_custom_script', 'plugin_dir',array('path' => plugin_dir_url( __FILE__ )));
}
add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );

function my_custom_plgin_script() {
    wp_enqueue_style( 'slick', plugin_dir_url( __FILE__ ) . 'asset/css/slick.css' );
    wp_enqueue_style( 'slick-theme', plugin_dir_url( __FILE__ ) . 'asset/css/slick-theme.css' );
	wp_enqueue_style( 'custom_css', plugin_dir_url( __FILE__ ) . 'asset/css/custom.css' );
	wp_enqueue_script( 'slick_js', plugin_dir_url( __FILE__ ) . 'asset/js/slick.min.js', array('jquery'), '1.0' );
	wp_enqueue_script( 'custom_js', plugin_dir_url( __FILE__ ) . 'asset/js/custom.js', array('jquery'), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_plgin_script' );

function my_menu_output()
{
	require_once('slide-setting.php');
}


 
// function to create the DB / Options / Defaults					
function my_plugin_create_db() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'custom_slide';

	$sql = "CREATE TABLE $table_name (
				id int(11) AUTO_INCREMENT DEFAULT NULL,
				img_id int(11) DEFAULT NULL,
                order_num int(11) DEFAULT NULL,
                PRIMARY KEY  (id)
			) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'my_plugin_create_db');

function custom_slider_shorcode()
{
	ob_start();
	global $wpdb;
        $fivesdrafts = $wpdb->get_results("SELECT * FROM wp_custom_slide ORDER BY order_num");
		?>
		<div class="single-item">
		<?php
        foreach ($fivesdrafts as $value) {
            $img_atts = wp_get_attachment_image_src($value->img_id, 'full');
			?>
				<div class="inner_item"><img src="<?=$img_atts[0]?>"></div>
			<?php
		}
	?>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode("show_slider","custom_slider_shorcode");

