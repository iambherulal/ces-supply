<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package CES_Supply
 */

//  Dynamic URL for assests
function ces_assests()
{
    echo get_template_directory_uri() . '/dist/img/';
}

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open()
    {
        do_action('wp_body_open');
    }
endif;

// Rewrite author base 

function ces_custom_author_base()
{
    global $wp_rewrite;
    $wp_rewrite->author_base = 'user';
    flush_rewrite_rules();
}
add_action('init', 'ces_custom_author_base');


remove_action('shutdown', 'wp_ob_end_flush_all', 1);
add_action('shutdown', function () {
    while (@ob_end_flush());
});


// Load Feed Post by Ajex

function load_deals_by_ajax_callback()
{
    check_ajax_referer('load_more_posts', 'security');

    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'deals',
        'post_status' => 'publish',
        'posts_per_page' => '10',
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'deal_status',
                'field' => 'slug',
                'terms' => 'active',
            )
        ),
    );

    $deals_post = new WP_Query($args); ?>

    <?php if ($deals_post->have_posts()) : ?>
        <?php while ($deals_post->have_posts()) : $deals_post->the_post();
            $product_qty = get_post_meta(get_the_ID(), 'product_qty', true);;
            $prduct_pending_qty = get_post_meta(get_the_ID(), 'product_pending_qty', true); ?>
            <div class="bg-white border my-3">
                <div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                        <div class="d-flex flex-row align-items-center feed-text px-2"><img class="rounded-circle" src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" width="45">
                            <div class="d-flex flex-column flex-wrap ml-2">
                                <span class="font-weight-bold">
                                    <a class="feed_title" href="<?php the_permalink() ?>"><?php the_title() ?></a> </span>
                                <span class="text-black-50 time"> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 px-3"><?php the_content() ?></div>
                <div class="deals_feed-footer">
                    <div class="row">
                        <div class="col-md-8 deals_feed-meta d-flex">
                            <p class="deals_feed-price">Price: $<?php the_field('product_price', get_the_ID()); ?></p>
                            <p class="deals_feed-qty"> Qty: <?= ($prduct_pending_qty) ? $prduct_pending_qty : $product_qty; ?></p>
                            <p class="deals_feed-sku"> SKU: <?php the_field('product_sku', get_the_ID()); ?></p>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="<?php the_permalink() ?>" class="btn btn-primary btn-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
<?php
        endwhile;
    endif;

    wp_die();
}

add_action('wp_ajax_load_deals_by_ajax', 'load_deals_by_ajax_callback');
add_action('wp_ajax_nopriv_load_deals_by_ajax', 'load_deals_by_ajax_callback');


// Add Extra Column to Comment Admin Area

add_filter('manage_edit-comments_columns', 'ces_filter_comments_columns');
function ces_filter_comments_columns($columns)
{
    $columns['pickup_phone'] = __('Phone');
    $columns['pickup_date'] = __('Pickup Date');
    $columns['pickup_address'] = __('Address');
    $columns['qty'] = __('Order Qty');
    return $columns;
}

function ces_comment_column($column, $comment_ID)
{
    $deal_data = get_comment_meta($comment_ID, 'vendor_apply_data', true);

    if ('pickup_phone' == $column) {
        echo $deal_data['pickup_phone'];
    }
    if ('qty' == $column) {
        echo $deal_data['product_qty'];
    }
}
add_filter('manage_comments_custom_column', 'ces_comment_column', 10, 2);



// Remove extra text from login page
add_filter('new_user_approve_welcome_message', 'wpse_76823_welcome_message');

function wpse_76823_welcome_message($message)
{
    return '';
}


function getTotalProductQty()
{
    $deal_query = new WP_Query(array(
        'post_type' => 'deals',
        'comment_count' => array(
            'value' => 1,
            'compare' => '>=',
        )
    ));

    if ($deal_query->have_posts()) : while ($deal_query->have_posts()) :
            $deal_query->the_post();

            $deal_id_using_loop = get_the_ID();

            $all_comments = get_comments(array(
                'post_id'   => $deal_id_using_loop
            ));

            $comment_id_post = array();
            foreach ($all_comments as $data) {
                $comment_id_post[] = $data->comment_ID;
            };

            $product_qty = array();
            foreach ($comment_id_post as $key => $value) {
                $comment_meta1 =  get_comment_meta($value, 'vendor_apply_data', true);
                $product_qty[] = $comment_meta1['product_qty'];
            }

            $sum_of_qty = array_sum($product_qty);

            update_post_meta($deal_id_using_loop, 'product_received_qty', $sum_of_qty);

            $product_qty = get_post_meta($deal_id_using_loop, 'product_qty', true);
            // $product_received_qty = get_post_meta($deal_id_using_loop, 'product_received_qty', true);
            $product_pending_qty = $product_qty - $sum_of_qty;

            update_post_meta($deal_id_using_loop, 'product_pending_qty', $product_pending_qty);

            $pending_qty = get_post_meta($deal_id_using_loop, 'product_pending_qty', true);

            if ($pending_qty <= 0) {
                // echo "deal expired $deal_id_using_loop" . '<br>';
                wp_set_post_terms($deal_id_using_loop, 'Inactive', 'deal_status', false);
                // update_post_meta( $deal_id_using_loop, 'deal_status', 3);				
            } else {
                wp_set_post_terms($deal_id_using_loop, 'Active', 'deal_status', false);
                // echo "deal not expired $$deal_id_using_loop" . '<br>';

            }

        endwhile;
    endif;
}


function cesChangeDateFormat($date)
{
    $new_date = new DateTime($date);
    $dateNewFormat = $new_date->format('Y-m-d');
    return $dateNewFormat;
}

function wpse27856_set_content_type()
{
    return "text/html";
}
// add_filter('wp_mail_content_type', 'wpse27856_set_content_type');

// Select Deal Dropdown

add_action('wp_ajax_dfilter', 'cesDealFilter'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_dfilter', 'cesDealFilter');

function cesDealFilter()
{

    if (isset($_POST['deal__dropdown']) && !empty($_POST['deal__dropdown'])) {
        $args = array(
            'post_type' => 'deals',
            'posts_per_page' => 10,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'deal_status',
                    'field' => 'slug',
                    'terms' => 'active',
                ),
                array(
                    'taxonomy' => 'deal_category',
                    'field' => 'term_id',
                    'terms' => $_POST['deal__dropdown']
                )

            )
        );
    } else {
        $args = array(
            'post_type' => 'deals',
            'posts_per_page' => 10,
            'paged' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'deal_status',
                    'field' => 'slug',
                    'terms' => 'active',
                )
            ),
        );
    }


    $query = new WP_Query($args);

    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/deal', 'card');
        endwhile;
        wp_reset_postdata();
    else :
        echo 'No posts found';
    endif;

    die();
}
