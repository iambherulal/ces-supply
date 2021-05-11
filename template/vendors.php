<?php

/* 
* Template name: Vendors
* Version: 1.0
*/


get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

global $wpdb;
$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gf_entry", ARRAY_A);
$sn_count = 1;

$vendors_list = get_users(array(
    'role'  => 'vendor',
    'orderby'   => 'registered'
));

// print_r($vendors_list);
?>

<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12 activity-container" id="dbgDataTable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Vendors List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="vendor_activity" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    $table_head = array('SR', 'Name', 'Email', 'Phone', 'Business', 'B. Phone', 'Location', 'Address');
                                    foreach ($table_head as $head) {
                                        echo "<th>$head</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($vendors_list as $vendor) {

                                    $vendor_id = $vendor->ID;
                                    $vendor_meta = get_user_meta($vendor_id, 'vendor_detail', true);

                                ?>
                                    <tr>
                                        <td class="vendor_id-<?= $vendor_id ?>"><?= $sn_count  ?></td>
                                        <td><a target="_blank" href="<?= get_author_posts_url($vendor_id) ?>"><?= $vendor->display_name ?></a></td>
                                        <td><?= $vendor->user_email ?> </td>
                                        <td><?= $vendor_meta['phone'] ?></td>
                                        <td><?= $vendor_meta['business_name'] ?></td>
                                        <td><?= $vendor_meta['workphone'] ?></td>
                                        <td><?= $vendor_meta['business_address'] ?></td>
                                        <td>
                                            <?= (!empty($vendor_meta['city'])) ? "<b>City</b>: {$vendor_meta['city']}" : ''; ?>
                                            <?= (!empty($vendor_meta['state'])) ? "<b>State</b>: {$vendor_meta['state']}" : ''; ?>
                                            <?= (!empty($vendor_meta['zipcode'])) ? "<b>Zipcode</b>: {$vendor_meta['zipcode']}" : ''; ?>
                                        </td>
                                    </tr>
                                <?php
                                    $sn_count++;
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</section>

<?php



get_footer();
