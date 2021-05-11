<?php

/* 
* Template name: Deal Listing Page
* Version: 1.0
*/


get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

$current_user = wp_get_current_user();

$all_deals_query = new WP_Query(array(
    'post_type' => 'deals',
    'post_status' => 'publish',
    'posts_per_page' =>  -1
));



$sn_count = 1;


?>
<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12 activity-container" id="dbgDataTable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Deals</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php if (current_user_can('administrator')) : ?>
                            <table id="vendor_activity" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php
                                        $table_head = array('SR', 'Date', 'Deal Name', 'Price', 'Total Qty', 'Pending Qty', 'SKU', 'Category', 'Status');
                                        foreach ($table_head as $head) {
                                            echo "<th>$head</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    getTotalProductQty();

                                    if ($all_deals_query->have_posts()) : while ($all_deals_query->have_posts()) :
                                            $all_deals_query->the_post();
                                            $deal_id = get_the_ID();

                                            $pending_qty = get_post_meta($deal_id, 'product_pending_qty', true);

                                            $deal_obj_list = get_the_terms($deal_id, 'deal_category');
                                            $deals_string = join(', ', wp_list_pluck($deal_obj_list, 'name'));

                                    ?>
                                            <tr>
                                                <td class="deal_id-<?= $deal_id ?>"><?= $sn_count  ?></td>
                                                <td><?= get_the_date("Y-m-j"); ?></td>
                                                <td><a style="color: inherit" target="_blank" href="<?= get_the_permalink() ?>"><?= get_the_title(); ?></a></td>
                                                <td>$<?php the_field('product_price', $deal_id) ?></td>
                                                <td><?php the_field('product_qty', $deal_id); ?></td>
                                                <td><?= get_post_meta($deal_id, 'product_pending_qty', true) ?></td>
                                                <td><?php the_field('product_sku', $deal_id); ?></td>
                                                <td><?= $deals_string ?></td>
                                                <td class="deal__status">
                                                    <?php

                                                    $status = get_field('deal_status', $deal_id);
                                                    $staus_class = ($status->slug == 'active') ? 'primary' : 'danger';
                                                    ?><span class="badge badge-<?= $staus_class ?>"><?= $status->name; ?></span></td>
                                            </tr>
                                    <?php
                                            $sn_count++;
                                        endwhile;
                                    endif;

                                    ?>
                                </tbody>
                            </table>
                        <?php else :
                            echo "You don't have sufficient permissions to access this page";
                        endif;
                        ?>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
</section>

<?php



get_footer();
