function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

(function($) {
    const loader = '<div class="loader"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" r="0" fill="none" stroke="#7dd641" stroke-width="2"> <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="0s"></animate> <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="0s"></animate></circle><circle cx="50" cy="50" r="0" fill="none" stroke="#6ce3e8" stroke-width="2"> <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"></animate> <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"></animate></circle></div>';

    $(document).on('click', '.js-upcoming-lessons', function(e) {
        e.preventDefault();

        let ajaxData = {
            action: 'get_future_lessons',
        };

        $.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl, // admin-ajax.php
            data: ajaxData,
            beforeSend: function () {
                // what to do just after the form has been submitted
                $('.appointments-wrap').empty().append(loader);
            },
            success: function ( response ) {
                console.log(response);
                $('.appointments-wrap').append(response);

            },
            complete: function() {
                $('.appointments-wrap').find('.loader').remove();
            },
        })
    })

    $(document).on('click', '.js-book-with-pod', function(e) {
        e.preventDefault();
        let podId = $(this).closest('.pod-box').attr('data-pod-id');
        setCookie('pod_id', podId, 0.1 );

        let ajaxData = {
            action: 'pod_book_again',
            pod_id: podId,
        };

        $.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl, // admin-ajax.php
            data: ajaxData,
            beforeSend: function () {
                // what to do just after the form has been submitted
                // $('#pod_students').addClass('active');
                // $('#pod_students .popup__content').empty().append(loader);
            },
            success: function ( response ) {
                console.log(response);
                window.location.href = response;
            },

        })
    })

    $(document).on('click', '.js-close-popup', function(e) {
        e.preventDefault();

        $(this).closest('.popup').removeClass('active');
    })

    $(document).on('click', '.js-open-students', function(e) {
        e.preventDefault();

        let ajaxData = {
            action: 'display_pod_students',
            pod_id: $(this).closest('.pod-box').attr('data-pod-id'),
        };

        $.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl, // admin-ajax.php
            data: ajaxData,
            beforeSend: function () {
                // what to do just after the form has been submitted
                $('#pod_students').addClass('active');
                $('#pod_students .popup__content').empty().append(loader);
            },
            success: function ( response ) {
                console.log(response);
                $('#pod_students .popup__content').append(response);
            },
            complete: function() {
                $('#pod_students .popup__content').find('.loader').remove();
            },
        })
    })

    $(document).on('click', '.js-previous-lessons', function(e) {
        e.preventDefault();

        let ajaxData = {
            action: 'get_past_lessons',
        };

        $.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl, // admin-ajax.php
            data: ajaxData,
            beforeSend: function () {
                // what to do just after the form has been submitted
                $('.appointments-wrap').empty().append(loader);
            },
            success: function ( response ) {
                console.log(response);
                $('.appointments-wrap').append(response);
            },
            complete: function() {
                $('.appointments-wrap').find('.loader').remove();
            },
        })
    })

    $(document).on('click', '.js-cancel-lesson', function(e) {
        e.preventDefault();

        let ajaxData = {
            action: 'cancel_lesson',
            app_id: $(this).closest('.appointment-box').attr('data-id'),
        };

        $.ajax({
            type: 'POST',
            url: frontendajax.ajaxurl, // admin-ajax.php
            data: ajaxData,
            beforeSend: function () {
                // what to do just after the form has been submitted
                $('.appointments-wrap').empty().append(loader);
            },
            success: function ( response ) {
                alert('Lesson has been cancelled');
                window.location.reload();
            },
            complete: function() {
            },
        })
    })

})(window.jQuery)