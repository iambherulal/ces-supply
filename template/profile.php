<?php

/* 
* Template name: Profile Template
* Version: 1.0
*/

// Currently Not Using This

get_header();

print_r($_POST);
// echo get_query_var( 'city', false );
?>

<!-- Content Header (Page header) -->
<?php
// ces_page_header('Profile')
?>

<?php

$current_user = wp_get_current_user();

// print_r($current_user);

$about_user = get_user_meta($current_user->ID, 'description', true);
$vendor_detail = get_user_meta($current_user->ID, 'vendor_detail', true);

?>

<form action="" method="post">
    <input type="text" name="user_name" id="name">
    <input type="submit" name="submit_btn">
</form>
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
                        <p class="text-muted"><?= $current_user->display_name ?></p>
                        <hr>
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                        <p class="text-muted"><?= $current_user->user_email ?></p>

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
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">History</a></li>
                            <li class="nav-item"><a class="nav-link" href="#editprofile" data-toggle="tab">Edit Profile</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="<?php ces_assests() ?>user1-128x128.jpg" alt="user image">
                                        <span class="username">
                                            <a href="#">Jonathan Burke Jr.</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Shared publicly - 7:30 PM today</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                        <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="<?php ces_assests() ?>user7-128x128.jpg" alt="User Image">
                                        <span class="username">
                                            <a href="#">Sarah Ross</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Sent you a message - 3 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <form class="form-horizontal">
                                        <div class="input-group input-group-sm mb-0">
                                            <input class="form-control form-control-sm" placeholder="Response">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="<?php ces_assests() ?>user6-128x128.jpg" alt="User Image">
                                        <span class="username">
                                            <a href="#">Adam Jones</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Posted 5 photos - 5 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <img class="img-fluid" src="<?php ces_assests() ?>photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <img class="img-fluid mb-3" src="<?php ces_assests() ?>photo2.png" alt="Photo">
                                                    <img class="img-fluid" src="<?php ces_assests() ?>photo3.jpg" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-6">
                                                    <img class="img-fluid mb-3" src="<?php ces_assests() ?>photo4.jpg" alt="Photo">
                                                    <img class="img-fluid" src="<?php ces_assests() ?>photo1.png" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                        <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="history">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-danger">
                                            10 Feb. 2014
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                            <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                            <div class="timeline-body">
                                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                quora plaxo ideeli hulu weebly balihoo...
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-user bg-info"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                            <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-comments bg-warning"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                            <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                            <div class="timeline-body">
                                                Take me to your leader!
                                                Switzerland is small and neutral!
                                                We are more like Germany, ambitious and misunderstood!
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <?php
                            if (isset($_POST['update_profile'])) {

                                print_r($_POST['update_profile']);
                            }
                            ?>

                            <div class="active tab-pane" id="editprofile">
                                <form class="form-horizontal" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?= $current_user->display_name ?>" class="form-control" name="vendor_name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input disabled type="email" name="vendor_email" value="<?= $current_user->user_email ?>" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" value="<?= (isset($vendor_detail['phone']) ? $vendor_detail['phone'] : 'Not Available') ?>" class="form-control" name="vendor_phone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Business Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?= (isset($vendor_detail['business_name']) ? $vendor_detail['business_name'] : 'Not Available') ?>" class="form-control" name="business_name" placeholder="Business Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Business Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" value="<?= (isset($vendor_detail['workphone']) ? $vendor_detail['workphone'] : 'Not Available') ?>" class="form-control" name="workphone" placeholder="Business Phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Location</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="2" placeholder="Business Address" name="business_address"><?= (isset($vendor_detail['business_address']) ? $vendor_detail['business_address'] : 'Not Available') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <label class="col-form-label">City</label>
                                            <input type="text" value="<?= (isset($vendor_detail['city']) ? $vendor_detail['city'] : 'Not Available') ?>" class="form-control" name="City" placeholder="City">
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="col-form-label">State</label>
                                            <input type="text" value="<?= (isset($vendor_detail['state']) ? $vendor_detail['state'] : 'Not Available') ?>" class="form-control" name="State" placeholder="State">
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="col-form-label">ZIP</label>
                                            <input type="text" value="<?= (isset($vendor_detail['zipcode']) ? $vendor_detail['zipcode'] : 'Not Available') ?>" class="form-control" name="ZIP" placeholder="ZIP Code">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">About</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="2" placeholder="About" name="about_ventor"><?= (isset($about_user) ? $about_user : 'Not Available') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-5">
                                            <input disabled type="password" class="form-control" name="password1" placeholder="Enter New Password">
                                        </div>
                                        <div class="col-sm-4">
                                            <input disabled type="password" class="form-control" name="password2" placeholder="Retype New Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-success" name="update_profile">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
<?php
get_footer();
