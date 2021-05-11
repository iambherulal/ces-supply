<?php

/* 
* Template name: Deals Feed
* Version: 1.0
*/
get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

getTotalProductQty();

$args = array(
    'post_type' => 'deals',
    'post_status' => 'publish',
    'posts_per_page' => 0,
    'paged' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'deal_status',
            'field' => 'slug',
            'terms' => 'active',
        )
    ),
);
$deals_post = new WP_Query($args);

?>
<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8 deals__feed-container">
                <?php if ($deals_post->have_posts()) : ?>
                    <form action="<?= admin_url('admin-ajax.php'); ?>" method="POST" id="deal__filter">
                        <div class="mb-3 deal__dropdown-div">
                            <label for="exampleInputEmail1" class="form-label">Deals Category</label>
                            <select name="deal__dropdown" id="deal__dropdown" class="form-control">
                                <option selected value="">All Deals</option>
                                <?php
                                if ($terms = get_terms(array('taxonomy' => 'deal_category', 'orderby' => 'name'))) :
                                    foreach ($terms as $term) :
                                        echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
                                    endforeach;
                                endif;
                                ?>
                            </select>
                            <input type="hidden" name="action" value="dfilter">
                        </div>
                    </form>
                    <div id="deals__feed" class="deals-feed p-2">
                        <?php
                        // THIS LOOP WILL SHOW ALL POSTS BY DEFAULT
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

                        $the_query = new WP_Query($args); ?>

                        <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                                get_template_part('template-parts/deal', 'card');
                            endwhile;
                        endif; ?>

                        <?php wp_reset_postdata(); ?>
                    </div>
                    <div class="feed_load_more">
                        <!-- <div class="btn btn-primary loadmore">Load More...</div> -->
                        <button id="loadMoreFeed" class="btn btn-primary loadmore" type="button">Load More</button>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>

<?php



get_footer();
