<?php
function wc_loggedIn() {
    $login_alert = array();
    $get_by = "";
    $email = isset($_POST['username_email']) ? $_POST['username_email'] : '';
    $password = isset($_POST['password_users']) ? $_POST['password_users'] : '';
    if ($email == "") {
        $login_alert['msg'] = "Required Username Or Email Field";
        $login_alert['status'] = false;
    } elseif ($password == "") {
        $login_alert['msg'] = "Required Password Field";
        $login_alert['status'] = false;
    } else {
        if (is_email($email)) {
            if (email_exists($email)) {
                $get_by = 'email';
            } else {
                $login_alert['msg'] = 'There Is No User Registered With That Email Address or Username.';
                $login_alert['status'] = false;
            }
        } else if (validate_username($email)) {
            if (username_exists($email)) {
                $get_by = 'login';
            } else {
                $login_alert['msg'] = 'There Is No User Registered With That Username.';
                $login_alert['status'] = false;
            }
        } else {
            $login_alert['msg'] = 'Invalid Username or Email Address.';
            $login_alert['status'] = false;
        }
    }

    if (empty($login_alert)) {
        $useremail = get_user_by($get_by, $email);
        $username = "";
        if (!empty($useremail)) {
            $username = $useremail->user_login;
        }
        $login_data = array();
        $login_data['user_login'] = $username;
        $login_data['user_password'] = $password;
        $login_data['remember'] = "true";
        // echo "<pre>";print_R($login_data);echo"</pre>";
        $user = wp_authenticate($username, $password);
        if (is_wp_error($user)) {
            $login_alert['msg'] = "Invalid Username or Email/Password";
            $login_alert['status'] = false;
        } else {
            $user_meta = get_userdata($useremail->id);
            $user_roles = $user_meta->roles;
            $user_verify = "";
            if (in_array('customer', $user_roles)) {
                $user_verify = wp_signon($login_data, false);

            } elseif (in_array('tutor', $user_roles) || in_array('bookly_supervisor', $user_roles)) {
                $status = update_field('field_61c6b31523744', $useremail->id);
                //$approved = get_user_meta($useremail->id, 'tutor_status', true);
                if ($status == 'Pending') {
                    $login_alert['msg'] = "Your account is still pending for approval";
                    $login_alert['status'] = false;
                } else if ($status == "Reject") {
                    $login_alert['msg'] = "Your account has been denied";
                    $login_alert['status'] = false;
                } else {
                    /*status = 1*/
                    $user_verify = wp_signon($login_data, false);
                }

            } elseif (in_array('administrator', $user_roles)) {
                $user_verify = wp_signon($login_data, false);
            }
            if (!is_wp_error($user_verify)) {
                $login_alert['msg'] = "Successfully loggedIn......";
                $login_alert['url'] = $_SERVER["HTTP_REFERER"];
                $login_alert['status'] = true;
            } else {

                $login_alert['msg'] = "Something Goes Wrong! Please Try Again";
                $login_alert['status'] = false;
            }

        }

    }
    wp_send_json($login_alert);
}

?>