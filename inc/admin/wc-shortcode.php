<?php
add_shortcode('wc_login', 'wpb_login_menu_shortcode');
function wpb_login_menu_shortcode() { 
    ob_start(); ?>

<ul class="show-mobile nav">
    <?php if ( is_user_logged_in() ){ ?>
    <li><a href="<?php echo home_url('/my-account') ?>">My Account</a></li>
    <li><a class="log_out" href="<?php echo wp_logout_url(home_url('/')) ?>">Logout</a></li>
    <?php }else { ?>
    <li><a data-toggle="modal" data-target="#login_modal" href="#">Log in</a></li>
    <li><a data-toggle="modal" data-target="#login_modal" class="sign_up" href="/registration">Sign up</a></li>
    <?php  } ?>
</ul>

<?php   
return ob_get_clean();
    

}?>