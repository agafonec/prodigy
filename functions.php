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
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css');
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
function account_head() {
    global $wpdb;
    $user = wp_get_current_user();
    $bookly_staff = $wpdb->get_results("SELECT FROM {$wpdb->prefix}bookly_staff WHERE wp_user_id == {$user->id}");
    $actions = '';
    $actions .= "<div class='button-wrap'><a href='" .  home_url('/lessons/') . "' class='btn btn-green btn-left-angle'>" . __('Your Lessons', 'prodigy') . "</a></div>";
    $actions .= "<div class='button-wrap'><a href='" .  home_url('/account/') . "' class='btn btn-blue btn-right-angle'>" . __('Your Account', 'prodigy') . "</a></div>";

    if ( $bookly_staff ) {
        $avatar_src = wp_get_attachment_url($bookly_staff->attachment_id);
        $actions .= "<div class='button-wrap'><a href='" .  home_url('/hours/') . "' class='btn btn-purple btn-right-angle'>" . __('Your Hours', 'prodigy') . "</a></div>";

    } else {
        $avatar_src = get_avatar_url($user->get_id());
    }

    echo '<div class="account-head">';
    echo '<div class="account-head__left">';
    echo "<h1>Hello, {$user->first_name} {$user->last_name}</h1>";
    echo "<div class='account-head__buttons'>{$actions}</div>";
    echo "</div>";
    echo '<div class="account-head__right">';
    echo "<div class='account-head__avatar'>";
    echo "<img src='{$avatar_src}'/>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
add_shortcode( 'account_head', 'account_head');

function prodigy_bookly_lessons( $past_dates = false ) {
    global $wpdb;
    $user = wp_get_current_user();
    $bookly_staff = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_staff WHERE wp_user_id = {$user->id}");
    $today =  date('d-m-y h:i:s');
    $compare_dates = $past_dates ? ' <= ' : ' >= ';
    if ( $bookly_staff ) {
        $staff_appointments = $wpdb->get_results("SELECT ba.id as id , bc.full_name AS student_name, 
                                                            bca.custom_fields AS custom_fields,
                                                            ba.start_date AS app_date,
                                                            bsf.full_name AS tutor_name,
                                                            bsv.title AS course_title
                                    FROM {$wpdb->prefix}bookly_customer_appointments AS bca
                                    LEFT JOIN {$wpdb->prefix}bookly_customers AS bc
                                        ON bc.id = bca.customer_id
                                    LEFT JOIN {$wpdb->prefix}bookly_appointments AS ba
                                        ON ba.id = bca.appointment_id
                                    LEFT JOIN {$wpdb->prefix}bookly_staff AS bsf
                                        ON bsf.id = ba.staff_id
                                    LEFT JOIN {$wpdb->prefix}bookly_services AS bsv
                                        ON bsv.id = ba.service_id
                                    WHERE bsf.wp_user_id = {$user->id} AND ba.start_date {$compare_dates} CURDATE()
                                    ORDER BY ba.start_date DESC");
        foreach ($staff_appointments as $appointment) {
            $date = new DateTime($appointment->app_date);
            $custom_fields;
            $custom_field = json_decode( $appointment->custom_fields);

            if ( $custom_field ) {
                foreach ( $custom_field as $field ) {
                    $custom_fields[$field->id] = $field->value;
                }
            }
            ?>
            <div class="appointment-box" data-id="<?= $appointment->id ?>">
                <div class="appointment-box__inner">
                    <div class="appointment-box__head">
                        <div class="appointment-box__title"><?= $appointment->course_title ?> WITH <?= $appointment->student_name ?></div>
                        <div class="appointment-box__date"><?= $date->format('j F, Y | g:i A')?></div>
                    </div>
                    <div class="appointment-box__body">
                        <div class="col column-1">
                            <a href="<?= $custom_fields[15564] ?>" class="btn btn-right-angle btn-dark-green"><?= __('Student Intake','prodigy')?></a>
                            <a href="<?= $custom_fields[79436] ?>" class="btn btn-right-angle btn-purple"><?= __('Student Class Notes','prodigy')?></a>
                        </div>
                        <div class="col column-2">
                            <a href="" class="btn btn-blue btn-diagonal-angle-left btn-full-height">
                                <svg width="227" height="102" viewBox="0 0 227 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0H112.729C129.298 0 142.729 13.4315 142.729 30V101.732H30C13.4315 101.732 0 88.301 0 71.7324V0Z" fill="white"/>
                                    <path d="M161.709 31.1277L227 6.07422V101.733L161.709 78.5776V31.1277Z" fill="white"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col column-3">
                            <a href="<?= $custom_fields[81973] ?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Workspace','prodigy') ?></a>
                            <a href="<?= $custom_fields[7796]?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Notes','prodigy') ?></a>
                        </div>
                        <div class="col column-4">
                            <div class="button-group">
                                <a href="" class="btn btn-yellow btn-left-angle"><?= __('Reschedule Lesson','prodigy') ?></a>
                                <a href="" class="btn btn-red btn-right-angle"><?= __('Cancel Lesson', 'prodigy') ?></a>
                            </div>
                            <a href="" class="btn btn-right-angle btn-light-red"><?= __('Post Lesson Survey', 'prodigy') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        $customer_appointments = $wpdb->get_results("SELECT bc.full_name AS student_name, 
                                                            bca.custom_fields AS custom_fields,
                                                            ba.start_date AS app_date,
                                                            bsf.full_name AS tutor_name,
                                                            bsv.title AS course_title
                                    FROM {$wpdb->prefix}bookly_customer_appointments AS bca
                                    LEFT JOIN {$wpdb->prefix}bookly_customers AS bc
                                        ON bc.id = bca.customer_id
                                    LEFT JOIN {$wpdb->prefix}bookly_appointments AS ba
                                        ON ba.id = bca.appointment_id
                                    LEFT JOIN {$wpdb->prefix}bookly_staff AS bsf
                                        ON bsf.id = ba.staff_id
                                    LEFT JOIN {$wpdb->prefix}bookly_services AS bsv
                                        ON bsv.id = ba.service_id
                                    WHERE bc.wp_user_id = {$user->id} AND ba.start_date {$compare_dates} CURDATE()
                                    ORDER BY ba.start_date DESC");
        foreach ($customer_appointments as $appointment) {
            $date = new DateTime($appointment->app_date);
            $custom_fields;
            $custom_field = json_decode( $appointment->custom_fields);

            if ( $custom_field ) {
                foreach ( $custom_field as $field ) {
                    $custom_fields[$field->id] = $field->value;
                }
            }
        ?>
        <div class="appointment-box">
            <div class="appointment-box__inner">
                <div class="appointment-box__head">
                    <div class="appointment-box__title"><?= $appointment->course_title ?> WITH <?= $appointment->tutor_name ?></div>
                    <div class="appointment-box__date"><?= $date->format('j F, Y | g:i A')?></div>
                </div>
                <div class="appointment-box__body">
                    <div class="col column-1">
                        <a href="<?= $custom_fields[15564] ?>" class="btn btn-right-angle btn-dark-green"><?= __('Pre-Lesson Survey','prodigy')?></a>
                        <a href="<?= $custom_fields[79436] ?>" class="btn btn-right-angle btn-purple"><?= __('Post-Lesson Survey','prodigy')?></a>
                    </div>
                    <div class="col column-2">
                        <a href="" class="btn btn-blue btn-diagonal-angle-left btn-full-height">
                            <svg width="227" height="102" viewBox="0 0 227 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0H112.729C129.298 0 142.729 13.4315 142.729 30V101.732H30C13.4315 101.732 0 88.301 0 71.7324V0Z" fill="white"/>
                                <path d="M161.709 31.1277L227 6.07422V101.733L161.709 78.5776V31.1277Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col column-3">
                        <a href="<?= $custom_fields[81973] ?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Workspace','prodigy') ?></a>
                        <a href="<?= $custom_fields[7796]?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Notes','prodigy') ?></a>
                    </div>
                    <div class="col column-4">
                        <div class="button-group">
                            <a href="" class="btn btn-yellow btn-left-angle"><?= __('Reschedule Lesson','prodigy') ?></a>
                            <a href="" class="btn btn-red btn-right-angle"><?= __('Cancel Lesson', 'prodigy') ?></a>
                        </div>
                        <a href="" class="btn btn-right-angle btn-light-red"><?= __('DO NOT JOIN LESSON', 'prodigy') ?></a>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
    }
}
add_shortcode( 'prodigy_bookly_lessons', 'prodigy_bookly_lessons');

function past_lessons() {
    prodigy_bookly_lessons(true);
    wp_die();
}

add_action('wp_ajax_get_past_lessons', 'past_lessons');
add_action('wp_ajax_nopriv_get_past_lessons', 'past_lessons');

function future_lessons() {
    prodigy_bookly_lessons();
    wp_die();
}

add_action('wp_ajax_get_future_lessons', 'future_lessons');
add_action('wp_ajax_nopriv_get_future_lessons', 'future_lessons');
// development fields
//[
//    {"id":15564,"value":"https:\/\/www.google.com\/pre_lesson"},
//    {"id":79436,"value":"https:\/\/www.google.com\/post_lesson"},
//    {"id":81973,"value":"https:\/\/www.google.com\/lesson_workspace"},
//    {"id":7796,"value":"Lesson notes which will be left by tutor."}
//]

// production fields
//[
//    {"id":57794,"value":"https:\/\/www.google.com\/pre_lesson"},
//    {"id":72780,"value":"https:\/\/www.google.com\/post_lesson"},
//    {"id":17376,"value":"https:\/\/www.google.com\/lesson_workspace"},
//    {"id":17943,"value":"Lesson notes which will be left by tutor."}
//]
