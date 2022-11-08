<?php
get_header();
if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <div class="case-study blog-single-page">
            <section class="bg-light pt-0">
				<div class="blog-detail">                        
					<div class="section-container-padding pb-0">
						<div class="single-container">
							<div class="blog-top-section">
								<div class="container">
									<div class="head-title-content">
										<div class="col-left">
											
											<div class="blog-title">
												<h1><?php the_title(); ?></h1>
											</div>
											<div>
												<div class="author-share-block ">
													<ul class="author-block mb-0 list-unstyled d-flex flex-wrap">
														<?php if (get_field('author_name')) : ?>
														<li><i class="fas fa-comments"></i> By <?php echo the_field('author_name'); ?></li>
														<?php endif; ?>
														<li>
														<i class="fas fa-calendar-alt"></i>  <?php the_date(); ?>
														</li>
														<li>
														<i class="fas fa-clock"></i> <?php echo do_shortcode('[rt_reading_time label="Reading Time:" postfix="minutes" postfix_singular="minute"]'); ?>
														</li>
													</ul>
												</div>                                       
											</div>
										</div>
										<div class="col-right">
											<div class="share-social-media">
												<span>Share </span>
												<a href="javascript:void(0)" title="Share" class="share-btn"><i class="bi bi-share" aria-hidden="true"></i></a>
												<?php echo sharethis_inline_buttons(); ?>
												<a href="#newsletter" class="btn"><span class="text">Subscribe</span><span class="effect"></span></a>
											</div>
									   </div>                                  
									</div> 
								</div>             
								<?php   /* grab the url for the full size featured image */
								/*$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), '1920w');
								if ($featured_img_url) : ?>
									<div class="blog-banner cover-bg lazyload" style="background-image: url('<?php echo $featured_img_url; ?>')"></div>
								<?php endif; */ ?>
							</div>
							<div class="container section-container-padding pt-0 pb-0">
								<div class="article-container">
									<!--<div class="row">
										<div class="<?php if (get_field('show_sidebar') == 'Yes') : ?><?php else: ?><?php endif; ?> mb-5 mb-md-0">
											<article class="blog-contents">
												<?php the_content(); ?>
											</article>
										</div>
									</div>-->
									<div class="container-with-sidebar">
										<article class="blog-contents pe-md-3 pe-xl-4 pe-xxl-5">
											<?php   /* grab the url for the full size featured image */
												$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), '1920w');
												if ($featured_img_url) : ?>
													<div class="blog-banner cover-bg lazyload" style="background-image: url('<?php echo $featured_img_url; ?>')"></div>
												<?php endif; ?>
											<?php the_content(); ?>
										</article>	
										<aside class="sidebar">
											<div class="sidebar-title text-center">
												<h2 class="fw-normal fs-4">Get in touch</h2>
												<!--<h2 class="fw-normal fs-4">Need Help?</h2> 
												<h4 class="fs-5">Get in touch</h4>-->
											</div>
											<div class="sidebar-block-body">
												<?php echo do_shortcode('[contact-form-7 id="30976" title="Blog detail page contact form"]'); ?>
											</div>
										</aside>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </section>
            <section>
                <?php if (get_field('show_sidebar') == 'Yes') : ?>
                        <div class="container">
                        <?php
                        $relatedPost = get_posts(
                            array(
                                'category__in' => wp_get_post_categories($post->ID),
                                'numberposts' => 3,
                                'post__not_in' =>
                                array($post->ID)
                            )
                        );
                        
                        if (count($relatedPost) > 0) : ?>
                            <div class="title-heading">
								<h2>Related Blogs
									<span class="heading-border"></span>
								</h2>
        					</div>
                             <div class="sidebar-block-body blog-container mt-5">
                           <div class="row mb-n4">
                            <?php 
                                foreach ($relatedPost as $post) {
                                    setup_postdata($post); ?>
                                     <div class="col-sm-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-image-box">
                                                <?php
                                                $category_detail = get_the_category($post->ID);
                                                ?>
                                                <div class="card-image-tag">
                                                    <span class="btn btn-sm btn-lightest-blue btn-tag btn-muted px-3 case-tag">
                                                        <?php echo $category_detail[0]->cat_name; ?>
                                                    </span>
                                                </div>

                                                <?php
                                                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large');
                                                if ($thumb) {
                                                ?>
                                                    <div class="card-image cover-bg lazyload" style="background-image: url('<?php echo $thumb[0]; ?>')"></div>
                                                <?php } ?>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h5>
                                                <div class="author-share-block">
                                                    <ul class="author-block mb-0 list-unstyled d-flex flex-wrap">
                                                        <?php if (get_field('author_name', $post->ID)) : ?>
                                                            <li>
                                                                By <?php echo the_field('author_name'); ?>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if (get_the_date('F j, Y', $post->ID)) : ?>
                                                            <li>
                                                                <?php echo get_the_date('F j, Y', $post->ID); ?>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                wp_reset_postdata(); ?>
                            </div>
                            </div>
                           <?php endif; ?>
                          </div>     
                <?php endif; ?>
            </section>
            <section id="newsletter" class="default-content bg-light pb-0 free-trial-access-content newsletter pt-0">
            <div class="container">       
            <?php if (get_field('show_sidebar') == 'Yes') : ?>  
                    <div class="free-trial-access text-center wow fadeInUp">
                            <?php //echo do_shortcode('[contact-form-7 id="407" title="Subscribe to Newsletter"]'); ?>
                            <?php echo do_shortcode('[email-subscribers-form id="1"]'); ?>
                            </p>
                        </div>
                <?php endif; ?>
            </div>
            </section>
        </div>
<?php endwhile;
endif;
get_footer(); ?>