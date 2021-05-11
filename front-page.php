<?php
/* 
* Template Name: DashBoard
* Version: 1.0
*
*/


get_header();

global $wpdb;

getTotalProductQty();

ces_page_header('Dashboard', '', '');

$args = array(
  'post_type' => 'deals',
  'post_status' => 'publish',
  'posts_per_page' => '4',
  'tax_query' => array(
    array(
      'taxonomy' => 'deal_status',
      'field' => 'slug',
      'terms' => 'active',
    )
  ),
);

$deals_post = new WP_Query($args);

$current_user = wp_get_current_user();

$deals_activity_query = new WP_Comment_Query;
$args = array(
  'user_id' => (current_user_can('vendor')) ? $current_user->ID : '',
  'number'  => 4
);

$deals_activity = $deals_activity_query->query($args);

// Count Total form Submission

$total_submission = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gf_entry", ARRAY_A);

?>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <?php if (current_user_can('administrator')) : ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= wp_count_posts('deals')->publish ?></h3>

              <p>Total Deals</p>
            </div>
            <div class="icon">
              <i class="fas fa-tag"></i>
            </div>
            <a href="<?= site_url('all-deals') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= wp_count_comments()->all; ?></h3>

              <p>Total Submissions</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= site_url('activity') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php
                  $total_user = count_users();
                  echo $total_user['avail_roles']['vendor'];
                  ?></h3>

              <p>Total Vendors</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= site_url('vendors') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= count($total_submission) ?></h3>

              <p>Total Tickets</p>
            </div>
            <div class="icon">
              <i class="fas fa-info-circle"></i>
            </div>
            <a href="<?= site_url('support-center') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    <?php else : ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card vendor_dashboard">
            <div class="card-header">
              <h3 class="card-title">Welcome back, <?= get_userdata(get_current_user_id())->display_name;  ?>!</h3>
            </div>
            <div class="card-body">
              <p>We’ve assembled some links to get you started:</p>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Latest Deals</h3>
              <a href="<?= site_url('deals') ?>">View All Deals</a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Deals</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($deals_post->have_posts()) : while ($deals_post->have_posts()) :
                    $deals_post->the_post();
                    $deal_id = get_the_ID();

                    $pending_qty = get_post_meta($deal_id, 'product_pending_qty', true);

                ?>
                    <tr>
                      <td>
                        <?php if (has_post_thumbnail()) : ?>
                          <img class="img-circle img-size-32 mr-2" alt="<?= get_the_title(); ?>" src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>">
                        <?php else :
                          $placeholder = wp_get_attachment_image_src('67', 'full');
                          echo "<img src='{$placeholder[0]}' class='img-circle img-size-32 mr-2' alt='Deal Placeholder' loading='lazy' title='" . get_the_title() . "'>";
                        endif; ?>
                        <?= wp_trim_words(get_the_title(), 6) ?>
                      </td>
                      <td>$<?php the_field('product_price', $deal_id) ?></td>
                      <td><?= $pending_qty ?></td>
                      <td>
                        <a target="_blank" href="<?= get_the_permalink() ?>">Apply Now </a>
                      </td>
                    </tr>
                <?php
                  endwhile;
                endif;

                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Latest Activity</h3>
              <a href="<?= site_url('activity') ?>">View All Activity</a>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Deal</th>
                  <th>Qty</th>
                  <th>Pickup Date</th>
                </tr>
              </thead>
              <tbody>
                <?php

                foreach ($deals_activity as $activity) {
                  $activity_id = $activity->comment_ID;

                  $activity_date = new DateTime($activity->comment_date);
                  $activity_date = $activity_date->format('Y-m-d');
                  $activity_name   = get_post($activity->comment_post_ID);
                  $activity_form_data = get_comment_meta($activity_id, 'vendor_apply_data', true);
                  $vendor_address = $activity_form_data['vendor_address'];

                  if ($vendor_address === 'new') {
                    $vendor_address = $activity_form_data['vendor_new_address'];
                  }

                ?>
                  <tr>
                    <td><?= $activity_date ?></td>
                    <td><?= $activity_name->post_title ?></td>
                    <td><?= $activity_form_data['product_qty']; ?></td>
                    <td><?= $activity_form_data['pickup_date']; ?></td>
                  </tr>
                <?php
                }

                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.content-wrapper -->
<?php get_footer(); ?>