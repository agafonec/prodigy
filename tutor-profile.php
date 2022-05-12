<?php
/*Template Name: tutor-info*/
get_header();
$showinfo = get_info();
// echo "<pre>";
// print_R($showinfo);
?>
<div class="wrapper register_form_wrap">
    <div class="container tutor">
        <?php if ($update_info['status'] == true && $update_info['msg'] != "") { ?>

            <div class="row">
                <div class="col-md-12 alert alert-success fade in show">
                    <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                    <p><?php echo $update_info['msg']; ?></p>
                </div>
            </div>
        <?php }

        if ($update_info['status'] == false && $update_info['msg'] != "") { ?>
            <div class="alert alert-danger fade in show">
                <a title="close" aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
                <p><?php echo $update_info['msg']; ?></p>

            </div>
        <?php } ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <h4>Tutor Info :</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="first name" name="first_name" class="form-control" value="<?php echo $showinfo['firstname']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="last name" name="last_name" class="form-control" value="<?php echo $showinfo['lastname']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="Title" name="title" class="form-control" value="<?php echo $showinfo['title']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="email" placeholder="email" readonly name="email_address" class="form-control" value="<?php echo $showinfo['email']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="Phone no(opt)" name="tutor_no" class="form-control" value="<?php echo $showinfo['phone_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" readonly placeholder="UserName" name="username" class="form-control" value="<?php echo $showinfo['user_login']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="Google Account(for Drive Access)" name="google_account" class="form-control" value="<?php echo $showinfo['google_account']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="text-left update_password"><a href="javascript:void(0)" class="change_password" id="change_password">Change Password <i class="fa fa-pencil" aria-hidden="true"></i></a></div>
                    <div class="change_password_form" id="change_password_form" style="display: none;">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name="password" id="new_password" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="password" placeholder="confirm-password" id="confirm_password" name="confirm-password" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="close_pwd">
                                    <a href="javascript:void(0)" id="Update_password_form">Update <i class="fa fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <h4>Professional Info:</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Job Title" name="job_title" class="form-control" value="<?php echo $showinfo['job_title']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Organization" name="organization" class="form-control" value="<?php echo $showinfo['organization']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Zoom Account" name="zoom_account" class="form-control" value="<?php echo $showinfo['zoom_account']; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" placeholder="Bio" name="bio" class="form-control" value="<?php echo $showinfo['bio']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Academic Background:</h4>
                    <div class="row">
                        <p>What 4-year college/university did you graduate from for your undergraduate degree?</p>
                        <div class="add_more_university">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $showinfo['academic'][0]['university']; ?>" name="academic[0][university]" class="form-control" placeholder="University">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $showinfo['academic'][0]['city']; ?>" name="academic[0][city]" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $showinfo['academic'][0]['state']; ?>" name="academic[0][state]" class="form-control" placeholder="State">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p>What year did you graduate from undergrad?</p>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="year_graduate_undergrad" value="<?php echo $showinfo['year_graduate_undergrad']; ?>" class="form-control" placeholder="Year">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p>What was your primary major?</p>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="primary_major" value="<?php echo $showinfo['primary_major']; ?>" class="form-control" placeholder="Major">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p>If you had any additional majors or minors, please list:</p>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="additional_major" class="form-control"><?php echo $showinfo['additional_major']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <h4>if you are currently in graduate school or completed a graduate degree:</h4>
                        <div class="form-group d-flex">
                            Institution Name
                            <input type="text" name="institution_name" value="<?php echo $showinfo['institution_name']; ?>" placeholder="School">
                        </div>
                        <div class="form-group d-flex">
                            <div class="custom_checkbox">
                                <label><span>Program type</span></label>
                                <select name="program_type">
                                    <option value="">--Please Select</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MA') ? 'selected' : ''; ?> value="MA">MA</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MS') ? 'selected' : ''; ?> value="MS">MS</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MPH') ? 'selected' : ''; ?> value="MPH">MPH</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'PhD') ? 'selected' : ''; ?> value="PhD">PhD</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MD') ?  'selected' : ''; ?> value="MD">MD</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MD/PhD') ? 'selected' : ''; ?> value="MD/PhD">MD/PhD</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'DDS') ? 'selected' : ''; ?> value="DDS">DDS</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'JD') ? 'selected' : ''; ?> value="JD">JD</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'MBA') ? 'selected' : ''; ?> value="MBA">MBA</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'PsyD') ? 'selected' : ''; ?> value="PsyD">PsyD</option>
                                    <option <?php echo (isset($showinfo['program_type']) && $showinfo['program_type'] == 'Other') ? 'selected' : ''; ?> value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label><span>Program sub-area</span></label>
                            <input type="text" name="sub-area" value="<?php echo $showinfo['sub_area']; ?>" placeholder="e.g. biomedical sciences">
                        </div>
                        <div class="form-group d-flex">
                            <label>Publications Link</label>
                            <input type="text" name="publications_link" value="<?php echo $showinfo['publications_link']; ?>" placeholder="Publications Link">
                        </div>
                        <div class="form-group d-flex">
                            <label>LinkedIn Profile url<span class="astrisks">*</span></label>
                            <input type="text" name="linkedin_profile_url" value="<?php echo $showinfo['linkedin_profile_url']; ?>" placeholder="LinkedIn Profile url">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <h4>Pre-Lesson Survey Page:</h4>
                    <div class="row">
                        <div class="col-md-12" id="dynamic_field">
                            <?php if (!empty($showinfo['citation'])) {
                                foreach ($showinfo['citation'] as $citation) { ?>
                                    <div class="form-group" id="citation_grup">
                                        <label>Citation</label>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <input type="text" placeholder="Citation" name="citation[]" class="form-control" value="<?php echo $citation; ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <a class="site_btn clickhere" href="<?php echo $citation; ?>">Click Here</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="form-group" id="citation_grup">
                                    <label>Citation</label>
                                    <input type="text" placeholder="Citation" name="citation[]" class="form-control" value="">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="javascript:void(0)" id="add_new_citation"><i class="fa fa-plus" aria-hidden="true"></i><span>Add New</span></a>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="submit_btn text-center">
                        <button type="submit" name="update_info">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php get_footer(); ?>