<?php

/* 
* Template name: Register Template
* Version: 1.0
*/

get_template_part('template-parts/header', 'login');

// print_r($_POST);

function registration_validation($email, $password)
{
    global $errors;
    $errors = new WP_Error;

    if (email_exists($email)) {
        $errors->add('email', 'Email Already in use');
    }
    if (5 > strlen($password)) {
        $errors->add('password', 'Password length must be greater than 5');
    }

    if (!is_email($email)) {
        $errors->add('email_invalid', 'Email is not valid');
    }
}

if (isset($_POST['register'])) {

    $first_name = sanitize_text_field($_POST['fname']);
    $last_name = sanitize_text_field($_POST['lname']);
    $phone = sanitize_text_field($_POST['phone']);
    $email = sanitize_email($_POST['email']);
    $password = esc_attr($_POST['password']);
    $business = sanitize_text_field($_POST['business']);
    $address = sanitize_text_field($_POST['address']);
    $city = sanitize_text_field($_POST['city']);
    $state = sanitize_text_field($_POST['state']);
    $zipcode = sanitize_text_field($_POST['zipcode']);
    $workphone = sanitize_text_field($_POST['workphone']);
    $fullname = $first_name . ' ' . $last_name;

    registration_validation($email, $password);

    if (1 > count($errors->get_error_messages())) {
        $userdata = array(
            'user_login'    =>   $email,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'first_name'    =>   $first_name,
            'role'          =>   'vendor',
            'last_name'     =>   $last_name,
            'display_name'  =>   $fullname,
            'user_nicename' =>  preg_replace('/\s+/', '', strtolower($fullname))
        );
        $userID = wp_insert_user($userdata);

        $vendor_detail = array(
            'phone'             => $phone,
            'business_name'     => $business,
            'business_address'  => $address,
            'city'              => $city,
            'state'             => $state,
            'zipcode'           => $zipcode,
            'workphone'         => $workphone
        );

        $save_vendor_meta = add_user_meta($userID, 'vendor_detail', $vendor_detail, true);

        if ($userdata && $save_vendor_meta) {

            $successMessage =  "<div class='success'>Registration has been successful! <a href='" . get_site_url() . '/login' . "'>Log In</a></div>";
        }
    } else {
        echo 'Something went wrong Please try Again !';
    }
}

?>


<style>
    .login-page {
        height: auto;
    }

    .register-box {
        margin: 80px 0px;
        width: 550px;
    }

    .form-title {
        font-weight: 600;
    }

    .form-error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 15px 35px;
        border-radius: 6px;
    }

    .success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }
</style>
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="javascript:void(0);" class="h1"><b>CES </b>Supply</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>
            <?php
            if (isset($errors) && count($errors->get_error_messages()) > 0) {
                echo "<ul class='form-error'>";
                foreach ($errors->get_error_messages() as $error) {
                    echo "<li>{$error}</li>";
                }
                echo "</ul>";
            }
            if (isset($successMessage)) {
                echo $successMessage;
            }
            ?>
            <form class="registration-form" id="registrationform" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input required placeholder="First Name" type="text" value="<?= (isset($_POST['fname']) ? $first_name : null) ?>" name="fname" id="user_fname" class="form-control" size="" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input required placeholder="Last Name" type="text" value="<?= (isset($_POST['lname']) ? $last_name : null) ?>" name="lname" id="user_lname" class="form-control" size="" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                    <input placeholder="Phone Address" type="tel" value="<?= (isset($_POST['phone']) ? $phone : null) ?>" name="phone" id="user_phone" class="form-control" size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <input required placeholder="Email Address" type="email" value="<?= (isset($_POST['email']) ? $email : null) ?>" name="email" id="user_email" class="form-control" size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input required placeholder="Password" type="password" name="password" id="user_pass" class="form-control" size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-building"></span>
                        </div>
                    </div>
                    <input required placeholder="Business Name" type="text" value="<?= (isset($_POST['business']) ? $business : null) ?>" name="business" id="businessName" class="form-control" size="40" />
                </div>
                <p class="form-title">Location</p>
                <div class="input-group mb-3">
                    <input placeholder="Address" type="text" value="<?= (isset($_POST['address']) ? $address : null) ?>" name="address" id="addressName" class="form-control" size="40" />
                </div>
                <div class="input-group mb-3">
                    <input placeholder="City" type="text" value="<?php (isset($_POST['city']) ? $city : null) ?>" name="city" id="cityName" class="form-control" size="40" />
                    <input placeholder="State" type="text" value="<?= (isset($_POST['state']) ? $state : null) ?>" name="state" id="stateName" class="form-control" size="40" />
                </div>
                <div class="input-group mb-3">
                    <input placeholder="ZIP" type="text" value="<?= (isset($_POST['zipcode']) ? $zipcode : null) ?>" name="zipcode" id="zipcode" class="form-control" maxlength="5" />
                    <input placeholder="Work Phone" type="text" value="<?= (isset($_POST['workphone']) ? $workphone : null) ?>" name="workphone" id="workphoneName" class="form-control" size="40" />
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">Yes. I accept the terms and conditions. <a href="#">View terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="register" class="btn btn-primary btn-block my-3">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <a class="text-center d-block" href="<?= site_url("login") ?>">Already have an account?</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>

<?php

get_template_part('template-parts/footer', 'login');
