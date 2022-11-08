<?php get_header();
/* banner content */ ?>
	<section class="banner-content">    
		<div class="banner-inner-content w-100" <?php if (get_field('webinars_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('webinars_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
		   <div class="container">
			<div class="d-md-flex flex-wrap slide-content-main align-items-center w-100">
				<div class="banner-caption">
					<?php if (get_field('webinars_listing_banner_title', 'option')) : ?>
						<h1 class="banner-title text-white">
							<?php the_field('webinars_listing_banner_title', 'option'); ?>
						</h1>
					<?php endif; ?>
				</div>
			</div>
		</div>
		</div>    
	</section>
<?php /* End banner content */	?>

<div>
	<!-- Featured Webinars section start -->
	<?php
	$custom_query_args = array(
		'post_type' => 'webinars',
		'post_status' => 'publish',
		'posts_per_page' => 3,
		'order' => 'DESC',
		'orderby' => 'ID',
		'meta_key'		=> 'status',
		'meta_value'	=> 'Upcoming'
	);

	$custom_query = new WP_Query($custom_query_args);
	if ($custom_query->have_posts()) :
	?>
	<section class="webnair-sec">
		<div class="container">			
			<div class="title-heading">
					<h2>Upcoming Webinars
						<span class="heading-border"></span>
					</h2>
			</div>
			<div class="row mb-n4 blog-container">
				<?php
					while ($custom_query->have_posts()) : $custom_query->the_post(); 
						$category = @get_the_terms($custom_query->ID, 'category'); 
						$speaker = '';
						if (have_rows('webinars_list')) :
							while (have_rows('webinars_list')) : the_row(); 
								if (get_sub_field('speaker_name', $post->ID)) : 
									$speaker .= get_sub_field('speaker_name', $post->ID).' | '; 
								endif; 
							endwhile;
						endif;
					?>
						<div class="col-sm-6 col-lg-4 mb-4">
							<div class="card h-100">
								<div class="card-image-box">
									<?php if ($category[0]->name) : ?>
									  <div class="card-image-tag">
										<span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo $category[0]->name; ?></span>
									  </div>
									<?php endif; ?>
									<?php if (has_post_thumbnail($post->ID)) : ?>
										<?php $webinarImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
										<div class="card-image cover-bg" style="background-image: url('<?php echo $webinarImage[0]; ?>');"></div>
									<?php endif; ?>
								</div>
								<div class="card-body">
									<?php if (get_the_title()) : ?>
										<h5 class="card-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h5>
									<?php endif; ?>
									<?php
									if (get_field('date', $post->ID)) : 
									$formated_date = date('jS F Y', strtotime(get_field('date', $post->ID)));?>
									<?php if (get_field('start_time', $post->ID)) : ?>
										<p class="card-text"><span><i class="fas fa-calendar-alt"></i><?php echo $formated_date; ?></span><span class="text-uppercase"><i class="fas fa-clock"></i><?php echo the_field('start_time', $post->ID); ?> <!--To <?php echo the_field('end_time', $post->ID); ?> -->(<?php echo the_field('time_selection', $post->ID); ?>) </span><?php endif; ?></p>
									<?php endif; ?>
									<?php 
									if ($speaker != '') : ?>
										<p class="card-text"><img src="<?php echo THEME_PATH; ?>images/employee.svg" alt="navigation right" /> <?php echo rtrim(trim($speaker), '|'); ?></p>
									<?php endif; ?>
									
								</div>
								<div class="card-footer bg-transparent border-top-0">
									<a href="<?php the_permalink(); ?>" class="read-more-link" title="Register for Webinar">Register Now <img src="<?php echo THEME_PATH; ?>images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
								</div>
							</div>
						</div>
					<?php endwhile;
				/*else : ?>
					<div class="col">
						<div class="card no-records" role="alert">
							<div class="card-body">
								<p class="text-danger text-center font-18"><strong><?php _e('No Records Found!'); ?></strong></p>
							</div>
						</div>
					</div>
				<?php */ ?>
			</div>
		</div>
	</section>
	<?php endif;
	wp_reset_postdata(); ?>
	<!-- Featured Webinars section end -->	
	
	<!-- More Webinars section start -->
	<section class="webnair-sec">
		<div class="container webinar-page-listing">
				<div class="title-heading">
					<h2>Past Webinars
						<span class="heading-border"></span>
					</h2>
			</div>
			<!-- Webinars start -->
			<div class="row mb-n4 webinars-container blog-container"></div>
			<!-- Webinars end -->
		</div>
	</section>
	<!-- More Webinars section end -->
</div>
<?php get_footer(); ?>