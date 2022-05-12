<?php
remove_role('subscriber');
remove_role('editor');
remove_role('contributor');
remove_role('author');
add_action('admin_menu', 'my_admin_menu');
function my_admin_menu()
{
    add_menu_page(
        __('Approve Subject', 'my-textdomain'),
        __('Approve Subject', 'my-textdomain'),
        'manage_options',
        'approve-subject',
        'show_all_pending_subjects',
        'dashicons-schedule',
        3
    );
}
function show_all_pending_subjects()
{
    global $wpdb;
    $current_page = admin_url(sprintf('admin.php?%s', http_build_query($_GET)));
    $tablename = $wpdb->prefix . 'tutor_subjects';
    if (!isset($_GET['action']) && $_GET['action'] != "view") {
        $get_subjects = $wpdb->get_results("SELECT tutor_id  FROM $tablename group by tutor_id", ARRAY_A);
        if (!empty($get_subjects)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Approved </th>
                        <th scope="col">Pending</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr = 1;
                    foreach ($get_subjects as $subjects) {
                        $user = get_user_by('id', $subjects['tutor_id']);
                        $totals_Approved = $wpdb->get_results("SELECT count(subject_id) as approved  FROM $tablename where tutor_id = '" . $subjects['tutor_id'] . "' AND status = 1  group by tutor_id");
                        $totals_pending = $wpdb->get_results("SELECT count(subject_id) as pending  FROM $tablename where tutor_id = '" . $subjects['tutor_id'] . "' AND status = 0  group by tutor_id");
                        // echo $user->user_email;
                        //echo"<pre>";print_R( $totals);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr; ?></th>
                            <td><?php echo  $user->display_name; ?></td>
                            <td><?php echo  $user->user_email; ?></td>
                            <td><?php echo (!empty($totals_Approved)) ? $totals_Approved[0]->approved : '--'; ?></td>
                            <td><?php echo (!empty($totals_pending)) ? $totals_pending[0]->pending : '--'; ?></td>
                            <td><span class="edit"><a href="<?php echo $current_page ?>&tutor_id=<?php echo $subjects['tutor_id'] ?>&action=view" aria-label="view">View</a> </span></td>
                        </tr>
                    <?php $sr++;
                    } ?>
                </tbody>
            </table>
        <?php }
    } else {
        $tutor_id = (isset($_GET['tutor_id']) && $_GET['tutor_id'] != "") ? $_GET['tutor_id'] : '';
        $get_all_courses = $wpdb->get_results("SELECT *  FROM $tablename where tutor_id = '" . $tutor_id . "' ");
        // echo"<pre>";print_R($get_all_courses);die();
        ?>
        <div class="cstm_err">

        </div>
        <?php
        if (!empty($get_all_courses)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Levels</th>
                        <th scope="col">Courses</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sk = 1;
                    // echo"<pre>";print_R($get_all_courses);die();
                    foreach ($get_all_courses as $courses) {
                        $course_terms = get_term_by('id', $courses->courses_id, 'product_cat');
                        $course_parents = get_term_by('id', $course_terms->parent, 'product_cat');
                        $course_name = $course_terms->name;
                        $levels_name = $course_parents->name;
                        $status = "";
                        if ($courses->status == 1) {
                            $status = "Approved";
                        } else if ($courses->status == 2) {
                            $status = "Rejected";
                        } else {
                            $status = "Pending";
                        }


                    ?>
                        <tr>
                            <td><?php echo   $sk; ?></td>
                            <td><?php echo  $levels_name; ?></td>
                            <td><?php echo  $course_name; ?></td>

                            <td><?php echo  get_the_title($courses->subject_id); ?></td>
                            <td><?php echo  $status; ?></td>

                            <td>
                                <?php if ($courses->status == 0 || $courses->status == 2) { ?>
                                    <a class="btn-active" href="javascript:void(0);" onclick="approvedSubject('<?php echo $courses->id; ?>','approve','<?php echo $tutor_id; ?>');">Approve</a>
                                <?php } else { ?>
                                    <a class="btn-reject" href="javascript:void(0);" onclick="approvedSubject('<?php echo $courses->id; ?>','unapprove','<?php echo $tutor_id; ?>');">Reject</a>
                                <?php    } ?>


                            </td>
                        </tr>
                    <?php $sk++;
                    } ?>
                </tbody>
            </table>
    <?php
        }
    }
}
/**SCript add only for admin  **/
add_action('admin_footer', function () { ?>
    <script type="text/javascript">
        function dismiss_function(msg, status) {
            var dismiss_notice = "";
            var ctsm_class = '';
            if (status == 'true') {
                ctsm_class = 'updated notice';
            } else {
                ctsm_class = 'error notice';
            }
            dismiss_notice += '<div class="' + ctsm_class + ' is-dismissible" >' + msg;
            dismiss_notice += '<button type="button" class="notice-dismiss" >';
            dismiss_notice += '<span class="screen-reader-text">Dismiss this notice.</span>';
            dismiss_notice += '</button> </div>'
            return dismiss_notice;
        }


        function approvedSubject(id, actionP, tutorID) {
            jQuery.ajax({
                url: ajaxurl, // this will point to admin-ajax.php
                type: 'POST',
                data: {
                    action: 'admin_approved_subject',
                    recordID: id,
                    performAction: actionP,
                    tutor: tutorID
                },
                success: function(response) {
                    if (response.status) {

                        jQuery('.cstm_err').html(dismiss_function(response.msg, 'true'));
                        location.reload();
                    } else {
                        jQuery('.cstm_err').html(dismiss_function(response.msg, 'false'));

                    }
                    // console.log(response);
                }
            });
        }
        jQuery(document).ready(function() {
            jQuery(".cstm_err").on('click', '.notice-dismiss', function() {

                jQuery(this).parent().hide();

            });
        });
    </script>
<?php });

