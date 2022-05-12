<?php
/*
 * This is the child theme for Hello Elementor theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles');
function hello_elementor_child_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );

    wp_enqueue_script('jquery-toaster', "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js", ['jquery'], false, true);
    wp_enqueue_style('jquery-toaster-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css', false, true);

    wp_enqueue_script('bootstrap.bundle.min.js', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js", ['jquery'], false, true);
    wp_enqueue_script('slick.min.js', "//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", ['jquery'], false, true);

    wp_enqueue_script('sage/datetimepicker-mom', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js', ['jquery'], false, true);
    wp_enqueue_script('sage/datetimepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js', ['jquery'], false, true);

    wp_enqueue_script('ajax_custom_script', get_stylesheet_directory_uri() . '/assets/js/hash-new.js', array('jquery'));
    wp_localize_script('ajax_custom_script', 'frontendajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
include(get_stylesheet_directory() . "/inc/admin/wc-shortcode.php");
include(get_stylesheet_directory() . "/inc/frontend/ajax-function.php");
include(get_stylesheet_directory() . "/inc/frontend/submit-form.php");
include(get_stylesheet_directory() . "/inc/admin/admin-function.php");
include(get_stylesheet_directory() . "/inc/frontend/get-function.php");

add_action('wp_ajax_loggedIn', 'wc_loggedIn');
add_action('wp_ajax_nopriv_loggedIn', 'wc_loggedIn');

add_action('wp_ajax_admin_approved_subject', 'wc_admin_approved_subject');
add_action('wp_ajax_nopriv_admin_approved_subject', 'wc_admin_approved_subject');





// $to = "hash.softwares.team@gmail.com";
// $headers = "MIME-Version: 1.0";
// $headers = array('Content-Type: text/html; charset=UTF-8', 'From:  PRODIGYPOD <alejandro@ouwebs.com>');
// $mail = wp_mail($to, "Test", "testing", $headers);
// if ($mail) {
//     echo "true";
//     die();
// } else {
//     echo "false";
//     die();
// }
//include(get_stylesheet_directory() . "/inc/front/wc_shortcode.php");
/*
 * Your code goes below
 */