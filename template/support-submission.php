<?php

/* 
* Template name: Support Submission
* Version: 1.0
*/


get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

global $wpdb;
$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gf_entry", ARRAY_A);
$sn_count = 1;

?>

<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12 activity-container" id="dbgDataTable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Support Form Submission</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="vendor_activity" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    $table_head = array('SR', 'Date', 'Name', 'Email', 'Subject', 'Phone', 'Message');
                                    foreach ($table_head as $head) {
                                        echo "<th>$head</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($results as $result) {

                                    $entry_id = $result['id'];
                                    $entry_date = new DateTime($result['date_created']);
                                    $entry_date = $entry_date->format('Y-m-d');


                                ?>
                                    <tr>
                                        <td class="deal_id-<?= $entry_id ?>"><?= $sn_count  ?></td>
                                        <td><?= $entry_date ?></td>
                                        <td><?= gform_get_meta($entry_id, 1); ?> </td>
                                        <td><?= gform_get_meta($entry_id, 2); ?></td>
                                        <td><?= gform_get_meta($entry_id, 3); ?></td>
                                        <td><?= gform_get_meta($entry_id, 4); ?></td>
                                        <td><?= gform_get_meta($entry_id, 5); ?></td>
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
