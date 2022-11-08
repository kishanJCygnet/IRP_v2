<?php
/* 
	404 page 
 */
get_header();
?>
<div class="not-found-page">
	<div class="container section-container-padding">
		<div class="row">
			<div class="col-md-6">
				<div class="p-4">
					<img src="<?php echo get_theme_file_uri(); ?>/assets/images/404-image.svg" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="text-center d-flex flex-column align-items-center h-100 justify-content-center">
					<h1>404</h1>
					<h3 class="mb-4">Page not found</h3>
					<p class="mb-5 text-dark-blue">We’re sorry the page you requested could not be found.<br>
						Please go back to the homepage.</p>
					<a href="<?php echo site_url(); ?>" class="btn"><span class="text">Go home</span><span class="effect"></span></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>