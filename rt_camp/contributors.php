<?php

/*
	Plugin Name: WordPress-Contributors
*/

/*
	Load front end style
*/
function wc_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style1', $plugin_url . 'front_style.css' );
}
add_action( 'wp_enqueue_scripts', 'wc_load_plugin_css' );
/**
 * Register meta boxes.
 */
function hcf_register_meta_boxes() {
    add_meta_box( 'hcf-1', __( 'Contributors', 'hcf' ), 'hcf_display_callback', 'post' );
}
add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );


/**
 * Meta box display function.
 */
function hcf_display_callback( $post ) {
    include plugin_dir_path( __FILE__ ) . './form.php';
}

/**
 * Save meta box value.
 */
function hcf_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }

    if($_POST['hcf_author'] && !empty($_POST['hcf_author']))
    {
    	$string = implode(',', $_POST['hcf_author']);
    	update_post_meta( $post_id, 'hcf_author', $string );
    }
}
add_action( 'save_post', 'hcf_save_meta_box' );


function like_content($content) {
	global $post;
	$content = $post->post_content;
	if($post->post_type == 'post')
	{
		$all_author = get_post_meta( $post->ID, 'hcf_author', true );
		$author_array = explode(',', $all_author);
			
		$content .= "<div class='contri_main'>";
		$content .= "<div class='title'>Contributors</div>";
		foreach ($author_array as $value) {
			$user = get_user_by('login',$value);
			if($user)
			{
				$auth_url = get_author_posts_url( $user->ID );
				$img_url = get_avatar_url($user->ID, ['size' => '51']);
			}	
			$content .= "<div class=\"cstm_contributor\">";
			$content .= "<img src='". $img_url ."'>";
			$content .= "<div class='auth_url'><a href='".$auth_url."'>".$value."</a></div>";
			$content .= "</div>";
		}
		$content .= "</div>";
	}
		
return $content;
}
add_filter( 'the_content', 'like_content' );