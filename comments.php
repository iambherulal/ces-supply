<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
if (post_password_required()) {
	return;
}
?>
<?php
comment_form();
?>

</div><!-- #comments -->