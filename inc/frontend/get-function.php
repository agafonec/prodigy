<?php
function get_info()
{
    $UserInfo = array();
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        //echo "<pre>";
        //  print_R($current_user);
        $UserInfo['id'] = $current_user->ID;
        $UserInfo['user_login'] = $current_user->user_login;
        $UserInfo['fullname'] = ucfirst(get_user_meta($current_user->ID, 'first_name', true) . ' ' . get_user_meta($current_user->ID, 'last_name', true));
        $UserInfo['firstname'] = get_user_meta($current_user->ID, 'first_name', true);
        $UserInfo['lastname'] = get_user_meta($current_user->ID, 'last_name', true);
        $UserInfo['email'] = $current_user->user_email;
        $UserInfo['display_name'] = $current_user->display_name;
        $UserInfo['roles'] = (isset($current_user->roles[1]) && $current_user->roles[1] != "") ? $current_user->roles[1] : $current_user->roles[0];

        if ($current_user->roles[1] == "bookly_supervisor") {

            $UserInfo['job_title'] = get_user_meta($current_user->ID, 'job_title', true);
            $UserInfo['organization'] = get_user_meta($current_user->ID, 'organization', true);
            $UserInfo['zoom_account'] = get_user_meta($current_user->ID, 'zoom_account', true);
            $UserInfo['bio'] = get_user_meta($current_user->ID, 'bio', true);
            $UserInfo['google_account'] = get_user_meta($current_user->ID, 'google_account', true);
            $UserInfo['citation'] = unserialize(get_user_meta($current_user->ID, 'citation', true));
            $UserInfo['phone_number'] = get_user_meta($current_user->ID, 'phone_number', true);
            $UserInfo['title'] = get_user_meta($current_user->ID, 'title', true);

            $UserInfo['academic'] = unserialize(get_user_meta($current_user->ID, 'academic', true));
            $UserInfo['year_graduate_undergrad'] = get_user_meta($current_user->ID, 'year_graduate_undergrad', true);
            $UserInfo['primary_major'] = get_user_meta($current_user->ID, 'primary_major', true);
            $UserInfo['additional_major'] = get_user_meta($current_user->ID, 'additional_major', true);
            $UserInfo['institution_name'] = get_user_meta($current_user->ID, 'institution_name', true);
            $UserInfo['program_type'] = get_user_meta($current_user->ID, 'program_type', true);
            $UserInfo['sub_area'] = get_user_meta($current_user->ID, 'sub_area', true);
            $UserInfo['publications_link'] = get_user_meta($current_user->ID, 'publications_link', true);
            $UserInfo['linkedin_profile_url'] = get_user_meta($current_user->ID, 'linkedin_profile_url', true);
        }
        if ($current_user->roles[1] == "customer") {
            $UserInfo['students_no'] = get_user_meta($current_user->ID, 'student_phone_no', true);
            $UserInfo['un_weighted_gpa'] = get_user_meta($current_user->ID, 'un_weighted_gpa', true);
            $UserInfo['grade'] = get_user_meta($current_user->ID, 'grade', true);
            $UserInfo['overall_average'] = get_user_meta($current_user->ID, 'overall_average', true);
        }
        $UserInfo['parent_email'] = get_user_meta($current_user->ID, 'parent_email', true);
        $UserInfo['parents_no'] = get_user_meta($current_user->ID, 'parents_no', true);
        $UserInfo['parents_first_name'] = get_user_meta($current_user->ID, 'parents_first_name', true);
        $UserInfo['parent_last_name'] = get_user_meta($current_user->ID, 'parent_last_name', true);
        $UserInfo['school_name'] = get_user_meta($current_user->ID, 'school_name', true);
        $UserInfo['state'] = get_user_meta($current_user->ID, 'state', true);
        $UserInfo['student_grade'] = get_user_meta($current_user->ID, 'student_grade', true);
        $UserInfo['learning_desciblites'] = get_user_meta($current_user->ID, 'learning_desciblites', true);
        $UserInfo['additional_details'] = get_user_meta($current_user->ID, 'additional_details', true);
        $UserInfo['profile'] = (get_avatar_url($current_user->ID) != "") ? get_avatar_url($current_user->ID) : '';
    }
    // echo "Heei<pre>" . print_R();
    // echo "<pre>";
    // print_R($UserInfo);die();
    if (!empty($UserInfo)) {
        return $UserInfo;
    } else {
        return false;
    }
}