/**********************************Approve Subject Request BY ADMIN ******************************/
function wc_admin_approved_subject()
{
    global $wpdb;
    $approvedID = (isset($_POST['recordID']) && $_POST['recordID'] != "") ? $_POST['recordID'] : '';
    $action_perform = (isset($_POST['performAction']) && $_POST['performAction'] != "") ? $_POST['performAction'] : '';
    $tutorID =  (isset($_POST['tutor']) && $_POST['tutor'] != "") ? $_POST['tutor'] : '';

    $tablename = $wpdb->prefix . 'tutor_subjects';
    $status = 0;
    if ($action_perform == "approve") {
        $status = 1;
        /*Assign tutor to subject*/
        // $getAll_Service  = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix. "amelia_services as service LEFT JOIN ".$services_courses." as courses_rel   ON courses_rel.service_id = service.id  WHERE (courses_rel.post_id = '" .$postID  . "' AND service.categoryId = '".$dval."')");	
        $getAll_Service  = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "tutor_subjects as subjects 
        LEFT JOIN " . $wpdb->prefix . "amelia_services_courses_relation as courses_rel ON courses_rel.post_id = subjects.subject_id LEFT JOIN " . $wpdb->prefix . "amelia_categories_taxonomy_relation as cat_rel ON cat_rel.taxonomy_course_id = subjects.courses_id LEFT JOIN " . $wpdb->prefix . "amelia_services as services ON courses_rel.service_id = services.id WHERE (subjects.id = '" . $approvedID  . "' AND cat_rel.category_id = services.categoryId)");

        $get_amelia_users  = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "amelia_users WHERE(
                externalId = " . $tutorID . ")");
        // echo"<pre>";print_R($get_amelia_users);
        // echo"<pre>";print_R($getAll_Service);die();
        /*assign new tutor to suject*/
        $insertData = array(
            'userId' => $get_amelia_users[0]->id,
            'serviceId' => $getAll_Service[0]->service_id,
            'price' => $getAll_Service[0]->price,
            'minCapacity' => $getAll_Service[0]->minCapacity,
            'maxCapacity' => $getAll_Service[0]->maxCapacity,

        );
        $wpdb->insert($wpdb->prefix . "amelia_providers_to_services", $insertData);
    }
    if ($action_perform == "unapprove") {
        $status = 2;
        $getAll_Service  = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "tutor_subjects as subjects LEFT JOIN " . $wpdb->prefix . "amelia_services_courses_relation as courses_rel ON courses_rel.post_id = subjects.subject_id LEFT JOIN " . $wpdb->prefix . "amelia_categories_taxonomy_relation as cat_rel ON cat_rel.taxonomy_course_id = subjects.courses_id LEFT JOIN " . $wpdb->prefix . "amelia_services as services ON courses_rel.service_id = services.id WHERE (subjects.id = '" . $approvedID  . "' AND cat_rel.category_id = services.categoryId)");
        $get_amelia_users  = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "amelia_users WHERE(
                externalId = " . $tutorID . ")");
        $wpdb->delete($wpdb->prefix . "amelia_providers_to_services", array('serviceId' => $getAll_Service[0]->service_id, 'userId' => $get_amelia_users[0]->id));
    }
    $update_status =  $wpdb->query($wpdb->prepare("UPDATE " . $tablename . " SET status=" . $status . " WHERE id = " . $approvedID));

    // echo $wpdb->last_query;
    // echo $update_status;
    if ($update_status) {
        wp_send_json(array('msg' => 'Successfully Approved', 'status' => true));
    } else {
        wp_send_json(array('msg' => 'Something goes wrong please try again', 'status' => false));
    }
}


