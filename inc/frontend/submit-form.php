<?php
function tutor_signUp_request()
{
    global $wpdb;
    $output = array();
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $organization = isset($_POST['organization']) ? $_POST['organization'] : '';
    $zoom_account = isset($_POST['zoom_account']) ? $_POST['zoom_account'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
    $tutor_no = isset($_POST['tutor_no']) ? $_POST['tutor_no'] : '';
    $roles = isset($_POST['roles']) ? $_POST['roles'] : 'bookly_supervisor';

    $academically = isset($_POST['academically']) ? $_POST['academically'] : ''; /*Array*/
    $academic = isset($_POST['academic']) ? $_POST['academic'] : ''; /*Array*/
    $year_graduate_undergrad = isset($_POST['year_graduate_undergrad']) ? $_POST['year_graduate_undergrad'] : '';
    $primary_major = isset($_POST['primary_major']) ? $_POST['primary_major'] : '';
    $additional_major = isset($_POST['additional_major']) ? $_POST['additional_major'] : '';
    $institution_name = isset($_POST['institution_name']) ? $_POST['institution_name'] : '';
    $program_type = isset($_POST['program_type']) ? $_POST['program_type'] : '';

    $sub_area = isset($_POST['sub-area']) ? $_POST['sub-area'] : '';
    $publications_link = isset($_POST['publications_link']) ? $_POST['publications_link'] : '';
    $linkedin_profile_url = isset($_POST['linkedin_profile_url']) ? $_POST['linkedin_profile_url'] : '';
    $interested_tutoring = isset($_POST['interested_tutoring']) ? $_POST['interested_tutoring'] : '';
    $prior_tutoring = isset($_POST['prior_tutoring']) ? $_POST['prior_tutoring'] : '';
    $schedule_time = isset($_POST['schedule_time']) ? $_POST['schedule_time'] : '';
    $hear_from = isset($_POST['hear_from']) ? $_POST['hear_from'] : ''; /*Array*/

    $email_exists = email_exists($email_address);
    $username_exits = username_exists($username);
    $fullName = $first_name . ' ' . $last_name;
    if ($first_name == "") {
        $output['msg'] = 'Your First Name is required';
        $output['status'] = false;
    } else if ($last_name == "") {
        $output['msg'] = 'Your Last Name is required';
        $output['status'] = false;
    } else if ($email_address == "") {
        $output['msg'] = 'Your Email is required\n';
        $output['status'] = false;
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $output['msg'] = "$email is not a valid email address";
        $output['status'] = false;
    } elseif ($phone_number == "") {
        $output['msg'] = "Required  Phone Number field";
        $output['status'] = false;
    } elseif ($password == "") {
        $output['msg'] = "Required  password field";
        $output['status'] = false;
    } elseif ($confirm_password == "") {
        $output['msg'] = "Required  confirm password field";
        $output['status'] = false;
    } elseif ($password != $confirm_password) {
        $output['msg'] = "Confirm password does not match to Password field";
        $output['status'] = false;
    } elseif ($job_title == "") {

        $output['msg'] = "Required  Job title ";
        $output['status'] = false;
    } else if ($organization == "") {
        $output['msg'] = "Required  organization Field";
        $output['status'] = false;
    } else if (empty($academically)) {

        $output['msg'] = "Please Check What are you currently doing professionally or academically";
        $output['status'] = false;
    }
    //else if ($academic[0]['university'] == "" && $academic[0]['city'] == "" && $academic[0]['state'] == "") {
    // 	$output['msg'] = "Required University,City,State field's";
    // 	$output['status'] = false;
    // } elseif ($academic[0]['university'] == "") {
    // 	$output['msg'] = "Required University field";
    // 	$output['status'] = false;
    // } elseif ($academic[0]['city'] == "") {
    // 	$output['msg'] = "Required city field";
    // 	$output['status'] = false;
    // } elseif ($academic[0]['state'] == "") {
    // 	$output['msg'] = "Required state field";
    // 	$output['status'] = false;
    // } elseif ($year_graduate_undergrad == "") {
    // 	$output['msg'] = "Required What year did you graduate from undergrad? Field";
    // 	$output['status'] = false;
    // } elseif ($linkedin_profile_url == "") {
    // 	$output['msg'] = "Required Linkedin Profile Url field";
    // 	$output['status'] = false;

    // }
    elseif ($interested_tutoring == "") {
        $output['msg'] = "Please Select which subjects are you interested in tutoring?";
        $output['status'] = false;
    } else if ($schedule_time == "") {
        $output['msg'] = "Please Select how many hours per week do you intend to spend tutoring?";
        $output['status'] = false;
    } else if ($hear_from == "") {
        $output['msg'] = "Please Select How did you initially hear about ProdigyPOD.com?";
        $output['status'] = false;
    } elseif ($email_exists) {
        $output['msg'] = "Email is already exists.";
        $output['status'] = false;
    } elseif ($username_exits) {
        $output['msg'] = "Username is already exists.";
        $output['status'] = false;
    } else {
        $info = array();
        $info['ID'] = "";
        $info['user_login'] = $username;
        $info['user_pass'] = esc_attr($confirm_password);
        $info['user_email'] = sanitize_email($email_address);
        $info['display_name'] = $fullName;
        $info['user_status'] = '0';
        $info['remember'] = true;
        $user_register = wp_insert_user($info);
        if ($user_register) {
            update_user_meta($user_register, 'full_name', $full_name);
            update_user_meta($user_register, 'first_name', $first_name);
            update_user_meta($user_register, 'last_name', $last_name);
            update_user_meta($user_register, 'job_title', $job_title);
            update_user_meta($user_register, 'organization', $organization);
            update_user_meta($user_register, 'phone_number', $phone_number);

            update_user_meta($user_register, 'academically', serialize($academically));
            // update_user_meta($user_register, 'academic', serialize($academic));
            // update_user_meta($user_register, 'year_graduate_undergrad', $year_graduate_undergrad);
            // update_user_meta($user_register, 'primary_major', $primary_major);
            // update_user_meta($user_register, 'additional_major', $additional_major);
            // update_user_meta($user_register, 'institution_name', $institution_name);
            // update_user_meta($user_register, 'program_type', $program_type);
            // update_user_meta($user_register, 'sub_area', $sub_area);
            // update_user_meta($user_register, 'publications_link', $publications_link);
            // update_user_meta($user_register, 'linkedin_profile_url', $linkedin_profile_url);

            update_user_meta($user_register, 'interested_tutoring', $interested_tutoring);
            update_user_meta($user_register, 'prior_tutoring', $prior_tutoring);
            update_user_meta($user_register, 'schedule_time', $schedule_time);
            update_user_meta($user_register, 'hear_from', serialize($hear_from));
            // update_field('field_6226d6e606d41', 'Pending', $user_register);
            $subjects = explode('_', $interested_tutoring);


            $subjectData = array(
                'tutor_id' => $user_register,
                'levels_id' => $subjects[0],
                'courses_id' => $subjects[1],
                'subject_id' => $subjects[2],
                'status' => 1,
            );

            $tablename = $wpdb->prefix . 'tutor_subjects';
            $statusData = $wpdb->insert($tablename, $subjectData);
            $user = new WP_User($user_register);
            //$user->add_role($roles);
            $user->add_role('bookly_supervisor');
            $to = get_option('admin_email'); /*ADMIN EMAIL*/
            $subject = 'New Tutor has Registered On Your Site';
            $data['edit_link'] = admin_url('user-edit.php?user_id=' . $user_register, 'http');
            $data['username'] = $username;
            $data['email_address'] = $email_address;

            //$headers = array('Content-Type: text/html; charset=UTF-8');
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From:  PRODIGYPOD <alejandro@ouwebs.com>');

            ob_start();
            include get_stylesheet_directory() . "/emails/expert/approvel.php";
            $message =  ob_get_contents();

            $mail = wp_mail($to, $subject, $message, $headers);

            ob_end_clean();
            if ($mail) {
                $subject_users = 'Account Created Successfully';
                $message_users = "Thank you for applying for an account. Your account is currently pending approval by the site administrator" . get_bloginfo('name');
                $mail = wp_mail($email_address, $subject_users, $message_users, $headers);
            }
            $output['msg'] = "Your account has been Registered Successfully but you'r account still is pending for approval";
            $output['status'] = true;
            unset($_POST);
        } else {
            $output['msg'] = "Something goes wrong.";
            $output['status'] = false;
        }
    }
    //echo "<pre>";
    //print_R($output);die();
    return $output;
    // }
}
