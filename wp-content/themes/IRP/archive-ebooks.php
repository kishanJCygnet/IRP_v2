<?php get_header(); ?>
<!-- Banner Slider start -->
<section class="banner-content half-banner">    
	<div class="banner-inner-content w-100" <?php if (get_field('ebook_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('ebook_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
		<div class="d-md-flex flex-wrap slide-content-main align-items-center justify-content-center w-100">
			<div class="banner-caption">
				<?php if (get_field('ebook_listing_banner_title', 'option')) : ?>
					<h1 class="banner-title text-white">
						<?php the_field('ebook_listing_banner_title', 'option'); ?>
					</h1>
				<?php endif; ?>
			</div>
		</div>
	</div>    
</section>
<!-- Banner Slider end -->
<div>
	<!-- Featured eBooks section start -->
	<!--<section>
		<div class="container section-container-padding  blog-container">
			<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">Featured <span>eBooks</span></h2>
				</div>
			</div>
			<div class="row mb-n4">
				<?php
				$custom_query_args = array(
					'post_type' => 'ebooks',
					'meta_key'   => '_is_ns_featured_post',
					'meta_value' => 'yes'
				);

				$custom_query = new WP_Query($custom_query_args);
				if ($custom_query->have_posts()) :
					while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
						<div class="col-sm-6 col-lg-4 mb-4">
							<div class="card h-100">
								<div class="card-image-box">
									<?php /*
									$terms = get_the_terms(get_the_ID(), 'ebook_categories');
									if ($terms[0]->name) : ?>
										<div class="card-image-tag">
											<span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo $terms[0]->name; ?></span>
										</div>
									<?php endif; */ ?>
									<?php if (has_post_thumbnail($post->ID)) : ?>
										<?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
										<div class="card-image cover-bg lazyload" style="background-image: url('<?php echo $caseImage[0]; ?>')"></div>
									<?php endif; ?>
								</div>
								<div class="card-body">
									<?php if (get_the_title()) : ?>
										<h5 class="card-title"><?php the_title(); ?></h5>
									<?php endif; ?>

									<?php
									$ebookContent = get_field('short_description', $post->ID);
									if ($ebookContent) : ?>
										<p class="card-text"><?php echo wp_trim_words($ebookContent, 30, '...'); ?></p>
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
	</section>-->
	<!-- Featured eBooks section end -->
	<!-- More eBooks section start -->
	<section class="curved-section">
		<div class="container section-container-padding ebook-page-listing">
			<!--<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">More <span>eBooks</span></h2>
				</div>
			</div>-->
			<!-- eBooks start -->
			<div class="row mb-n4 ebook-container blog-container"></div>
			<!-- eBooks end -->
		</div>
	</section>
	<!-- More eBooks section end -->
	<?php //echo do_shortcode('[testimonials category=""]'); ?>
</div>
<?php get_footer(); ?>