<?php 
$users = get_users();
$user_names = wp_list_pluck( $users, 'user_login' );
$role = wp_list_pluck( $users, 'roles' );

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
                if($role[$key][0] == 'contributor')
                {
            ?>
                <input type="checkbox" name="hcf_author[]" <?php if(in_array($value, $destination_array)){ echo "checked"; } ?>  value="<?=$value?>">
                <label for="hcf_author"><?php echo $value; ?></label>
            <?php
                }
            }
        ?>
    </p>
</div>