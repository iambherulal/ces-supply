<?php
get_header(); ?>
<?php ces_page_header(get_the_title(), 'Deals', site_url('deals')) ?>

<?php

$product_deal_status = get_the_terms(get_the_ID(), 'deal_status');
$product_category = get_the_terms(get_the_ID(), 'deal_category');
$deal_note = get_field('note');
$deal_description = get_the_content('', false);
$product_sku = get_field('product_sku');
$product_price = get_field('product_price');
$product_qty = get_post_meta(get_the_ID(), 'product_qty', true);;
$prduct_pending_qty = get_post_meta(get_the_ID(), 'product_pending_qty', true);

// Single post qctivity Query 

$deals_query = new WP_Comment_Query;
$args = array(
    'post_id'   => get_the_ID()
);

$deals = $deals_query->query($args);
$sn_count = 1;

// print_r($deals);

?>
<!-- Main content -->
<div class="content">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card position-relative">
                            <div class="ribbon-wrapper ribbon-lg deal__status-box">
                                <div class="ribbon deal__status-<?= $product_deal_status[0]->slug ?>">
                                    <span class="deal__status"><?= $product_deal_status[0]->name ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="product__image-box">
                                            <?php
                                            if (has_post_thumbnail()) :
                                                the_post_thumbnail('full', ['class' => 'img-responsive', 'title' => get_the_title()]);
                                            else :
                                                $placeholder = wp_get_attachment_image_src('67', 'full');
                                                echo "<img src='{$placeholder[0]}' class='img-responsive wp-post-image' alt='Deal Placeholder' loading='lazy' title='" . get_the_title() . "'>";
                                            endif;
                                            ?>
                                            <h2 class="product__sku">SKU: <span class="product__sku-number"><?= $product_sku ?></span></h2>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h2 class="product__title"><?php the_title() ?></h2>
                                        <div class="product__detail">
                                            <div class="row product_price_qty">
                                                <div class="col-md-6">
                                                    <h5 class="product__price">Price: $<?= $product_price ?></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="product__qty">Qty: <?= ($prduct_pending_qty) ? $prduct_pending_qty : $product_qty; ?></h5>
                                                </div>
                                            </div>
                                            <?php if ($deal_description) : ?>
                                                <div class="product__detail-desciption">
                                                    <p class="font-weight-bold"> Description: </p>
                                                    <?= get_the_content('', false) ?>
                                                </div>
                                            <?php endif ?>
                                            <?php if ($deal_note) : ?>
                                                <div class="product__detail-note">
                                                    <p class="font-weight-bold"> Note: </p>
                                                    <p><?= $deal_note; ?></p>
                                                </div>
                                            <?php endif;
                                            if ($product_category) : ?>
                                                <div class="product__detail-category">
                                                    <p class="font-weight-bold"> Category: </p>
                                                    <div class="product__category">

                                                        <?php
                                                        foreach ($product_category as $value) {
                                                            echo "<span class='badge badge-primary mx-1'>{$value->name}</span>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Apply Now</h3>
                            </div>
                            <div class="card-body">
                                <?php comments_template(); ?>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
           <?php
            endwhile;
        endif;
        if (current_user_can('administrator')) : ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Submission on the Deal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (!empty($deals)) : ?>
                                <table id="vendor_activity" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <?php
                                            $table_head = array('SR', 'Date', 'Qty', 'Vendor Name', 'Pickup Date', 'Phone', 'Email', 'Address');
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
                                                $vendor_address = $vendor_detail['business_address'] . ' , ' . $vendor_detail['city'] . ' , ' . $vendor_detail['state'] . ' , ' . $vendor_detail['zipcode'];
                                            }

                                        ?>
                                            <tr>
                                                <td class="deal_id-<?= $deal_id ?>"><?= $sn_count  ?></td>
                                                <td><?= $deal_date ?></td>
                                                <td><?= $deal_form_data['product_qty']; ?></td>
                                                <td><?= $deal->comment_author; ?></td>
                                                <td><?= $deal_form_data['pickup_date']; ?></td>
                                                <td><?= $deal_form_data['pickup_phone']; ?></td>
                                                <td><?= $deal->comment_author_email; ?></td>
                                                <td><?= ucwords($vendor_address) ?></td>
                                            </tr>
                                        <?php
                                            $sn_count++;
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            <?php
                            else :
                                echo "No Activity Found !";
                            endif;
                            ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>