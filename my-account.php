<?php
/*Template Name: My Account*/
get_header();
$info =  get_info();
// echo "<pre>";
// print_R($info);
?>

<section class="feature_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="feature_caption">
                    <h2>My Account</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="my_account_wrap">
    <div class="container">
        <form class="form form-vertical" name="upload_avtar" action="" id="upload_avtar" method="post" enctype="multipart/form-data">
            <div class="row align-items-center">
                <div class="col-sm-3 text-center">
                    <div class="circle_profile">
                        <figure><img class="profile-pic" src="<?php echo ($info['profile'] != "") ? $info['profile'] : ''; ?>"></figure>
                        <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>
                            <input class="file-upload" name="profile_pix" id="profile_pix" value="" type="file" accept="image/*" />
                        </div>
                    </div>
                    <div class="kv-avatar-hint">
                        <small>Select file < 1500 KB</small>
                    </div>
                </div>

                <div class="col-sm-9">
                    <div class="registered_student_right">
                        <h2 class="text-center"><?php echo ($info['fullname'] != "") ? $info['fullname'] : ''; ?></h2>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" readonly value="<?php echo ($info['email'] != "") ? $info['email'] : ''; ?>" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pwd">Username</label>
                                    <input type="text" readonly value="<?php echo ($info['user_login'] != "") ? $info['user_login'] : ''; ?>" class="form-control" name="username">
                                </div>
                            </div>
                            <!-- {{!!do_shortcode('[ameliaemployeepanel]')!!}}
                {!!do_shortcode('[ameliabooking show=math]')!!} -->
                            <?php if ($info['roles'] == "customer") { ?>
                                <div class="col-md-12 text-center account_submit_btn">
                                    <a href="<?php echo home_url() . '/profile' ?>" class="account_info_btn">Account Information</a>
                                </div>
                            <?php } ?>


                            <?php
                            if ($info['roles'] == "bookly_supervisor" || $info['roles'] == "administrator") { ?>
                                <div class="col-md-12 text-center account_submit_btn">
                                    <a href="<?php echo home_url() . '/tutor-profile' ?>" class="account_info_btn">My Info</a>

                                    <a href="<?php echo home_url() . '/adjust-hours' ?>" class="account_info_btn">Adjust Hours</a>

                                    <a href="<?php echo home_url() . '/apply-for-subject' ?>" class="account_info_btn">Apply To Teach</a>
                                </div>

                            <?php  } ?>
                        </div>
                    </div>
                </div>

        </form>
    </div>
</div>
<?php

?>

[bookly-staff-advanced]




[bookly-staff-schedule]

<?php get_footer(); ?>