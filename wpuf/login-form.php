<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="javascript:void(0);" class="h1"><b>CES </b>Supply</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Login into your account</p>
            <?php
            $message = apply_filters('login_message', '');

            if (!empty($message)) {
                echo esc_html($message) . "\n";
            } ?>
            <?php wpuf()->login->show_errors(); ?>
            <?php wpuf()->login->show_messages(); ?>
            <form name="loginform" class="wpuf-login-form" id="loginform" action="<?php echo esc_attr($action_url); ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="log" id="wpuf-user_login" class="form-control" placeholder="Username or Email" value="" size="20" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="pwd" id="wpuf-user_pass" class="form-control" placeholder="Password" value="" size="20" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input name="rememberme" type="checkbox" id="wpuf-rememberme" value="forever">
                            <label for="wpuf-rememberme"><?php esc_html_e('Remember Me', 'wp-user-frontend'); ?></label>
                        </div>
                    </div>
                    <div class="col-4">
                        <p class="submit">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block" value="<?php esc_html_e('Log In', 'wp-user-frontend'); ?>" />
                            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
                            <input type="hidden" name="wpuf_login" value="true" />
                            <input type="hidden" name="action" value="login" />
                            <?php wp_nonce_field('wpuf_login_action', 'wpuf-login-nonce'); ?>
                        </p>
                    </div>
                </div>
                <?php $recaptcha = wpuf_get_option('login_form_recaptcha', 'wpuf_profile', 'off'); ?>
                <?php if ($recaptcha == 'on') { ?>
                    <p>
                    <div class="wpuf-fields">
                        <?php echo wp_kses(recaptcha_get_html(wpuf_get_option('recaptcha_public', 'wpuf_general'), true, null, is_ssl()), [
                            'div' => [
                                'class' => [],
                                'data-sitekey' => [],
                            ],

                            'script' => [
                                'src' => []
                            ],

                            'noscript' => [],

                            'iframe' => [
                                'src' => [],
                                'height' => [],
                                'width' => [],
                                'frameborder' => [],
                            ],
                            'br' => [],
                            'textarea' => [
                                'name' => [],
                                'rows' => [],
                                'cols' => [],
                            ],
                            'input' => [
                                'type'   => [],
                                'value' => [],
                                'name'   => [],
                            ]
                        ]); ?>
                    </div>
                    </p>
                <?php } ?>
                <p>
                    <?php do_action('wpuf_login_form_bottom'); ?>
                </p>
            </form>
            <?php echo wp_kses_post(wpuf()->login->get_action_links(['login' => false])); ?>
        </div>
    </div>
</div>