<?php get_header(); ?>
<!-- Banner Slider start -->
<section class="banner-content half-banner inner-page-banner">    
	<div class="banner-inner-content w-100" <?php if (get_field('white_papers_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('white_papers_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
		<div class="d-md-flex flex-wrap slide-content-main align-items-center w-100">
			<div class="banner-caption">
				<?php if (get_field('white_papers_listing_banner_title', 'option')) : ?>
					<h1 class="banner-title text-white">
						<?php the_field('white_papers_listing_banner_title', 'option'); ?>
					</h1>
				<?php endif; ?>
			</div>
		</div>
	</div>    
</section>
<!-- Banner Slider end -->
<div>
	<!-- Featured White Papers section start -->
	<?php /* ?>
	<section class="curved-section">
		<div class="section-shape section-shape-top">
			<svg xmlns="https://www.w3.org/2000/svg" width="1920.995" height="261.953" viewBox="0 0 1920.995 261.953" class="shape-1">
				<path d="M2,1195.868H1922.995v-240.8S1814.728,932.365,1711,934c-140.5-1.472-365.412,22.553-715.757,128.722-13.636,2.871-41,12.214-73.672,21.165-179.934,44.891-386.526,103.917-582.444,106.825C20.162,1197.854,2,1076.354,2,1076.354Z" transform="translate(-2 -933.915)"></path>
			</svg>
			<svg xmlns="https://www.w3.org/2000/svg" width="1920.995" height="261.953" viewBox="0 0 1920.995 261.953" class="shape-2">
				<path d="M1922.995,1195.868H2v-240.8S110.267,932.365,213.994,934c140.5-1.472,365.412,22.553,715.757,128.722,13.636,2.871,41,12.214,73.672,21.165,179.934,44.891,386.526,103.917,582.444,106.825,318.966,7.143,337.128-114.357,337.128-114.357Z" transform="translate(-2 -933.915)"></path>
			</svg>
		</div>
		<div class="container section-container-padding">
			<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">Latest <span>White Papers</span></h2>
				</div>
			</div>
			<div class="row mb-n4">
				<?php
				$custom_query_args = array(
					'post_type' => 'whitepapers',
					'post_status' => 'publish',
					'posts_per_page' => 3,
					'order' => 'DESC',
					'orderby' => 'ID'
				);

				$custom_query = new WP_Query($custom_query_args);
				if ($custom_query->have_posts()) :
					while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
						<div class="col-sm-6 col-lg-4 mb-4">
							<div class="card h-100">
								<div class="card-image-box">
									<div class="card-image-tag">
										<span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo 'Technology' ?></span>
									</div>
									<?php if (has_post_thumbnail($post->ID)) : ?>
										<?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
										<div class="card-image cover-bg lazyload" data-bg="<?php echo $caseImage[0]; ?>"></div>
									<?php endif; ?>
								</div>
								<div class="card-body">
									<?php if (get_the_title()) : ?>
										<h5 class="card-title"> <?php echo wp_trim_words(get_the_title(), 10, '...'); ?></h5>
									<?php endif; ?>
									<?php
									$whiteContent = get_field('short_description', $post->ID);
									if ($whiteContent) : ?>
										<p class="card-text"><?php echo wp_trim_words($whiteContent, 30, '...'); ?></p>
									<?php endif; ?>
								</div>
								<div class="card-footer bg-transparent border-top-0 text-end">
									<a href="<?php the_permalink(); ?>" class="read-more-link" title="Know More">Know More<i class="bi bi-arrow-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
					<?php endwhile;
				else : ?>
					<div class="col">
						<div class="card no-records" role="alert">
							<div class="card-body">
								<p class="text-danger text-center font-18"><strong><?php _e('No Records Found!'); ?></strong></p>
							</div>
						</div>
					</div>
				<?php endif;
				wp_reset_postdata(); ?>
			</div>
		</div>
		<div class="section-shape section-shape-bottom">
			<svg xmlns="https://www.w3.org/2000/svg" width="1920.995" height="261.953" viewBox="0 0 1920.995 261.953">
				<path d="M2,933.915H1922.995v240.8s-108.267,22.7-211.994,21.068c-140.5,1.472-365.412-22.553-715.757-128.722-13.636-2.871-41-12.214-73.672-21.165-179.934-44.891-386.526-103.917-582.444-106.825C20.162,931.929,2,1053.429,2,1053.429Z" transform="translate(-2 -933.915)"></path>
			</svg>
		</div>
	</section>
	<?php */ ?>
	<!-- Featured White Papers section end -->

	<!-- More White Papers section start -->
	<section class="curved-section">
		<div class="container section-container-padding whitepaper-page-listing">
			<!--<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">All <span>White Papers</span></h2>
				</div>
			</div>-->

			<!-- White Papers start -->
			<div class="row mb-n4 whitepaper-container blog-container"></div>
			<!-- White Papers end -->
		</div>
	</section>
	<!-- More White Papers section end -->
	<?php //echo do_shortcode('[testimonials category=""]'); ?>
</div>
<?php get_footer(); ?>