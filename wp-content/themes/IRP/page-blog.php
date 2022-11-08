<?php get_header(); 

/* banner content */ ?>
	<section class="banner-content half-banner">    
		<div class="banner-inner-content w-100" <?php if (get_field('blog_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('blog_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
			<div class="container">  
			<div class="d-md-flex flex-wrap slide-content-main align-items-center justify-content-center w-100">
				<div class="banner-caption text-center">
					<?php if (get_field('blog_listing_banner_title', 'option')) : ?>
						<h1 class="banner-title text-white wow fadeInUp">
							<?php the_field('blog_listing_banner_title', 'option'); ?>
						</h1>
					<?php endif; ?>
				</div>
			</div>
		</div>
		</div>    
	</section>
<?php /* End banner content */	?>
		
<div>
	<!-- Featured Blog section start -->
	<?php /*<section class="curved-section">
		<div class="container section-container-padding">
			<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">Featured <span>Blogs</span></h2>
				</div>
			</div>
			<div class="row mb-n4">
				<?php
				$custom_query_args = array(
					'post_type'  => 'post',
					'meta_key'   => '_is_ns_featured_post',
					'meta_value' => 'yes',
				);
				$custom_query = new WP_Query($custom_query_args);
				if ($custom_query->have_posts()) :
					while ($custom_query->have_posts()) : $custom_query->the_post();?>
						<div class="col-sm-6 col-lg-4 mb-4">
							<div class="card h-100">
								<div class="card-image-box">
									<?php
									$categories = get_the_category();
									if (!empty($categories)) {?>
										<div class="card-image-tag">
											<span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo esc_html($categories[0]->name);?></span>
										</div>
									<?php }?>

									<?php if (has_post_thumbnail($post->ID)) :?>
										<?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large');?>
										<div class="card-image cover-bg lazyload" style="background-image: url('<?php echo $caseImage[0]; ?>')"></div>
									<?php endif;?>
								</div>
								<div class="card-body">
									<?php if (get_the_title()) :?>
										<h5 class="card-title">
											<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo wp_trim_words(get_the_title(), 10, '...');?></a>
										</h5>
									<?php endif;?>
									<?php
									$blogContent = get_field('short_description', $post->ID);
									if ($blogContent) :?>
										<p class="card-text"><?php echo wp_trim_words($blogContent, 30, '...');?></p>
									<?php endif;?>
								</div>
								<div class="card-footer bg-transparent border-top-0 text-end">
									<a href="<?php the_permalink();?>" class="read-more-link" title="Know More">Know More<i class="bi bi-arrow-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
					<?php endwhile;
				else :?>
					<div class="col">
						<div class="card no-records" role="alert">
							<div class="card-body">
								<p class="text-danger text-center font-18"><strong><?php _e('No Records Found!');?></strong></p>
							</div>
						</div>
					</div>
				<?php endif;
				wp_reset_postdata();?>
			</div>
		</div>
	</section>   */ ?>
	<!-- Featured Blog section end -->
	<!-- More Blog section start -->
	<section class="">
		<div class="container section-container-padding blog-page-listing">
			<!--<div class="section-top-bar d-flex">
				<div class="section-top-bar-container">
					<h2 class="section-title">More <span>Blogs</span></h2>
				</div>
			</div>-->
			<!-- Filter block start -->
			<?php /*<div class="filter-box mb-5">
				<h5 class="text-dark-blue mb-3">Filter By:</h5>
				<form class="submit-all-filter">
					<div class="row gy-3">
						<div class="col-md-6 col-lg-4 col-xl-3">
							<select class="form-select select-category filter-by-category" name="filter-by-category">
								<option value=""></option>
								<?php
								$categories = get_terms(['taxonomy' => 'category', 'hide_empty' => true]);
								foreach ($categories as $category) {?>
									<option value="<?php echo $category->term_id;?>"><?php echo $category->name;?></option>
								<?php }?>
							</select>
						</div>
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
			<!-- Blog start -->
			<div class="blog-container"></div>
			<!-- Blog end -->
		</div>
	</section>
	<!-- More Blog section end -->
	<?php //echo do_shortcode('[testimonials category=""]');?>
</div>
	
<?php get_footer(); ?>
	