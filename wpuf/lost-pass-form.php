<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="javascript:void(0);" class="h1"><b>CES </b>Supply</a>
        </div>
        <div class="card-body">
            <?php WPUF_Simple_Login::init()->show_errors(); ?>
            <?php WPUF_Simple_Login::init()->show_messages(); ?>
            <form name="lostpasswordform" class="wpuf-login-form" id="lostpasswordform" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="user_login" id="wpuf-user_login" class="form-control" placeholder="Username or Email" value="" size="20" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?php do_action('lostpassword_form'); ?>
                <div class="row">
                    <div class="col-6">
                        <p class="submit">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block" value="<?php esc_html_e('Get New Password', 'wp-user-frontend'); ?>" />
                            <input type="hidden" name="redirect_to" value="<?php echo esc_attr(WPUF_Simple_Login::get_posted_value('redirect_to')); ?>" />
                            <input type="hidden" name="wpuf_reset_password" value="true" />
                            <input type="hidden" name="action" value="lostpassword" />
                            <?php wp_nonce_field('wpuf_lost_pass'); ?>
                        </p>
                    </div>
                </div>
                </p>
            </form>
            <?php echo wp_kses_post(WPUF_Simple_Login::init()->get_action_links(['lostpassword' => false])); ?>
        </div>
    </div>
</div>