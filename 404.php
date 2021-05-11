<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 */

get_header();
?>
<!-- Content Header (Page header) -->
<?php ces_page_header('Page not found', 'Dashboard', site_url()) ?>
<!-- Main content -->
<section class="content">
	<div class="error-page">
		<h2 class="headline text-warning"> 404</h2>

		<div class="error-content">
			<h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

			<p>
				We could not find the page you were looking for.
				Meanwhile, you may <a href="<?= site_url(); ?>">return to dashboard</a>
			</p>
		</div>
		<!-- /.error-content -->
	</div>
	<!-- /.error-page -->
</section>
<!-- /.content -->

<?php
get_footer();
