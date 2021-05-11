<?php

get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());
?>
<section class="content">

	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><?php the_title(); ?></h3>
		</div>
		<div class="card-body">
			<?php the_content(); ?>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->

</section>
<?php get_footer(); ?>