/***************CREATE NEW TUTOR WITH BOOKLY WHEN ADMIN APPROVE TUTOR SIGNUP REQUEST ************/

add_action('acf/save_post', 'BC_create_new_staff', 10, 1);
function BC_create_new_staff($post_id)
{
    global $pagenow;
    if ($pagenow == 'user-edit.php') {

        $tablename = $wpdb->prefix . 'bookly_staff';

        $prev_values = get_fields($post_id);
        $values = $_POST['acf'];
        $emails = (isset($_POST['email']) && $_POST['email'] != "") ? $_POST['email'] : '';
        if (isset($_POST['acf']['field_6226d6e606d41']) && $_POST['acf']['field_6226d6e606d41'] == "approve") {
            /*Pending*/
            $getUserInfo = "";
            $firstname = (isset($_POST['first_name']) && $_POST['first_name'] != "") ? $_POST['first_name'] : '';
            $last_name = (isset($_POST['last_name']) && $_POST['last_name'] != "") ? $_POST['last_name'] : '';
            $email = (isset($_POST['email']) && $_POST['email'] != "") ? $_POST['email'] : '';
            $user_id = (isset($_POST['user_id']) && $_POST['user_id'] != "") ? $_POST['user_id'] : '';
            //  $role = (isset($_POST['role']) && $_POST['role'] == "wpamelia-provider") ? 'provider' : 'customer';
            $phone =  (isset($_POST['phone']) && $_POST['phone'] != "") ? $_POST['phone'] : '';

            $userData = array(
                'wp_user_id' => $user_id,
                'full_name' => $firstname . ' ' . $last_name,
                'email' => $email,
                'visibility' => 'public',
                'color' => '#2F1FE7',
                'phone' => $phone,
                'attachment_id' => (int)0,

            );

            global $wpdb;
            $lastInserted =  $wpdb->insert('oyc_bookly_staff', $userData);
            $lastInserted =  $wpdb->insert_id;;
            if ($lastInserted) {
                for ($x = 1; $x <= 7; $x++) {
                    $start_Time = "";
                    $End_time = "";
                    if ($x == 1 || $x == 7) {
                        $start_Time =  NULL;
                        $End_time =  NULL;
                    } else {
                        $start_Time =  '08:00:00';
                        $End_time =  '18:00:00';
                    }
                    $schedule_data = array(
                        'staff_id' => $lastInserted,
                        'day_index' => $x,
                        'start_time' => $start_Time,
                        'end_time' => $End_time,

                    );
                    $schedule =  $wpdb->insert('oyc_bookly_staff_schedule_items', $schedule_data);
                }
                $subject = 'Approved Request';
                $data['url'] = home_url();
                $data['username'] = (isset($_POST['display_name']) && $_POST['display_name'] != "") ? $_POST['display_name'] : '';
                $data['email_address'] = $emails;

                ob_start();
                include get_stylesheet_directory() . "/emails/expert/approved.php";
                $message =  ob_get_contents();

                $headers = "MIME-Version: 1.0";
                $headers = array('Content-Type: text/html; charset=UTF-8', 'From:  PRODIGYPOD <alejandro@ouwebs.com>');
                $mail = wp_mail('hash.softwares.team@gmail.com', $subject, $message, $headers);
                ob_end_clean();
            } else {
                return false;
            }
        }
        if (isset($_POST['acf']['field_61c6b31523744']) && $_POST['acf']['field_61c6b31523744'] == "Reject") {

            $subject = 'Reject Request';
            $data['url'] = home_url() . '/tsignup/';
            $data['username'] = (isset($_POST['display_name']) && $_POST['display_name'] != "") ? $_POST['display_name'] : '';
            $data['email_address'] = $emails;
            $message = 'The Signup requested  was rejected. Please consult with your administrator.';
            $message .= "<a href='mailto:" . get_option('admin_email') . "'>" . get_option('admin_email') . "</a>";
            $headers = "MIME-Version: 1.0";
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From:  PRODIGYPOD <alejandro@ouwebs.com>');

            $mail = wp_mail($emails, $subject, $message, $headers);
        }
    }
}
/*  CREATE A NEW SERVICE IN BOOKLY WHEN ADD NEW PRODUCT FROM WOOCOMMERCE */

