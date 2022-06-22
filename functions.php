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

    wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'));
    wp_localize_script('custom', 'frontendajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
include(get_stylesheet_directory() . "/inc/admin/wc-shortcode.php");
include(get_stylesheet_directory() . "/inc/frontend/ajax-function.php");
include(get_stylesheet_directory() . "/inc/frontend/submit-form.php");
include(get_stylesheet_directory() . "/inc/admin/admin-function.php");
include(get_stylesheet_directory() . "/inc/frontend/get-function.php");

add_action('wp_ajax_loggedIn', 'wc_loggedIn');
add_action('wp_ajax_nopriv_loggedIn', 'wc_loggedIn');

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

}

add_action('wp_ajax_admin_approved_subject', 'wc_admin_approved_subject');
add_action('wp_ajax_nopriv_admin_approved_subject', 'wc_admin_approved_subject');


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

function prodigy_bookly_lessons( $past_dates = false , $hide_nav = false) {
    global $wpdb;
    $user = wp_get_current_user();
    $bookly_staff = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_staff WHERE wp_user_id = {$user->id}");
    $today =  date('d-m-y h:i:s');
    $compare_dates = $past_dates ? ' <= ' : ' >= ';
    $pre_lesson_survey_link = get_field('pre_lesson_survey_link', 'options');
    $post_lesson_survey_link = get_field('post_lesson_survey_link', 'options');
    if ( !$hide_nav ) :
    ?>
    <div class="appointments-nav">
        <a href="#" class="js-upcoming-lessons">
            <span><?= __('Upcoming Lessons','prodigy')?></span>
            <svg width="105" height="38" viewBox="0 0 105 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M103.768 20.7678C104.744 19.7915 104.744 18.2085 103.768 17.2322L87.8579 1.32233C86.8816 0.34602 85.2986 0.34602 84.3223 1.32233C83.346 2.29864 83.346 3.88155 84.3223 4.85786L98.4645 19L84.3223 33.1421C83.346 34.1184 83.346 35.7014 84.3223 36.6777C85.2986 37.654 86.8816 37.654 87.8579 36.6777L103.768 20.7678ZM0 21.5H102V16.5H0V21.5Z" fill="black"/>
            </svg>
        </a>
        <a href="#" class="js-previous-lessons"><span><?= __('See Previous','prodigy')?></span></a>
    </div>
    <?php
    endif;
    echo '<div class="appointments-wrap">';
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
                                    WHERE bsf.wp_user_id = {$user->id} AND ba.start_date {$compare_dates} CURDATE() AND ( bca.status = 'pending' OR bca.status = 'approved') 
                                    ORDER BY ba.start_date DESC");
        if ( $staff_appointments ) {
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
                                <a href="<?= $pre_lesson_survey_link ?>" class="btn btn-right-angle btn-dark-green"><?= __('Student Intake','prodigy')?></a>
                                <a href="<?= $custom_fields[79436] ?>" class="btn btn-right-angle btn-purple"><?= __('Student Class Notes','prodigy')?></a>
                            </div>
                            <div class="col column-2">
                                <a href="<?= $custom_field[72780]?>" class="btn btn-blue btn-diagonal-angle-left btn-full-height">
                                    <svg width="227" height="102" viewBox="0 0 227 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0H112.729C129.298 0 142.729 13.4315 142.729 30V101.732H30C13.4315 101.732 0 88.301 0 71.7324V0Z" fill="white"/>
                                        <path d="M161.709 31.1277L227 6.07422V101.733L161.709 78.5776V31.1277Z" fill="white"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="col column-3">
                                <a href="<?= $custom_fields[17376] ?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Workspace','prodigy') ?></a>
                                <a href="<?= $custom_fields[17943]?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Notes','prodigy') ?></a>
                            </div>
                            <div class="col column-4">
                                <div class="button-group">
                                    <a href="#" class="btn btn-yellow btn-left-angle"><?= __('Reschedule Lesson','prodigy') ?></a>
                                    <a href="#" class="btn btn-red btn-right-angle js-cancel-lesson"><?= __('Cancel Lesson', 'prodigy') ?></a>
                                </div>
                                <a href="<?= $post_lesson_survey_link ?>" class="btn btn-right-angle btn-light-red"><?= __('Post Lesson Survey', 'prodigy') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            echo '<div class="empty-alert">' . __('No Appointments Yet', 'prodigy') . '</div>';
        }
    } else {
        $customer_appointments = $wpdb->get_results("SELECT ba.id as id , bc.full_name AS student_name, 
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
                                    WHERE bc.wp_user_id = {$user->id} AND ba.start_date {$compare_dates} CURDATE() AND ( bca.status = 'pending' OR bca.status = 'approved') 
                                    ORDER BY ba.start_date DESC");
        if ( $customer_appointments ) {
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
            <div class="appointment-box" data-id="<?= $appointment->id ?>">
                <div class="appointment-box__inner">
                    <div class="appointment-box__head">
                        <div class="appointment-box__title"><?= $appointment->course_title ?> WITH <?= $appointment->tutor_name ?></div>
                        <div class="appointment-box__date"><?= $date->format('j F, Y | g:i A')?></div>
                    </div>
                    <div class="appointment-box__body">
                        <div class="col column-1">
                            <a href="<?= $pre_lesson_survey_link ?>" class="btn btn-right-angle btn-dark-green"><?= __('Pre-Lesson Survey','prodigy')?></a>
                            <a href="<?= $post_lesson_survey_link ?>" class="btn btn-right-angle btn-purple"><?= __('Post-Lesson Survey','prodigy')?></a>
                        </div>
                        <div class="col column-2">
                            <a href="<?= $custom_field[72780]?>" class="btn btn-blue btn-diagonal-angle-left btn-full-height">
                                <svg width="227" height="102" viewBox="0 0 227 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0H112.729C129.298 0 142.729 13.4315 142.729 30V101.732H30C13.4315 101.732 0 88.301 0 71.7324V0Z" fill="white"/>
                                    <path d="M161.709 31.1277L227 6.07422V101.733L161.709 78.5776V31.1277Z" fill="white"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col column-3">
                            <a href="<?= $custom_fields[17376] ?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Workspace','prodigy') ?></a>
                            <a href="<?= $custom_fields[17943]?>" class="btn btn-blue btn-left-angle"><?= __('Lesson Notes','prodigy') ?></a>
                        </div>
                        <div class="col column-4">
                            <div class="button-group">
                                <a href="" class="btn btn-yellow btn-left-angle"><?= __('Reschedule Lesson','prodigy') ?></a>
                                <a href="" class="btn btn-red btn-right-angle js-cancel-lesson"><?= __('Cancel Lesson', 'prodigy') ?></a>
                            </div>
                            <a href="" class="btn btn-right-angle btn-light-red"><?= __('DO NOT JOIN LESSON', 'prodigy') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
        } else {
            echo '<div class="empty-alert">' . __('No Appointments Yet', 'prodigy') . '</div>';
        }
    }
    echo '</div>';
}
add_shortcode( 'prodigy_bookly_lessons', 'prodigy_bookly_lessons');

