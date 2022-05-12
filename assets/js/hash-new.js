jQuery(document).ready(function () {
    jQuery("form#login_form #login_btn").attr("disabled", false);
    jQuery('#login_form').submit(function (e) {
        jQuery("form#login_form #login_btn").attr("disabled", true);
        e.preventDefault();
        var formData = jQuery(this).serialize();
        jQuery.ajax({
            type: 'post',
            dataType: 'json',
            url: frontendajax.ajaxurl,
            data: formData + '&action=loggedIn',
            // data: {action: 'loggedIn', formdata: formData},
            success: function (data) {
                console.log(data);
                if (data.status == true) {
                    window.location.href = data.url;
                    toastr.success(data.msg);
                } else {
                    jQuery("form#login_form #login_btn").attr("disabled", false);
                    toastr.error(data.msg);
                }
            }
        });

    });


});


jQuery(document).ready(function () {

    var readURL = function (input) {
        //console.log(input.files[0].name);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                jQuery('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            jQuery("#upload_avtar").submit();

        }
    }


    jQuery(".file-upload").on('change', function () {
        readURL(this);

    });

    jQuery(".upload-button").on('click', function () {
        jQuery(".file-upload").click();

    });
    jQuery('.load_course').on('click', function (ev) {
        jQuery('.course_modal .modal-body').html('');
        jQuery.ajax({
            type: 'post',
            url: frontendajax.ajaxurl,
            data: 'action=listTutorsbyCourse&course_id=' + jQuery(ev.target).parents('a').attr('data-course-id') + '&subject_id=' + jQuery(ev.target).parents('a').attr('data-subject-id'),
            success: function (data) {
                if (data.msg) {
                    jQuery('.course_modal .modal-body').html(data.msg);
                }
            }
        });
    })
    jQuery(function () {
        jQuery('#datetimepicker1').datetimepicker();
    });

    if (jQuery('#holidays_modal').length > 0) {
        window.setTimeout(function () {
            jQuery('#holidays_modal').modal('show');
        }, 3000);

    }
});
jQuery('#upload_avtar').on('submit', (function (e) {
    e.preventDefault();
    var fd = new FormData();
    var files = jQuery('#profile_pix')[0].files;
    if (files.length > 0) {
        fd.append('file', files[0]);
        fd.append('action', 'uploadprofile');
        console.log(fd);
        jQuery.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status == true) {
                    toastr.success(data.msg);
                } else {
                    toastr.error(data.msg);
                }

            },
        });
    }

}));
jQuery(document).ready(function () {

    jQuery('#change_password').on('click', (function (e) {
        jQuery('#change_password_form').css("display", "inline");
    }));

    jQuery('#add_new_citation').on('click', (function (e) {
        console.log("add new citation");
        var wrapper = jQuery('#dynamic_field'); //Input field wrapper
        var fieldHTML = '<div class="form-group" id="citation_grup">';
        fieldHTML += '<label>Citation</label>';
        fieldHTML += '<input type="text" placeholder="Citation" name="citation[]" class="form-control" value="">';
        fieldHTML += '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus"></i></a></div></div>';
        jQuery(wrapper).append(fieldHTML);


    }));


    //Once remove button is clicked
    jQuery('#dynamic_field').on('click', '.remove_button', function (e) {
        e.preventDefault();
        jQuery(this).parent('div').remove(); //Remove field html
    });



    jQuery('#Update_password_form').on('click', (function (e) {
        var password = jQuery('#new_password').val();
        var confirm_password = jQuery('#confirm_password').val();
        jQuery('#Update_password_form .fa-spin').css("display", "inline-block");
        jQuery.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl,
            data: { action: 'updatePassword', password: password, confirm: confirm_password },
            // dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    toastr.success(data.msg);
                    jQuery('#Update_password_form .fa-spin').css("display", "none");
                } else {
                    toastr.error(data.msg);
                    jQuery('#Update_password_form .fa-spin').css("display", "none");
                }

            },
        });

        //jQuery('#change_password_form').css("display", "none");
    }));

    jQuery('input[type=radio][name=learning_desciblites]').change(function () {
        if (this.value == 'yes') {
            jQuery('#experince_yes').css("display", "inline");
        } else {
            jQuery('#experince_yes').css("display", "none");
        }

    });
});
jQuery('.how_work_slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1
});
/**APPLIED FOR TUTION**/
function students_applied_tution() {
    var courses_id = jQuery(this).attr('data-courses');
    var subject_id = jQuery(this).attr('data-subject');
    var tutor_id = jQuery(this).attr('data-tutor-id');
    console.log(courses_id);
}

function tutor_information(tutor_id, courses_id) {
    jQuery.ajax({
        type: 'POST',
        url: frontendajax.ajaxurl,
        data: { action: 'tutor_info', tutorId: tutor_id, course: courses_id },
        // dataType: 'json',
        success: function (data) {
            if (data.status == true) {
                jQuery('.tutor_information').html(data.html);
                jQuery('#information_modal').modal('show');

            } else {
                //  toastr.success(data.msg);
                toastr.error('Something Goes Wrong!');
            }

        },
    });


}

