<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



?>


        <div class="section-field">
            <?php

            wp_nonce_field( 'nonce_user_profile_edit' );
            printf( "<input type='hidden' value='y' name='edit_hidden' />" );
            printf( "<button class='button' type='submit'>%s</button>", __('Save changes', 'user-profile') );

            ?>

        </div>





	</form>

</div>