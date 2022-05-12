<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<?php wp_footer(); ?>
<div class="modal fade login_modal" id="login_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login_inner">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="left_login_sec">
                                <div class="inner_action">
                                    <h2>ProdigyPOD</h2>
                                    <a href="/tutor-signup/">Become an Expert</a>
                                    <a href="/student-signup/">Register as Student</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="right_login_sec">
                                <h2>Login</h2>
                                <p>Don’t have an account?
                                    Create an Account, it takesless
                                    han a minute</p>
                                <form action="" method="post" id="login_form">
                                    <div class="form-group">
                                        <input class="form-control" name="username_email" type="text"
                                            placeholder="username or email">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="password_users" type="password"
                                            placeholder="password">
                                    </div>
                                    <div class="d-flex login_forgot">
                                        <label for="remember">
                                            <input type="checkbox" id="remember">
                                            <span>Remember me</span>
                                        </label>
                                        <a class="forgot_link" href="#">Forgot password?</a>
                                    </div>
                                    <div class="login_submit text-center">
                                        <button type="submit" id="login_btn">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>