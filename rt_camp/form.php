<?php 
$users = get_users();
$user_names = wp_list_pluck( $users, 'user_login' );
$my_meta = get_post_meta( $post->ID, 'hcf_author', true ); 
$destination_array = explode(',', $my_meta);
?>
<style>
    .hcf_box{
        display: grid;
        grid-template-columns: max-content 1fr;
        grid-row-gap: 10px;
        grid-column-gap: 20px;
    }
    .hcf_field{
        display: contents;
    }
</style>
<div class="hcf_box">
    <p class="meta-options hcf_field">
        
        <?php 
            foreach ($user_names as $key => $value) {
            ?>
                <input type="checkbox" name="hcf_author[]" <?php if($value == $destination_array[$key]){ echo "checked"; } ?> value="<?=$value?>">
                <label for="hcf_author"><?php echo $value; ?></label>
            <?php
            }
        ?>
    </p>
</div>