<?php

/**
 * The template for displaying Vendor Profile
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 */

get_header();
?>
<!-- Content Header (Page header) -->
<?php ces_page_header('Profile', 'Dashboard', site_url()) ?>

<?php
// Set the Current Author Variable $curauth
$curauth = get_userdata(intval($author));
$currentUserID = get_current_user_id();
$current_user_cap = current_user_can('administrator');

$about_user = get_user_meta($curauth->ID, 'description', true);
$vendor_detail = get_user_meta($curauth->ID, 'vendor_detail', true);

// Vendor Activity detail

$deals_query = new WP_Comment_Query;
$args = array(
    'user_id' => $curauth->ID,
);

$deals = $deals_query->query($args);
$sn_count = 1;

if ($current_user_cap || $currentUserID == $curauth->ID) { ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Name</strong>
                            <p class="text-muted"><?= $curauth->display_name ?></p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted"><?= $curauth->user_email ?></p>

                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Phone</strong>

                            <p class="text-muted"><?= (isset($vendor_detail['phone']) ? $vendor_detail['phone'] : 'Not Available') ?></p>

                            <hr>
                            <strong><i class="far fa-building mr-1"></i> Business Name</strong>

                            <p class="text-muted"><?= (isset($vendor_detail['business_name']) ? $vendor_detail['business_name'] : 'Not Available') ?></p>

                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Business Phone</strong>

                            <p class="text-muted"><?= (isset($vendor_detail['workphone']) ? $vendor_detail['workphone'] : 'Not Available') ?></p>

                            <hr>


                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="my-1"><b>Address: </b><?= (isset($vendor_detail['business_address']) ? $vendor_detail['business_address'] : 'Not Available') ?></p>
                            <p class="my-1"><b>City: </b><?= (isset($vendor_detail['city']) ? $vendor_detail['city'] : 'Not Available') ?></p>
                            <p class="my-1"><b>State: </b><?= (isset($vendor_detail['state']) ? $vendor_detail['state'] : 'Not Available') ?></p>
                            <p class="my-1"><b>ZIP: </b><?= (isset($vendor_detail['zipcode']) ? $vendor_detail['zipcode'] : 'Not Available') ?></p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i>About</strong>

                            <p class="text-muted"><?= ($about_user) ? $about_user : 'Not Available' ?></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <?php if ($current_user_cap) : ?>
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                                <?php endif; ?>
                                <?php if ($currentUserID === $curauth->ID) : ?>
                                    <li class="nav-item"><a class="nav-link <?= ($current_user_cap) ? '' : 'active'; ?>" href="#editprofile" data-toggle="tab">Edit Profile</a></li>
                                <?php endif;  ?>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <?php if ($current_user_cap) : ?>
                                    <!-- Activity Tab -->
                                    <div class="tab-pane active" id="activity">
                                        <?php if (!empty($deals)) : ?>
                                            <table id="vendor_activity" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        $table_head = array('SR', 'Date', 'Deal Name', 'Qty', 'Pickup Date');
                                                        foreach ($table_head as $head) {
                                                            echo "<th>$head</th>";
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    foreach ($deals as $deal) {
                                                        $deal_id = $deal->comment_ID;

                                                        $deal_name   = get_post($deal->comment_post_ID);
                                                        $deal_form_data = get_comment_meta($deal_id, 'vendor_apply_data', true);
                                                        $vendor_address = $deal_form_data['vendor_address'];

                                                        if ($vendor_address === 'new') {
                                                            $vendor_address = $deal_form_data['vendor_new_address'];
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td class="deal_id-<?= $deal_id ?>"><?= $sn_count  ?></td>
                                                            <td><?= cesChangeDateFormat($deal->comment_date) ?></td>
                                                            <td><?= $deal_name->post_title ?></td>
                                                            <td><?= $deal_form_data['product_qty']; ?></td>
                                                            <td><?= cesChangeDateFormat($deal_form_data['pickup_date']); ?></td>
                                                        </tr>
                                                    <?php
                                                        $sn_count++;
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        <?php
                                        else :
                                            echo 'No activity found';
                                        endif;


                                        ?>
                                    </div>
                                <?php endif; ?>
                                <!-- /.tab-pane -->
                                <?php if ($currentUserID === $curauth->ID) : ?>
                                    <!-- Author update form -->
                                    <?php
                                    if (isset($_POST['update_profile'])) {
                                        $message = array();
                                        print_r($_POST['update_profile']);

                                        $vendorFirstName = sanitize_text_field($_POST['vendor_first_name']);
                                        $vendorLastName = sanitize_text_field($_POST['vendor_last_name']);
                                        $vedorFullName = $vendorFirstName . ' ' . $vendorLastName;
                                        $vendorBio =  sanitize_text_field($_POST['about_ventor']);
                                        $vendorNickName = preg_replace('/\s+/', '', strtolower($vedorFullName));
                                        $password1 =  $_POST['password1'];
                                        $password2 = $_POST['password1'];
                                        $vendorPhone =  sanitize_text_field($_POST['phone']);
                                        $vendorBusinessPhone =  sanitize_text_field($_POST['workphone']);
                                        $vendorBusinessName =  sanitize_text_field($_POST['business_name']);
                                        $vendorBusinessAdd =  sanitize_text_field($_POST['business_address']);
                                        $vendorBusinessCity =  sanitize_text_field($_POST['city']);
                                        $vendorBusinessState =  sanitize_text_field($_POST['state']);
                                        $vendorBusinessZIP =  sanitize_text_field($_POST['zip']);


                                        if ($password1 === $password2) {
                                            $vendorPassword = $password1;
                                        }


                                        $vendor_basic_info = wp_update_user(array(
                                            "ID"    => $currentUserID,
                                            'first_name'        =>  $vendorFirstName,
                                            'last_name'         =>  $vendorLastName,
                                            'display_name'      =>  $vedorFullName,
                                            'description'       => $vendorBio,
                                            'user_nicename'     => $vendorNickName,
                                            'user_pass'         => ($vendorPassword) ? $vendorPassword : ''
                                        ));

                                        $vendor_business_info = array(
                                            'phone' => $vendorPhone,
                                            'business_name' => $vendorBusinessName,
                                            'business_address' => $vendorBusinessAdd,
                                            'city' => $vendorBusinessCity,
                                            'state' => $vendorBusinessState,
                                            'zipcode' => $vendorBusinessZIP,
                                            'workphone' => $vendorBusinessPhone,
                                            'timestamp' => time()

                                        );

                                        $old_vendor_data = get_user_meta($currentUserID, 'vendor_detail', true);

                                        if (!is_array($old_vendor_data)) {
                                            $old_vendor_data = array();
                                        }

                                        $vendorDataMerge = array_merge($old_vendor_data, $vendor_business_info);

                                        $vendorNewData = update_user_meta($currentUserID, 'vendor_detail', $vendorDataMerge);


                                        if ($vendor_basic_info && $vendorNewData) {
                                            $message['message'] = "Profile update Successfully";
                                            $message['type'] = 'success';
                                    ?>
                                            <script>
                                                if (window.history.replaceState) {
                                                    window.history.replaceState(null, null, window.location.href);
                                                }
                                            </script>
                                    <?php
                                        } else {
                                            $message['message'] = "Something went wrong! Please try again";
                                            $message['type'] = 'danger';
                                        }
                                    }
                                    ?>

                                    <div class="tab-pane <?= ($current_user_cap) ? '' : 'active'; ?>" id="editprofile">
                                        <?php
                                        if (isset($message['message'])) {
                                            echo "<div class='alert alert-{$message['type']}' role='alert'>{$message['message']}</div>";
                                        }
                                        ?>
                                        <form id="updateProfile" class="form-horizontal" method="post" autocomplete="off">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-5">
                                                    <input type="text" value="<?= $curauth->first_name ?>" class="form-control" name="vendor_first_name" placeholder="First">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" value="<?= $curauth->last_name ?>" class="form-control" name="vendor_last_name" placeholder="Last">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input disabled type="email" value="<?= $curauth->user_email ?>" class="form-control" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" value="<?= (isset($vendor_detail['phone']) ? $vendor_detail['phone'] : '') ?>" class="form-control" name="phone" placeholder="Phone">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Business Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="<?= (isset($vendor_detail['business_name']) ? $vendor_detail['business_name'] : '') ?>" class="form-control" name="business_name" placeholder="Business Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Business Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="tel" value="<?= (isset($vendor_detail['workphone']) ? $vendor_detail['workphone'] : '') ?>" class="form-control" name="workphone" placeholder="Business Phone">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Location</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="2" placeholder="Business Address" name="business_address"><?= (isset($vendor_detail['business_address']) ? $vendor_detail['business_address'] : '') ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">City</label>
                                                    <input type="text" value="<?= (isset($vendor_detail['city']) ? $vendor_detail['city'] : '') ?>" class="form-control" name="city" placeholder="City">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">State</label>
                                                    <input type="text" value="<?= (isset($vendor_detail['state']) ? $vendor_detail['state'] : '') ?>" class="form-control" name="state" placeholder="State">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">ZIP</label>
                                                    <input autocomplete="new-zip" type="text" value="<?= (isset($vendor_detail['zipcode']) ? $vendor_detail['zipcode'] : '') ?>" class="form-control" name="zip" placeholder="ZIP Code">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">About</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="2" placeholder="About" name="about_ventor"><?= (isset($about_user) ? $about_user : '') ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-5">
                                                    <input id="newpassword" autocomplete="new-password" type="password" class="form-control" name="password1" placeholder="Enter New Password">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input autocomplete="new-password" type="password" class="form-control" name="password2" placeholder="Retype New Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn btn-success" name="update_profile">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                <?php endif; ?>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php } else { ?>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 401</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Unauthorized</h3>
                <p>It appears you don't have permission to access this page.<a href="<?= site_url(); ?>">return to dashboard</a></p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>

<?php } ?>

<?php
get_footer();
