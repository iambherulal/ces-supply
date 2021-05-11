<?php

/* 
* Template name: Activity Page
* Version: 1.0
*/

get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

$current_user = wp_get_current_user();

$deals_query = new WP_Comment_Query;
$args = array(
    'user_id' => (current_user_can('vendor')) ? $current_user->ID : '',
);

$deals = $deals_query->query($args);
$sn_count = 1;

getTotalProductQty();


?>
<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12 activity-container" id="dbgDataTable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Deals Submission Activity</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="vendor_activity" class="table table-bordered table-striped">
                            <?php if (!empty($deals)) :   if (current_user_can('vendor')) : ?>
                                    <thead>
                                        <tr>
                                            <?php
                                            $table_head = array('SR', 'Date', 'Deal Name', 'Qty', 'Pickup Date', 'Phone', 'Address', 'Note');
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
                                                <td><?= $deal_form_data['pickup_date']; ?></td>
                                                <td><?= $deal_form_data['pickup_phone']; ?></td>
                                                <td><?= ucwords($vendor_address) ?></td>
                                                <td><?= $deal_form_data['vendor_extra_note']; ?></td>
                                            </tr>
                                        <?php
                                            $sn_count++;
                                        }

                                        ?>
                                    </tbody>

                                <?php elseif (current_user_can('administrator')) : ?>
                                    <thead>
                                        <tr>
                                            <?php
                                            $table_head = array('SR', 'Date', 'Deal Name', 'Qty', 'Pickup Date', 'Phone', 'Address', 'Vendor', 'Note');
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

                                            $deal_date = new DateTime($deal->comment_date);
                                            $deal_date = $deal_date->format('Y-m-d');
                                            $deal_name   = get_post($deal->comment_post_ID);
                                            $deal_form_data = get_comment_meta($deal_id, 'vendor_apply_data', true);
                                            $vendor_address = $deal_form_data['vendor_address'];

                                            if ($vendor_address === 'new') {
                                                $vendor_address = $deal_form_data['vendor_new_address'];
                                            } else {
                                                $vendor_detail = get_user_meta($deal->user_id, 'vendor_detail', true);
                                                $vendor_address = $vendor_detail['business_address'] . ' ' . $vendor_detail['city'] . ' ' . $vendor_detail['state'] . ' ' . $vendor_detail['zipcode'];
                                            }

                                        ?>
                                            <tr>
                                                <td class="deal_id-<?= $deal_id ?>"><?= $sn_count  ?></td>
                                                <td><?= $deal_date ?></td>
                                                <td><?= $deal_name->post_title ?></td>
                                                <td><?= $deal_form_data['product_qty']; ?></td>
                                                <td><?= $deal_form_data['pickup_date']; ?></td>
                                                <td><?= $deal_form_data['pickup_phone']; ?></td>
                                                <td><?= ucwords($vendor_address) ?></td>
                                                <td><?= $deal->comment_author; ?></td>
                                                <td><?= $deal_form_data['vendor_extra_note']; ?></td>
                                            </tr>
                                        <?php
                                            $sn_count++;
                                        }

                                        ?>
                                    </tbody>
                            <?php
                                else :
                                    echo "you don't have sufficient permissions.";
                                endif;
                            else :
                                echo "No deals found!";
                            endif;

                            ?>
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