function prodigy_bookly_pods( $hide_nav = false ) {
    global $wpdb;
    $user = wp_get_current_user();
    $student_pods = $wpdb->get_results("SELECT DISTINCT ID FROM {$wpdb->prefix}posts AS p
                                    LEFT JOIN {$wpdb->prefix}postmeta AS pm
                                        ON pm.post_id = p.ID
                                    LEFT JOIN {$wpdb->prefix}postmeta AS pm2
                                        ON pm2.post_id = pm.post_id
                                    WHERE p.post_type = 'pods' AND pm.meta_key LIKE '%pod_user_email%' AND pm2.meta_value = '{$user->user_email}' 
                                    ORDER BY p.post_modified DESC 
                                    LIMIT 3");
//    var_dump($student_pods);
//    $today =  date('d-m-y h:i:s');
//    $compare_dates = $past_dates ? ' <= ' : ' >= ';

    if ( !$hide_nav ) :
        ?>
        <div class="appointments-nav">
           <h2>
               <span><?= __('My Pods','prodigy')?></span>
               <svg width="105" height="38" viewBox="0 0 105 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                   <path d="M103.768 20.7678C104.744 19.7915 104.744 18.2085 103.768 17.2322L87.8579 1.32233C86.8816 0.34602 85.2986 0.34602 84.3223 1.32233C83.346 2.29864 83.346 3.88155 84.3223 4.85786L98.4645 19L84.3223 33.1421C83.346 34.1184 83.346 35.7014 84.3223 36.6777C85.2986 37.654 86.8816 37.654 87.8579 36.6777L103.768 20.7678ZM0 21.5H102V16.5H0V21.5Z" fill="black"/>
               </svg>
           </h2>
            <a href="#" class="js-previous-pods"><span><?= __('See Previous','prodigy')?></span></a>
        </div>
<?php endif; ?>
        <div class="student-pods">
            <div class="student-pods__inner">
                <?php
                    foreach ( $student_pods as $pod ) :
                        $title = get_the_title($pod->ID);
                        $tutor_id = get_field('pod_expert_id', $pod->ID);
                        $expert_id = $wpdb->get_row("SELECT wp_user_id FROM {$wpdb->prefix}bookly_staff  WHERE id = {$tutor_id}")->wp_user_id;
                        $expert_data = get_userdata( $expert_id );
                ?>
                <div class="pod-box" data-pod-id="<?= $pod->ID ?>">
                    <div class="pod-box__inner">
                        <a href="#" class="pod-box__image js-open-students">

                        </a>
                        <div class="pod-box__details">
                            <div class="title"><?= $title ?></div>
<!--                            <div class="title">{Course Name}</div>-->
                            <div class="title">Expert: <?= $expert_data->first_name?> <?= $expert_data->last_name ?></div>
                        </div>
                        <div class="pod-box__actions">

                            <div class="pod-box__actions-single">
                                <a href="#" class="js-book-with-pod btn btn-dark-green btn-left-angle">
                                    <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/book_pod.png" alt="">
                                </a>
                            </div>
                            <div class="pod-box__actions-single">
                                <a href="#" class="btn btn-blue btn-right-angle">
                                    <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/Chat.png" alt="">
                                </a>
                            </div>
                            <div class="pod-box__actions-single">
                                <a href="#" class="btn btn-yellow btn-left-top-angle">
                                    <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/pen.png" alt="">
                                </a>
                            </div>
                            <div class="pod-box__actions-single">
                                <a href="#" class="btn btn-grey btn-right-top-angle">
                                    <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/tool.png" alt="">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>
            </div>
        </div>
    <?php
    if ( !$hide_nav ) :
    ?>
        <div id="pod_students" class="popup">
            <div class="popup__inner">
                <div class="popup__content">

                </div>
                <a href="" class="js-close-popup popup__close">+</a>
            </div>
        </div>
    <?php endif;
}
add_shortcode( 'prodigy_bookly_pods', 'prodigy_bookly_pods');

function get_pod_students() {
    $pod_id = $_POST['pod_id'];
    $students = get_field('pod_users', $pod_id);

    echo '<div class="pod-popup__title">Pod Students</div>';

    echo '<div class="pod-user__wrap">';
    foreach( $students as $student ) {
        $student_user = get_user_by( 'email', $student['pod_user_email'] );
        echo '<div class="pod-user">';
        if ($student_user) {
            echo '<div class="pod-user__line"><b>Full Name:</b> <span>' . $student_user->first_name . ' ' . $student_user->last_name  .'</span></div>';
        }
        echo '<div class="pod-user__line"><b>Email:</b> <span>' . $student['pod_user_email']  .'</span></div>';
        echo '<div class="pod-user__line"><b>Phone Number:</b> <span>' . $student['pod_user_phone']  .'</span></div>';
        echo '</div>';
    }
    echo '</div>';

    wp_die();
}

add_action('wp_ajax_display_pod_students', 'get_pod_students');
add_action('wp_ajax_nopriv_display_pod_students', 'get_pod_students');

function book_again_pod() {
    global $wpdb;
    $pod_id = $_POST['pod_id'];
    $tutor_id = get_field('pod_expert_id', $pod_id);

    $lesson_id = get_field('pod_lesson_id', $pod_id);
    $category_id = get_field('pod_category_id', $pod_id);

    echo home_url("/booking-2/?stfid={$tutor_id}&sereid={$lesson_id}&catid={$category_id}");
    wp_die();
}

add_action('wp_ajax_pod_book_again', 'book_again_pod');
add_action('wp_ajax_nopriv_pod_book_again', 'book_again_pod');

function past_lessons() {
    prodigy_bookly_lessons(true, true);
    wp_die();
}

add_action('wp_ajax_get_past_lessons', 'past_lessons');
add_action('wp_ajax_nopriv_get_past_lessons', 'past_lessons');

function future_lessons() {
    prodigy_bookly_lessons(false, true);
    wp_die();
}

add_action('wp_ajax_get_future_lessons', 'future_lessons');
add_action('wp_ajax_nopriv_get_future_lessons', 'future_lessons');

function cancel_appointment() {
    global $wpdb;
    $app_id = intval( $_POST['app_id'] );
    $table_name = $wpdb->prefix.'bookly_customer_appointments';
    $data_update = array('status' => 'cancelled');
    $data_where = array('appointment_id' => $app_id);
    $wpdb->update($table_name , $data_update, $data_where);

    wp_die();
}

add_action('wp_ajax_cancel_lesson', 'cancel_appointment');
add_action('wp_ajax_nopriv_cancel_lesson', 'cancel_appointment');


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

// set the participants from the cookie.
function plugin_republic_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
    if(isset($_COOKIE['pod_id'])) {
        global $wpdb;
        $pod_id = $_COOKIE['pod_id'];
        $students = get_field('pod_users', $pod_id);
        $lesson_id = get_field('pod_lesson_id', $pod_id);
        $service_price = $wpdb->get_row("SELECT price FROM {$wpdb->prefix}bookly_services  WHERE id = {$lesson_id}");
        $split_price = intval($service_price->price) / count( $students );
        $participants = array_map(function($s) {
            return $s['pod_user_email'];
        }, $students);
        $invitee_mobiles = array_map(function($s) {
            return $s['pod_user_phone'];
        }, $students);
//        echo 'STUDENTS COUNT = ' . count( $students );
        $cart_item_data["split_order_payment"] = array(
            "_price" => $split_price,
            "total_share" => intval($service_price),
            "total_participants" => count( $students ),
            "participants" => $participants,
            "invitee_mobiles" => $invitee_mobiles,
            "split_participant_msg"=>  ""
        );
    }

    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'plugin_republic_add_cart_item_data', 10, 3 );

