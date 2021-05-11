<?php

get_header();

global $wp_query;
$total_results = $wp_query->found_posts;

$total_results = sprintf(_n('%s result', '%s results', $total_results, 'ces-supply'), $total_results);

ces_page_header('Search Results for "' . get_search_query() . '"' . " found $total_results ", '', '');

// printf( esc_html__( 'Search Results for: %s', 'ces' ), '<span>' . get_search_query() . '</span>' )
?>
<section class="content">
	<div class="container-fluid">
		<h2 class="text-center display-4">Search</h2>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<form action="<?= site_url(); ?>" method="get">
					<div class="input-group">
						<input type="search" name="s" value="<?php the_search_query(); ?>" class="form-control form-control-lg" placeholder="Type your keywords here">
						<div class="input-group-append">
							<button type="submit" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="container">
		<?php if (have_posts()) : ?>
			<div class="row">
				<div class="col-md-12">
					<div class="search__result d-flex mt-4 flex-wrap mb-4">
						<?php while (have_posts()) : the_post(); ?>
							<div class="search__result-card w-50">
								<div class="card m-2">
									<div class="card-header">
										<h3 class="card-title"><?php the_title(); ?></h3>
									</div>
									<div class="card-body">
										<?php the_content();
										echo get_post_type(get_the_ID()); ?>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
						<?php endwhile; ?>
					</div>
					<!-- /.card -->
				</div>
			</div>
		<?php else : ?>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card mt-4">
						<div class="card-header">
							<h3 class="card-title">We Checked Everywhere</h3>
						</div>
						<div class="card-body">
							<p>But could't find the page you're looking for 😥</p>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
	</div>
<?php endif; ?>
</div>


</section>
<?php get_footer(); ?>