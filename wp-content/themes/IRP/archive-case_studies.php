<?php get_header(); ?>
<!-- Banner Slider start -->
<section class="banner-content half-banner">
	<div class="banner-inner-content w-100" <?php if (get_field('case_studies_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('case_studies_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
		<div class="container"> 
		<div class="d-md-flex flex-wrap slide-content-main align-items-center w-100">
			<div class="banner-caption">
				<?php if (get_field('case_studies_listing_banner_title', 'option')) : ?>
					<h1 class="banner-title text-white wow fadeInUp">
						<?php the_field('case_studies_listing_banner_title', 'option'); ?>
					</h1>
				<?php endif; ?>
			</div>
		</div>
	</div>
	</div>    
</section>
<!-- Banner Slider end -->
<div>
	<!-- Featured Case Studies section start -->
	<!--<section class="webnair-sec">
		<div class="container webinar-page-listing pb-0">
			<div class="title-heading">
					<h2 class="wow fadeInUp">Featured Case Studies
						<span class="heading-border"></span>
					</h2>
			</div>
			<div class="row mb-n4 blog-container">
				<?php
				$custom_query_args = array(
					'post_type'  => 'case_studies',
					'meta_key'   => '_is_ns_featured_post',
					'meta_value' => 'yes'
				);

				$custom_query = new WP_Query($custom_query_args);
				if ($custom_query->have_posts()) :
					while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
						<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
							<div class="card h-100 wow fadeInUp" data-wow-delay="<?php echo $s; ?>s" data-wow-offset="30">
								<div class="card-image-box">
									<?php if (has_post_thumbnail($post->ID)) : ?>
										<?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
										<div class="card-image cover-bg lazyload" style="background-image: url('<?php echo $caseImage[0]; ?>')"></div>
									<?php endif; ?>
								</div>
								<div class="card-body">
									<?php
									/*$terms = @get_the_terms($listingObj->ID, 'solutions');
									if ($terms) :
									?>
										<p>
											<span class="btn btn-sm btn-outline-primary btn-muted px-3 case-tag">
												<?php echo $terms[0]->name; ?>
											</span>
										</p>
									<?php endif; */?>

									<?php if (get_the_title()) : ?>
										<h5 class="card-title"><a href="<?php echo the_field('pdf_link'); ?>" target="_blank"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h5>
									<?php endif; ?>

									<?php
									$caseContent = get_field('short_description', $post->ID);
									if ($caseContent) : ?>
										<p class="card-text"><?php echo wp_trim_words($caseContent, 30, '...'); ?></p>
									<?php endif; ?>
								</div>
								<?php if (get_field('pdf_link')) : ?>
									<div class="card-footer  bg-transparent border-top-0">
										<a href="<?php echo the_field('pdf_link'); ?>" class="read-more-link" title="Read Full Story" target="_blank">Read Full Story <img src="<?php echo THEME_PATH; ?>images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php $s = $s + 0.2; endwhile;
				else : ?>
					<div class="col">
						<div class="card no-records" role="alert">
							<div class="card-body">
								<p class="text-danger text-center font-18"><strong><?php _e('No record found!'); ?></strong></p>
							</div>
						</div>
					</div>
				<?php endif;
				wp_reset_postdata(); ?>
			</div>
		</div>
	</section>-->
	<!-- Featured Case Studies section end -->
	<!-- More case studies section start -->
	<section class="webnair-sec bg-light">
		<div class="container webinar-page-listing casestudy-page-listing">
			<!--<div class="title-heading">
				<h2 class="wow fadeInUp">More Case Studies
					<span class="heading-border"></span>
				</h2>
			</div>-->
			<!-- Filter block start -->
			<?php /*<div class="filter-box mb-5">
				<h5 class="text-dark-blue mb-3">Filter By:</h5>
				<form class="submit-all-filter">
					<div class="row gy-3">
						<div class="col-md-6 col-lg-4 col-xl-3">
							<select class="form-select select-industry filter-by-industry" name="filter-by-industry">
								<option value=""></option>
								<?php
								$industries = get_terms(['taxonomy' => 'industry', 'hide_empty' => false]);
								foreach ($industries as $industry) { ?>
									<option value="<?php echo $industry->term_id; ?>"><?php echo $industry->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 col-lg-4 col-xl-3">
							<select class="form-select select-solution filter-by-solution" name="filter-by-solution">
								<option value=""></option>
								<?php
								$solutions = get_terms(['taxonomy' => 'solution', 'hide_empty' => false]);
								foreach ($solutions as $solution) { ?>
									<option value="<?php echo $solution->term_id; ?>"><?php echo $solution->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<!--<div class="col-md-6 col-lg-4 col-xl-3">
							<select class="form-select select-country filter-by-country" name="filter-by-country">
								<option value=""></option>
								<?php
								$countries = get_terms(['taxonomy' => 'country', 'hide_empty' => false]);
								foreach ($countries as $country) { ?>
									<option value="<?php echo $country->term_id; ?>"><?php echo $country->name; ?></option>
								<?php } ?>
							</select>
						</div>-->
						<div class="col-md-6 col-lg-12 col-xl-3">
							<div class="d-md-flex justify-content-start justify-content-lg-end justify-content-xl-start">
								<input type="button" class="btn btn-primary me-2" title="Submit" value="Submit" id="filter_submit">
								<input type="button" class="btn btn-outline-danger" title="Clear all" value="Clear all" id="clear-filter-research">
							</div>
						</div>
					</div>
				</form>
			</div>  */ ?>
			<!-- Filter block end -->
			<!-- Case Studies start -->
			<div class="casestudy-container webinars-container blog-container"></div>
			<!-- Case Studies end -->
		</div>
	</section>
	<!-- More case studies section end -->
	<?php //echo do_shortcode('[testimonials category=""]'); ?>
</div>
<?php get_footer(); ?>