add_action( 'woocommerce_new_order', 'wp_kama_woocommerce_new_order_action', 1000, 2 );
function wp_kama_woocommerce_new_order_action( $order_id, $order ){
//    global $wpdb;
//    $split_order_data = $order->get_meta('_split_order_data');
//    $loop_index = 0;
//
//    foreach( $split_order_data['participants'] as $participant ) {
//        $meta_input['pod_users_'. $loop_index .'_pod_user_email'] = $participant;
//        $meta_input['_pod_users_'. $loop_index .'_pod_user_email'] = 'field_62b1fb4fc0dc1';
//
//        $meta_input['pod_users_'. $loop_index .'_pod_user_phone'] = $split_order_data['invitee_mobiles'][$loop_index];
//        $meta_input['_pod_users_'. $loop_index .'_pod_user_phone'] = 'field_62b1fb56c0dc2';
//
//        $loop_index++;
//    }
//    $meta_input['pod_users'] = $loop_index;
//    $meta_input['_pod_users'] = 'field_62b1fb41c0dc0';
//
//    foreach ( $order->items as $item ) {
//        $service_id = $item['bookly']['items'][0]['service_id'];
//        $staff_id = $item['bookly']['items'][0]['staff_ids'][0];
//        $service = $wpdb->get_row("SELECT category_id,  title FROM {$wpdb->prefix}bookly_services WHERE id = {$service_id}");
//        $meta_item_input = array(
//            'pod_expert_id' => $staff_id,
//            '_pod_expert_id' => 'field_62b1fb17c0dbf',
//            'pod_lesson_id' => $service_id,
//            '_pod_lesson_id' => 'field_62b3087dbc151',
//            'pod_category_id'=> $service->category_id,
//            '_pod_category_id'=> 'field_62b30887bc152'
//        );
//
//        $meta_item_input = array_merge($meta_item_input, $meta_input);
//
//        $postarr = array(
//            'post_title' => $service->title,
//            'post_type' => 'pods',
//            'post_status' => 'publish',
//            'meta_input' => $meta_item_input,
//        );
//        wp_insert_post( $postarr );
//    }
}

