<?php get_header(); ?>
<!-- Banner Slider start -->
<section class="banner-content">    
	<div class="banner-inner-content w-100" <?php if (get_field('in_the_news_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('in_the_news_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
		<div class="d-md-flex flex-wrap slide-content-main align-items-center w-100">
			<div class="banner-caption">
				<?php if (get_field('in_the_news_listing_banner_title', 'option')) : ?>
					<h1 class="banner-title text-white">
						<?php the_field('in_the_news_listing_banner_title', 'option'); ?>
					</h1>
				<?php endif; ?>
			</div>
		</div>
	</div>    
</section>
<!-- Banner Slider end -->
<div>
	<!-- More News section start -->
	<section>
		<div class="container section-container-padding in-the-news-page-listing">
			<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">All <span>News</span></h2>
				</div>
			</div>

			<!-- News start -->
			<div class="row mb-n4 in-the-news-container"></div>
			<!-- News end -->
		</div>
	</section>
	<!-- More News section end -->
	<?php //echo do_shortcode('[testimonials category=""]'); ?>
</div>
<?php get_footer(); ?>