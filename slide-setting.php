
<?php
global $wpdb;
if(isset($_REQUEST['save_file']))
{
    $myplugin_attachment_id_array = $_POST['myplugin_attachment_id_array'];
    $myplugin_attachment_id_order = $_POST['myplugin_attachment_id_order'];

    $result = $wpdb->get_results("SELECT * FROM wp_custom_slide");
    if(count($result) == 0)
    {
        for($i=0 ; $i < count($myplugin_attachment_id_array); $i++)
        {
            $wpdb->insert( 
                'wp_custom_slide', 
                array( 
                    'img_id'     => (int) $myplugin_attachment_id_array[$i],
                    'order_num' => (int) $myplugin_attachment_id_order[$i]
                )
            );
        }
    }
    else
    {
        $wpdb->query('TRUNCATE TABLE wp_custom_slide');
        for($i=0 ; $i < count($myplugin_attachment_id_array); $i++)
        {
            $wpdb->insert( 
                'wp_custom_slide', 
                array( 
                    'img_id'     => (int) $myplugin_attachment_id_array[$i],
                    'order_num' => (int) $myplugin_attachment_id_order[$i]
                )
            );
        }
    }
    
}
?>
<?php
if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
     update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
    endif;
    // wp_enqueue_media();
?>
<div class="wrap">
	<h1>Custom Slider Settings</h1>
	<form method="post" action="" enctype="multipart/form-data">
    <table class="form-table">
        <tr valign="top">
	        <th scope="row">Upload Image</th>
	        <td><input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image"></td>
        </tr>
        <tr valign="top">
	        <th scope="row">Note Supported image format:</th>
	        <td>.jpeg, .jpg, .png, .gif</td>
        </tr>
    </table>
    
    


    <div class="row" id="sortable">
        <?php 
        $fivesdrafts = $wpdb->get_results("SELECT * FROM wp_custom_slide ORDER BY order_num");
        foreach ($fivesdrafts as $value) {
            $img_atts = wp_get_attachment_image_src($value->img_id, 'full');
        ?>
        <div class="column">
            <img class="close-btn" src="<?=plugin_dir_url( __FILE__ )?>close-icon.png" alt="Snow" style="">
            <img src="<?=$img_atts[0]?>" alt="Snow" style="width:100%">
            <input id="img_<?=$value->img_id?>" type="hidden" name="myplugin_attachment_id_array[]"  value="<?=$value->img_id?>">
            <input class="order_id" name="myplugin_attachment_id_order[]" type="hidden" value="<?=$value->order_num;?>"></div>
        <?php
        }
        ?>
    </div>

<?php submit_button('Save Changes','','save_file'); ?>
</form>