add_action( 'woocommerce_order_status_completed', 'so_payment_complete' );
function so_payment_complete( $order_id ){
    $order = wc_get_order( $order_id );
    global $wpdb;
    $split_order_data = $order->get_meta('_split_order_data');
    $loop_index = 0;

    foreach( $split_order_data['participants'] as $participant ) {
        $meta_input['pod_users_'. $loop_index .'_pod_user_email'] = $participant;
        $meta_input['_pod_users_'. $loop_index .'_pod_user_email'] = 'field_62b1fb4fc0dc1';

        $meta_input['pod_users_'. $loop_index .'_pod_user_phone'] = $split_order_data['invitee_mobiles'][$loop_index];
        $meta_input['_pod_users_'. $loop_index .'_pod_user_phone'] = 'field_62b1fb56c0dc2';

        $loop_index++;
    }
    $meta_input['pod_users'] = $loop_index;
    $meta_input['_pod_users'] = 'field_62b1fb41c0dc0';

    foreach ( $order->items as $item ) {
        $service_id = $item['bookly']['items'][0]['service_id'];
        $staff_id = $item['bookly']['items'][0]['staff_ids'][0];
        $service = $wpdb->get_row("SELECT category_id,  title FROM {$wpdb->prefix}bookly_services WHERE id = {$service_id}");
        $meta_item_input = array(
            'pod_expert_id' => $staff_id,
            '_pod_expert_id' => 'field_62b1fb17c0dbf',
            'pod_lesson_id' => $service_id,
            '_pod_lesson_id' => 'field_62b3087dbc151',
            'pod_category_id'=> $service->category_id,
            '_pod_category_id'=> 'field_62b30887bc152'
        );

        $meta_item_input = array_merge($meta_item_input, $meta_input);

        $postarr = array(
            'post_title' => $service->title,
            'post_type' => 'pods',
            'post_status' => 'publish',
            'meta_input' => $meta_item_input,
        );
        wp_insert_post( $postarr );
    }
}

