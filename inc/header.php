<?php

/**
 * Custom Header File
 *
 */

function ces_page_header($pagetitle, $previouspage, $previousurl)
{
?>
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<?php if (is_single()) : ?>
					<div class="col-sm-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= $previousurl ?>"><?= $previouspage ?></a></li>
							<li class="breadcrumb-item active"><?= $pagetitle ?></li>
						</ol>
					</div>
				<?php elseif (is_search()) : ?>
					<div class="col-sm-12">
						<h1><?= $pagetitle ?></h1>
					</div>
				<?php else : ?>
					<div class="col-sm-6">
						<h1><?= $pagetitle ?></h1>
					</div>
					<div class="col-sm-6">
						<?php if (!is_front_page()) : ?>
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= $previousurl ?>"><?= $previouspage ?></a></li>
								<li class="breadcrumb-item active"><?= $pagetitle ?></li>
							</ol>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php
}
