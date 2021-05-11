<?php

$pending_qty = get_post_meta(get_the_ID(), 'product_pending_qty', true);
$deal_qty = get_post_meta(get_the_ID(), 'product_qty', true);


?>

<div class="bg-white border my-3">
    <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
        <div class="d-flex flex-row align-items-center feed-text px-2">
            <?php if (has_post_thumbnail()) : ?>
                <img class="rounded-circle" src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" width="45">
            <?php else :
                $placeholder = wp_get_attachment_image_src('67', 'full');
                echo "<img src='{$placeholder[0]}' width='45' class='rounded-circle' alt='Deal Placeholder' loading='lazy' title='" . get_the_title() . "'>";
            endif; ?>
            <div class="d-flex flex-column flex-wrap ml-2"><span class="font-weight-bold"> <a class="feed_title" href="<?php the_permalink() ?>"><?php the_title() ?></a> </span><span class="text-black-50 time"> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></span></div>
        </div>
    </div>
    <div class="p-2 px-3"><?php the_content() ?><p class="deal_category mb-0"><?= get_the_term_list(get_the_ID(), 'deal_category', '', ' '); ?></p>
    </div>
    <div class="deals_feed-footer">
        <div class="row">
            <div class="col-md-8 deals_feed-meta d-flex">
                <p class="deals_feed-price">Price: $<?php the_field('product_price', get_the_ID()); ?></p>
                <p class="deals_feed-qty"> Qty: <?= ($pending_qty) ? $pending_qty : $deal_qty; ?></p>
                <p class="deals_feed-sku"> SKU: <?php the_field('product_sku', get_the_ID()); ?></p>
            </div>
            <div class="col-md-4 text-center">
                <a href="<?php the_permalink() ?>" class="btn btn-primary btn-sm">Apply Now</a>
            </div>
        </div>
    </div>
</div>