<?php 

/* 
* Template name: Login Template
* Version: 1.0
*/

get_template_part( 'template-parts/header', 'login' );

echo do_shortcode('[wpuf-login]');

get_template_part( 'template-parts/footer', 'login' );