//["split_order_payment"]=> array(6)
//{ ["_price"]=> int(100)
//["total_share"]=> int(200)
//["total_participants"]=> int(2)
//["participants"]=> array(2)
//    {
//        [0]=> string(19) "agafonec1@gmail.com"
//        [1]=> string(15) "Diego@gmail.com"
//    }
//["invitee_mobiles"]=> array(2) {
//    [0]=> string(11) "12334567890"
//    [1]=> string(0) ""
//}
//["split_participant_msg"]=> string(0) "" }

//a:37:{s:19:"first_rendered_step";i:1;s:9:"time_zone";s:11:"Europe/Kiev";s:16:"time_zone_offset";s:4:"-180";s:9:"date_from";s:10:"2022-05-13";s:4:"days";a:5:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"4";i:3;s:1:"5";i:4;s:1:"6";}s:9:"time_from";s:5:"02:30";s:7:"time_to";s:5:"18:00";s:5:"slots";a:1:{i:0;a:4:{i:0;i:60;i:1;i:22;i:2;s:19:"2022-05-19 14:30:00";i:3;i:0;}}s:11:"facebook_id";N;s:9:"full_name";s:15:"Danylo Ahafonov";s:10:"first_name";s:6:"Danylo";s:9:"last_name";s:8:"Ahafonov";s:5:"email";s:19:"agafonec1@gmail.com";s:13:"email_confirm";s:19:"agafonec1@gmail.com";s:5:"phone";s:13:"+380965271958";s:8:"birthday";a:3:{s:4:"year";s:0:"";s:5:"month";i:0;s:3:"day";i:0;}s:18:"additional_address";s:4:"5522";s:7:"country";s:18:"United States (US)";s:5:"state";s:8:"Virginia";s:8:"postcode";s:5:"22201";s:4:"city";s:8:"Arlngton";s:6:"street";s:13:"Columbia pike";s:13:"street_number";s:0:"";s:11:"address_iso";a:0:{}s:5:"notes";s:44:"Lesson notes which will be left by students.";s:11:"info_fields";a:0:{}s:11:"coupon_code";N;s:4:"tips";N;s:12:"deposit_full";i:0;s:14:"edit_cart_keys";a:1:{i:0;i:0;}s:8:"repeated";i:0;s:11:"repeat_data";a:0:{}s:7:"version";s:3:"1.1";s:5:"items";a:1:{i:0;a:16:{s:11:"location_id";i:0;s:10:"service_id";i:60;s:9:"staff_ids";a:1:{i:0;i:22;}s:17:"number_of_persons";i:1;s:9:"date_from";s:10:"2022-05-13";s:4:"days";a:5:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"4";i:3;s:1:"5";i:4;s:1:"6";}s:9:"time_from";s:5:"02:30";s:7:"time_to";s:5:"18:00";s:5:"units";i:1;s:6:"extras";a:0:{}s:24:"consider_extras_duration";b:1;s:5:"slots";a:1:{i:0;a:4:{i:0;i:60;i:1;i:22;i:2;s:19:"2022-05-19 14:30:00";i:3;i:0;}}s:13:"custom_fields";a:4:{i:0;a:2:{s:2:"id";i:15564;s:5:"value";s:33:"https://www.google.com/pre_lesson";}i:1;a:2:{s:2:"id";i:79436;s:5:"value";s:34:"https://www.google.com/post_lesson";}i:2;a:2:{s:2:"id";i:81973;s:5:"value";s:39:"https://www.google.com/lesson_workspace";}i:3;a:2:{s:2:"id";i:7796;s:5:"value";s:41:"Lesson notes which will be left by tutor.";}}s:16:"series_unique_id";i:0;s:15:"first_in_series";b:1;s:14:"appointment_id";N;}}s:11:"wc_checkout";a:10:{s:18:"billing_first_name";s:6:"Danylo";s:17:"billing_last_name";s:8:"Ahafonov";s:13:"billing_email";s:19:"agafonec1@gmail.com";s:13:"billing_phone";s:13:"+380965271958";s:15:"billing_country";N;s:13:"billing_state";N;s:12:"billing_city";s:8:"Arlngton";s:17:"billing_address_1";s:14:"Columbia pike ";s:17:"billing_address_2";s:4:"5522";s:16:"billing_postcode";s:5:"22201";}s:9:"processed";b:1;s:6:"ca_ids";a:1:{i:0;i:26;}}