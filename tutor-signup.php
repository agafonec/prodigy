<?php
/*Template Name: Tutor SignUp
*/
get_header();
if (isset($_POST['signup_submit'])) {
    $form_submit = tutor_signUp_request();
}
?>
<section class="feature_image">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="feature_caption">
                    <h2>Become an Expert - Registration </h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="register_form_wrap">
    <div class="container">
        <?php
        if ($form_submit['status'] == true && $form_submit['msg'] != "") { ?>
            <div class="row">
                <div class="col-md-12 alert alert-success fade in show">
                    <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                    <p><?php echo $form_submit['msg']; ?></p>
                </div>
            </div>

        <?php } ?>

        <?php
        if ($form_submit['status'] == false && $form_submit['msg'] != "") { ?>
            <div class="alert alert-danger fade in show">
                <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                <p><?php echo $form_submit['msg']; ?></p>

            </div>

        <?php } ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 student_info">
                    <h4>Personal Info: </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" placeholder="First Name*" name="first_name" class="form-control" value="<?php echo (isset($_POST['first_name']) && $_POST['first_name'] != "") ? $_POST['first_name'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" placeholder="Last Name*" name="last_name" class="form-control" value="<?php echo (isset($_POST['last_name']) && $_POST['last_name'] != "") ? $_POST['last_name'] : '';  ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" placeholder="Email*" name="email_address" class="form-control" value="<?php echo (isset($_POST['email_address']) && $_POST['email_address'] != "") ? $_POST['email_address'] : '';  ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" placeholder="Phone Number*" name="phone_number" class="form-control" value="<?php echo (isset($_POST['phone_number']) && $_POST['phone_number'] != "") ? $_POST['phone_number'] : '';  ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" placeholder="Username*" name="username" class="form-control" value="<?php echo (isset($_POST['username']) && $_POST['username'] != "") ? $_POST['username'] : '';  ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="password" placeholder="Password*" name="password" class="form-control" value="<?php echo (isset($_POST['password']) && $_POST['password'] != "") ? $_POST['password'] : '';  ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="password" placeholder="Confirm-Password*" name="confirm-password" class="form-control" value="<?php echo (isset($_POST['confirm-password']) && $_POST['confirm-password'] != "") ? $_POST['confirm-password'] : '';  ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 parent_info">
                    <h4>Professional Info:</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>What are you currently doing professionally or academically?<span class="astrisks">*</span></label>
                                <div class="custom_checkbox">
                                    <label><input type="checkbox" <?php echo ($_POST['academically'][0] &&
                                                                        $_POST['academically'][0] == 'master_degree') ? "checked" : '' ?> name="academically[]" value="master_degree"><span>Masters
                                            Degree</span></label>
                                    <label><input <?php echo (isset($_POST['academically'][1]) && $_POST['academically'][1] == 'PhD') ? 'checked' : ''; ?> type="checkbox" name="academically[]" value="phd"><span>PhD</span></label>
                                    <label><input <?php echo (isset($_POST['academically'][2]) && $_POST['academically'][2] == 'other') ? 'checked' : ''; ?> type="checkbox" name="academically[]" value="other"><span>other
                                            graduate-level degree [specify]</span></label>
                                    <label><input <?php echo (isset($_POST['academically'][3]) && $_POST['academically'][3] == 'just-completed-graduate') ? 'checked' : ''; ?> type="checkbox" name="academically[]" value="Just Completed My Graduate Degree"><span>just completed my graduate
                                            degree</span></label>
                                    <label><input <?php echo (isset($_POST['academically'][4]) && $_POST['academically'][4] == 'tutoring') ? 'checked' : ''; ?> type="checkbox" name="academically[]" value="Tutoring"><span>Tutoring</span></label>
                                    <label><input <?php echo (isset($_POST['academically'][5]) && $_POST['academically'][5] == 'industry') ? 'checked' : ''; ?> type="checkbox" name="academically[]" value="industry"><span>working in my
                                            industry</span></label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" placeholder="Job Title*" name="job_title" class="form-control" value="<?php echo (isset($_POST['job_title']) && $_POST['job_title'] != "") ? $_POST['job_title'] : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" placeholder="Organization*" name="organization" class="form-control" value="<?php echo (isset($_POST['organization']) && $_POST['organization'] != "") ? $_POST['organization'] : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!--  <div class="col-md-12" >
              <h4>Academic Background:</h4>
              <div class="row">
                 <p>What 4-year college/university did you graduate from for your undergraduate degree?<span class="astrisks">*</span></p>
                 <div class="add_more_university">
                   <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" name="academic[0]['university']" class="form-control" placeholder="University">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" name="academic[0]['city']" class="form-control" placeholder="City">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" name="academic[0]['state']" class="form-control" placeholder="State">
                        </div>
                    </div>
                  </div>
                 </div>
                  <div class="row">
                    <p>What year did you graduate from undergrad?<span class="astrisks">*</span></p>
                    <div class="col-md-12">
                        <div class="form-group">
                          <input type="text" name="year_graduate_undergrad" value="{{ $_POST['year_graduate_undergrad'] }}" class="form-control" placeholder="Year">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <p>What was your primary major?</p>
                    <div class="col-md-12">
                        <div class="form-group">
                          <input type="text" name="primary_major" value="{{ $_POST['primary_major'] }}" class="form-control" placeholder="Major">
                        </div>
                    </div>
                  </div>
              </div>
               <div class="row">
                    <p>If you had any additional majors or minors, please list:</p>
                    <div class="col-md-12">
                        <div class="form-group">
                           <textarea name="additional_major" class="form-control">{{ $_POST['additional_major'] }}</textarea>
                        </div>
                    </div>
              </div>
            </div> -->
                <!--          <div class="col-md-12">
                <h4>if you are currently in graduate school or completed a graduate degree:</h4>
                <div class="form-group d-flex">
                   Institution Name
                  <input type="text" name="institution_name" value="{{ $_POST['institution_name'] }}" placeholder="School">
               </div>
                <div class="form-group d-flex">
                  <div class="custom_checkbox">
                    <label><span>Program type</span></label>
                    <select name="program_type">
                      <option value="">--Please Select</option>
                      <option   @if($_POST['program_type'] && $_POST['program_type'] == 'MA') selected @endif value="MA">MA</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'MS') selected @endif value="MS">MS</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'MPH') selected @endif value="MPH">MPH</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'PhD') selected @endif value="PhD">PhD</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'MD') selected @endif  value="MD">MD</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'MD/PhD') selected @endif value="MD/PhD">MD/PhD</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'DDS') selected @endif value="DDS">DDS</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'JD') selected @endif value="JD">JD</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'MBA') selected @endif value="MBA">MBA</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'PsyD') selected @endif  value="PsyD">PsyD</option>
                      <option  @if($_POST['program_type'] && $_POST['program_type'] == 'Other') selected @endif value="Other">Other</option>
                    </select>
                  </div>
               </div>
                <div class="form-group d-flex">
                    <label><span>Program sub-area</span></label>
                    <input type="text" name="sub-area" value="{{ $_POST['sub-area'] }}" placeholder="e.g. biomedical sciences">
               </div>
               <div class="form-group d-flex">
                  <label>Publications Link</label>
                  <input type="text" name="publications_link" value="{{ $_POST['publications_link'] }}" placeholder="Publications Link">
               </div>
                <div class="form-group d-flex">
                  <label>LinkedIn Profile url<span class="astrisks">*</span></label>
                  <input type="text" name="linkedin_profile_url" value="{{ $_POST['linkedin_profile_url'] }}" placeholder="LinkedIn Profile url">
               </div>
              </div> -->
                <div class="additional-box">
                    <h4>Additional Insight</h4>
                    <div class="additional-top-info">
                        <label>Which of the following subjects are you interested in tutoring? <span class="astrisks">*</span></label>
                        <label>Interested in teaching more than one subject? Once you’ve been approved, you can apply to
                            teach additional subjects from your tutor profile. Please select the main subject you teach.
                        </label>
                        <div class="form-group">
                            <?php
                            $course_categories_args = array(
                                'hide_empty' => false,
                                'taxonomy' => 'product_cat',
                                'parent' => 0,
                            );
                            $course_categories = get_terms($course_categories_args);
                            ?>
                            <select name="interested_tutoring">
                                <option value="">--Please Select--</option>
                                <?php foreach ($course_categories as $course_category) {

                                ?>
                                    <?php
                                    $course_subcategories_args = array(
                                        'hide_empty' => false,
                                        'taxonomy' => 'product_cat',
                                        'parent' => $course_category->term_id,
                                    );
                                    $course_subcategories = get_terms($course_subcategories_args);
                                    ?>
                                    <?php if (!empty($course_subcategories)) { ?>
                                        <optgroup class="main_category" label="<?php echo $course_category->name ?>" disabled>
                                            <?php
                                            foreach ($course_subcategories as $course_subcategory) {
                                                $args = array(
                                                    'post_type' => 'product',
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => 'product_cat',
                                                            'terms' => $course_subcategory->term_id
                                                        )
                                                    ),
                                                    'posts_per_page' => -1
                                                );
                                                $loop = new WP_Query($args);
                                                if ($loop->have_posts()) {
                                            ?>
                                        <optgroup class="sub_category" label="<?php echo $course_subcategory->name; ?>">
                                            <?php



                                                    while ($loop->have_posts()) {
                                                        $loop->the_post() ?>
                                                <option value="<?php echo $course_category->term_id ?>_<?php echo $course_subcategory->term_id; ?>_<?php echo the_id(); ?>">
                                                    &#160;&#160;
                                                    <?php echo the_title(); ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                            <?php }
                                            }
                                        } ?>

                            </optgroup>

                        <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="additional-info">
                        <label> Do you have any prior tutoring experience in the subject you would like to teach? It’s ok if you don’t! Prior experience isn’t required.</label>
                        <div class="form-group">
                            <div class="custom_checkbox">
                                <label><input type="radio" name="prior_tutoring" value="yes" <?php echo ($_POST['prior_tutoring'] && $_POST['prior_tutoring'] == 'yes') ? 'checked' : ''; ?>>
                                    <span>Yes</span></label>
                            </div>
                            <div class="custom_checkbox">
                                <label><input type="radio" name="prior_tutoring" value="no" <?php echo ($_POST['prior_tutoring'] && $_POST['prior_tutoring'] == 'no') ? 'checked' : ''; ?>><span>No</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="additional-info">
                        <label>Based on our schedule, how many hours per week do you intend to spend tutoring? <span class="astrisks">*</span></label>
                        <div class="form-group">
                            <select name="schedule_time">
                                <option value="">--Please Select--</option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '1-3') ? 'selected' : '' ?> value="1-3">1-3</option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '3-6') ? 'selected' : '' ?> value="3-6">3-6</option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '6-10') ? 'selected' : '' ?> value="6-10">6-10</option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '10-15') ? 'selected' : '' ?> value="10-15">10-15</option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '15-20') ? 'selected' : '' ?> value="15-20">15-20
                                </option>
                                <option <?php echo ($_POST['schedule_time'] && $_POST['schedule_time'] == '20 or More') ? 'selected' : '' ?> value="20 or More">20 Or More</option>
                            </select>
                        </div>
                    </div>
                    <div class="additional-info">
                        <label>How did you initially hear about <a href="<?php echo home_url(); ?>">ProdigyPOD.com?</a>
                            <span class="astrisks">*</span>
                        </label>
                        <div class="social_checkbox">
                            <div class="form-group">
                                <label>Google</label><input <?php echo ($_POST['hear_from'][0] &&
                                                                $_POST['hear_from'][0] == 'google') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="google">
                                <label>Facebook Ad</label><input <?php echo ($_POST['hear_from'][1] &&
                                                                        $_POST['hear_from'][1] == 'facebook-ad') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="facebook-ad">
                                <label>Facebook Group Post</label><input <?php echo ($_POST['hear_from'][2] &&
                                                                                $_POST['hear_from'][2] == 'Facebook-group-post') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="Facebook-group-post">
                                <label>Instagram Ad</label><input <?php echo ($_POST['hear_from'][3] &&
                                                                        $_POST['hear_from'][3] == 'instagram-ad') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="instagram-ad">
                                <label>Referred by a Current ProdigyPOD Expert</label><input <?php echo ($_POST['hear_from'][4] &&
                                                                                                    $_POST['hear_from'][4] == 'prodigyPOD-expert') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="prodigyPOD-expert">
                                <label>Other</label><input <?php echo ($_POST['hear_from'][5] &&
                                                                $_POST['hear_from'][5] == 'other') ? 'checked' : '' ?> type="checkbox" name="hear_from[]" value="other">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="submit_btn text-center">
                        <button type="submit" name="signup_submit">send</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php get_footer(); ?>