function my_schedule(tutor_id, courses_id, hideinfo = "") {
    jQuery('#schedule_modal #display_name').val('');
    jQuery('#schedule_modal #display_email').val('');
    jQuery('#schedule_modal #course_id').val('');
    jQuery('#schedule_modal #tutor_id').val('');
    if (hideinfo) {
        jQuery('#information_modal').modal('hide');
    }
    jQuery.ajax({
        type: 'POST',
        url: frontendajax.ajaxurl,
        data: { action: 'tutor_details', tutorId: tutor_id },
        // dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == true) {
                jQuery('#schedule_modal #display_name').val(data.user_login);
                jQuery('#schedule_modal #display_email').val(data.user_email);
                jQuery('#schedule_modal #course_id').val(courses_id);
                jQuery('#schedule_modal #tutor_id').val(tutor_id);
                jQuery('#schedule_modal').modal('show');
            } else {
                //  toastr.success(data.msg);
                toastr.error('Something Goes Wrong!');
            }

        },
    });




}
jQuery(document).ready(function () {
    jQuery('#add_schedule').on('submit', (function (e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl,
            data: formData + '&action=create_schedule',
            // dataType: 'json',
            success: function (data) {

                if (data.status == true) {
                    toastr.success(data.msg);
                    jQuery('#schedule_modal').modal('hide');
                } else {
                    toastr.error(data.msg);
                }

            },
        });

    }));




    /********* Tutor find select box jquery*****************************/

    // getselected_subject(jQuery("#tutors_stage").val());
    jQuery("#tutors_stage").on('change', function () {

        var mainpage_url = window.location.href.split('?');
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        var search_type = getUrlVars()["search_type"];
        var stage = getUrlVars()["stage"];
        var subject = getUrlVars()["subject"];
        var course = getUrlVars()["course"];
        if (search_type == "find") {
            if (this.value != '0') {
                //  var params = {'stage':this.value, 'subject':subject, 'course':course,'search_type':search_type};
                var params = { 'stage': this.value, 'search_type': search_type };
                var new_url = mainpage_url[0] + '?' + jQuery.param(params);
                //console.log(new_url);
                window.location.replace(new_url);

                //location.reload(new_url)
            }
        }


        if (this.value == '0') {
            jQuery('#tutors_subject').html("<option value='0'>Select Subject</option>");
            //jQuery('#tutors_subject').html('');
        } else {
            getselected_subject(this.value);

        }
    });
    jQuery("#tutors_subject").on('change', function () {
        var mainpage_url = window.location.href.split('?');
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        var search_type = getUrlVars()["search_type"];
        var stage = getUrlVars()["stage"];
        var subject = getUrlVars()["subject"];
        var course = getUrlVars()["course"];
        if (search_type == "find") {
            if (this.value != '0') {
                //var params = {'stage':stage, 'subject':this.value, 'course':course,'search_type':search_type};
                var params = { 'stage': stage, 'subject': this.value, 'search_type': search_type };
                var new_url = mainpage_url[0] + '?' + jQuery.param(params);
                //console.log(new_url);
                window.location.replace(new_url);

                //location.reload(new_url)
            }
        }
        if (this.value == '0') {

            jQuery('#tutors_course').html("<option value='0'>Select Course</option>");
        } else {

            getselected_courses(this.value);
        }
    });
    jQuery("#tutors_course").on('change', function () {
        var mainpage_url = window.location.href.split('?');
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        var search_type = getUrlVars()["search_type"];
        var stage = getUrlVars()["stage"];
        var subject = getUrlVars()["subject"];
        var course = getUrlVars()["course"];
        if (search_type == "find") {
            if (this.value != '0') {
                var params = { 'stage': stage, 'subject': subject, 'course': this.value, 'search_type': search_type };
                // var params = {'stage':stage, 'subject':this.value, 'search_type':search_type};
                var new_url = mainpage_url[0] + '?' + jQuery.param(params);
                //console.log(new_url);
                window.location.replace(new_url);

                //location.reload(new_url)
            }
        }
    });

});
function getselected_courses(subjects) {
    //   jQuery('#tutors_subject').html('');
    jQuery('#tutors_course').html('');
    if (subjects) {

        jQuery.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl,
            data: { action: 'Getsubject', subject: subjects },
            // dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    var course_option = "";
                    course_option += "<option value='0'>Select Course</option>";
                    jQuery.each(data.courses, function (index, value) {
                        course_option += '<option value=' + value.ID + '>' + value.post_name + '</option>';
                    });
                    jQuery('#tutors_course').html(course_option);
                } else {
                    toastr.error(data.msg);
                }

            },
        });
    }

}
function getselected_subject(stages) {
    if (stages) {
        jQuery('#tutors_subject').html('');
        jQuery('#tutors_course').html('');
        jQuery.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl,
            data: { action: 'Getcourses', stage: stages },
            // dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    var subject_option = "";
                    var course_option = "";
                    subject_option += "<option value='0'>Select Subject</option>";
                    course_option += "<option value='0'>Select Course</option>";
                    jQuery.each(data.subject, function (index, value) {
                        // if(index == 0){
                        //  subject_option +='<option value='+value.term_id+' selected>'+value.name+'</option>';
                        // }else{
                        subject_option += '<option value=' + value.term_id + '>' + value.name + '</option>';
                        //}
                    });
                    // jQuery.each(data.courses, function( index, value) {
                    //     // if(index == 0){
                    //     //   course_option +='<option value='+value.ID+' selected>'+value.post_name+'</option>';
                    //     //  }else{
                    //       course_option +='<option value='+value.ID+'>'+value.post_name+'</option>';
                    //      //}
                    //   });
                    jQuery('#tutors_subject').html(subject_option);
                    jQuery('#tutors_course').html(course_option);

                } else {
                    toastr.error(data.msg);
                }

            },
        });



    }

}
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