add_action('publish_product', 'create_Service_by_woocommerce_product', 10, 3);
function create_Service_by_woocommerce_product($post_id, $post)
{
    global $wpdb;
    $services_courses = $wpdb->prefix . 'wc_bk_product_service_relation';
    $bookly_services = $wpdb->prefix . 'bookly_services';
    if (strpos($_SERVER['HTTP_REFERER'], '&action=edit') !== false) {

        /*Edit  Post  updated*/

        $postID = (isset($_POST['post_ID']) && $_POST['post_ID'] != "") ? $_POST['post_ID'] : '';
        $post_title = (isset($_POST['post_title']) && $_POST['post_title'] != "") ? $_POST['post_title'] : '';
        $Price =  (isset($_POST['_regular_price']) && $_POST['_regular_price'] != "") ? $_POST['_regular_price'] : '';
        $content =  (isset($_POST['content']) && $_POST['content'] != "") ? $_POST['content'] : '';

        $select_services_courseID  = $wpdb->get_results("SELECT service_id FROM $services_courses WHERE (product_id = '" . $postID . "')", ARRAY_A);
        $amelia_cat = "";
        $existing_cat =  array();
        $tax_input = $_POST["tax_input"]['product_cat'];
        if (!empty($tax_input)) {
            unset($tax_input[0]);
            $amelia_cat =    set_object_cat($tax_input);
        }
        foreach ($select_services_courseID as $key => $serviceID) {
            $existing_cat_t  = $wpdb->get_results("SELECT category_id FROM $bookly_services  WHERE (id = '" . $serviceID['service_id'] . "')");
            if (!empty($existing_cat_t)) {
                $existing_cat[$key] = $existing_cat_t[0]->category_id;
            }
        }


        /*Delete service by category with service ID*/

        $deleted =  array_diff($existing_cat, $amelia_cat);
        foreach ($deleted as $Dvalue) {
            $wpdb->delete($bookly_services, array('category_id' => $Dvalue, 'wc_product_id' => $postID));
        }

        /*Insert new service if not existing*/

        $Inserted =  array_diff($amelia_cat, $existing_cat);

        foreach ($Inserted as $insertVal) {
            $serialize_data   =   'Date: {appointment_date}';
            $serialize_data  .=  'Time: {appointment_time}';
            $serialize_data  .=  'Service: {service_name}';
            $insert = array(
                'title' => $post_title,
                'color' => '#36D4F6',
                'price' => $Price,
                'info' => $content,
                'visibility'  => 'public',
                'category_id' => $insertVal,
                'type' => 'simple',
                'capacity_min' => 1,
                'capacity_max' => 12,
                //'duration' => '1800'  /*2 hours*/
                'duration' => '1800',  /* 30 mint*/
                'wc_product_id' => $postID,
                'wc_cart_info_name' => 'Appointment',
                'wc_cart_info' => $serialize_data,

            );
            $wpdb->insert($wpdb->prefix . 'bookly_services', $insert);
            $lastInserted_ID = $wpdb->insert_id;
            //echo $wpdb->last_query;

            $service_data =  array(
                'service_id' => $lastInserted_ID,
                'product_id' => $postID
            );
            $wpdb->insert($services_courses, $service_data);
        }

        /*Update query*/
        $updated  = array_intersect($amelia_cat, $existing_cat);
        foreach ($updated as $updatedVal) {

            $dbData = array(
                'title' => $post_title,
                'price' => $Price,
                'info' => $content
            );
            $wpdb->update($services_courses, $dbData, array('category_id' => $updatedVal, 'wc_product_id' => $postID));
            // echo $wpdb->last_query;
        }
        //  die();
    } else {

        /*New Post Created*/

        $postID = (isset($_POST['post_ID']) && $_POST['post_ID'] != "") ? $_POST['post_ID'] : '';
        $post_title = (isset($_POST['post_title']) && $_POST['post_title'] != "") ? $_POST['post_title'] : '';
        $Price =  (isset($_POST['_regular_price']) && $_POST['_regular_price'] != "") ? $_POST['_regular_price'] : '';
        $content =  (isset($_POST['content']) && $_POST['content'] != "") ? $_POST['content'] : '';
        $select_services_courseID  = $wpdb->get_results("SELECT service_id FROM $services_courses WHERE (product_id = '" . $postID . "')", ARRAY_A);
        if (empty($select_services_courseID)) {
            $tax_input = $_POST["tax_input"]['product_cat'];

            if (!empty($tax_input)) {
                unset($tax_input[0]);
                $amelia_cat =    set_object_cat($tax_input);
                if (!empty($amelia_cat)) {
                    foreach ($amelia_cat as $ACat) {
                        $serialize_data   =   'Date: {appointment_date}';
                        $serialize_data  .=  'Time: {appointment_time}';
                        $serialize_data  .=  'Service: {service_name}';
                        $insert = array(
                            'title' => $post_title,
                            'color' => '#36D4F6',
                            'price' => $Price,
                            'visibility'  => 'public',
                            'category_id' => $ACat,
                            'type' => 'simple',
                            'capacity_min' => 1,
                            'capacity_max' => 12,
                            'info' => $content,
                            //'duration' => '1800'  /*2 hours*/
                            'duration' => '1800',  /* 30 mint*/
                            'wc_product_id' => $postID,
                            'wc_cart_info_name' => 'Appointment',
                            'wc_cart_info' => $serialize_data,

                        );
                        $wpdb->insert($wpdb->prefix . 'bookly_services', $insert);

                        $lastInserted_ID = $wpdb->insert_id;

                        $service_data =  array(
                            'service_id' => $lastInserted_ID,
                            'product_id' => $postID
                        );
                        $wpdb->insert($services_courses, $service_data);
                    }
                }
            }
        }
    }
}


function set_object_cat($tax_input)
{
    global $wpdb;
    $category_amelia = $wpdb->prefix . 'wc_bookly_category_relation';
    if (!empty($tax_input)) {
        $t = 0;
        $category = array();
        foreach ($tax_input as $key => $value) {
            $child_term = get_term($value, 'product_cat');
            if ($child_term->parent != 0) {
                /*Select bookly category ID  from our course category id */
                $select_services_courseID  = $wpdb->get_row("SELECT * FROM $category_amelia WHERE (wc_course = '" .  $value . "')");
                $category[] = $select_services_courseID->bk_cat;
            }
            $t++;
        }
        return $category;
    } else {
        return false;
    }
}
