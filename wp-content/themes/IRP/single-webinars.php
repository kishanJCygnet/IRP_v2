<?php
get_header();
if (have_posts()) :
    while (have_posts()) : the_post(); 
		$speaker = '';
		if (have_rows('webinars_list')) :
			while (have_rows('webinars_list')) : the_row(); 
				if (get_sub_field('speaker_name')) : 
					$speaker .= get_sub_field('speaker_name', $post->ID).' | '; 
				endif; 
			endwhile;
		endif;
	?>
        <!-- Banner Slider start -->		
        <div>
            <section class="bg-light blog-detail no-min-height single-post">
                <div>
                    <div class="blog-detail pt-5">
                                     <div class="container">
                                         <div class="blog-top-section">
                                        <div class="head-title-content">
                                            <div class="col-left">
                                                <div class="blog-title">
                                                    <h1><?php the_title(); ?></h1>
                                                </div>
                                            </div>
                                            <div class="col-right">
                                                <div class="share-social-media">
                                                    <span>Share </span>
                                                    <a href="javascript:void(0)" title="Share" class="share-btn"><i class="bi bi-share" aria-hidden="true"></i></a>
                                                    <?php echo sharethis_inline_buttons(); ?>
                                                    <!--<a href="#" class="btn" >Subscribe</a>-->
                                                 </div>
                                           </div>                                  
                                        </div> 
                                </div>
                         </div> 
                           <!-- Banner Slider start -->		
                            <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), '1920w'); ?>
                            <div class="banner-content">    
                                <div class="banner-inner-content w-100" <?php if ($featured_img_url) : ?> style="background-image: url('<?php echo $featured_img_url; ?>')" <?php endif; ?>>  
                                    <div class="container">
                                       
                                            <div class="banner-caption text-white">
                                                <div class="blog-top-section w-100">
                                                        <div class="head-title-content">
                                                            <div class="col-left">
                                                            <?php if (get_field('date', $post->ID)) :
                                                                $formated_date = date('jS F Y', strtotime(get_field('date', $post->ID)));?>
                                                                <!--<p><?php echo the_field('date', $post->ID); ?><?php if (get_field('start_time', $post->ID)) : ?> <?php echo the_field('start_time', $post->ID); ?> To <?php echo the_field('end_time', $post->ID); ?> (<?php echo the_field('time_selection', $post->ID); ?>)<?php endif; ?></p>-->
                                                                <p><?php echo $formated_date; ?><?php if (get_field('start_time', $post->ID)) : ?><br/> <?php echo the_field('start_time', $post->ID); ?> (<?php echo the_field('time_selection', $post->ID); ?>)<?php endif; ?></p>
                                                                  <?php endif; ?>
                                                                <?php if($speaker != ''){ ?>
                                                                    <div class="display-speakers">
                                                                        Our Speaker(s)<br/>
                                                                        <?php echo rtrim(trim($speaker), '|'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-right">
                                                            <?php if (get_field('webinar_video_url', $post->ID)) : ?>
                                                                <?php if( get_field('status', $post->ID) == 'Upcoming' ) { ?>
                                                                    <!--<a class="btn btn-orange watch-video" target="_blank" href="<?php echo the_field('webinar_video_url', $post->ID); ?>">Register Now</a>-->
																	<button type="button" class="btn btn-orange watch-video" data-bs-toggle="modal" data-bs-target="#registerModal">Register Now</button>
                                                                <?php } else { ?>
                                                                    <button type="button" class="btn btn-orange watch-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-theVideo="<?php echo the_field('webinar_video_url', $post->ID); ?>">Watch Now</button>
                                                                <?php }
                                                            endif; ?>
                                                            </div>                                  
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                </div>    
                            </div>
                            <!-- Banner Slider end -->      

                        <div class="container section-container-padding pt-0 pb-0">
                            <div class="single-container">
                                <div class="article-container">
                                    <!-- speaker content start -->
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 mb-5 mb-md-0">
                                            <article class="blog-contents pe-md-3 pe-xl-4 pe-xxl-5">
                                                <?php the_content(); ?>
                                            </article>
                                        </div>
                                        <?php if (get_field('webinar_video_url', $post->ID)) : ?>
											<?php //if (get_field('start_time', $post->ID)) { 
											if( get_field('status', $post->ID) == 'Upcoming' ) { ?>
											<div class="mt-4 text-center">
												<!--<a class="btn btn-orange watch-video" target="_blank" href="<?php echo the_field('webinar_video_url', $post->ID); ?>">Register Now</a>-->
												<button type="button" class="btn btn-orange watch-video" data-bs-toggle="modal" data-bs-target="#registerModal">Register Now</button>
											</div>
											<?php } else { ?>
											<div class="mt-4 text-center">
												<button type="button" class="btn btn-orange watch-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-theVideo="<?php echo the_field('webinar_video_url', $post->ID); ?>">Watch Now</button>
											</div>
											<?php }
										endif; ?>
										<?php if( get_field('status', $post->ID) == 'Upcoming' && get_field('key', $post->ID)) {  ?>
											<!-- Modal -->
											<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Register Now</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												  </div>
												  <div class="modal-body">
													<?php echo do_shortcode("[gotowebinar-reg key='".get_field('key', $post->ID)."']"); ?>
												  </div>
												  <!--<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary">Save changes</button>
												  </div>-->
												</div>
											  </div>
											</div>
											<!--<div class="col-md-12 col-lg-12 mb-5 mb-md-0">
												<?php echo do_shortcode("[gotowebinar-reg key='".get_field('key', $post->ID)."']"); ?>
											</div>-->
										<?php } ?>
                                    </div>
                                    <!-- speaker content end -->
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
			<?php if (have_rows('webinars_list')) { ?>
            <section>
                <div class="container">
                <!-- Meet The Speaker start -->
					<div class="meet-speaker mt-5">
						<div class="title-heading">
							<h2>Meet The Speaker(s)<span class="heading-border"></span></h2>
						</div>
						<div class="speaker-section">
							<div class="speaker-carousel">
								<?php while (have_rows('webinars_list')) : the_row(); ?>
									<div class="items ">
										<div class="speaker-card text-center">
											<?php if (get_sub_field('speaker_image')) : ?>
												<?php
												$speaker_image =  get_sub_field('speaker_image');
												$speaker_image_url = $speaker_image['sizes']['medium'];
												?>
											<?php endif; ?>
											<div class="card-image-box">
												<div class="card-image cover-bg speaker-image lazyload" <?php if (get_sub_field('speaker_image')) : ?> style="background-image: url('<?php echo $speaker_image_url; ?>')" <?php endif; ?>>
												</div>
												<div class="description">
												<?php if (get_sub_field('speaker_name')) : ?>
													<h5>
														<?php echo get_sub_field('speaker_name', $post->ID); ?>
													</h5>
												<?php endif; ?>
												<?php if (get_sub_field('speaker_designation')) : ?>
													<p class="mb-0">
														<?php echo get_sub_field('speaker_designation', $post->ID); ?>
													</p>
												<?php endif; ?>
												<?php if (get_sub_field('linkedin_url')) : ?>
													<a href="<?php echo get_sub_field('linkedin_url', $post->ID); ?>" target="_blank" ><i class="fab fa-linkedin-in"></i></a>
												<?php endif; ?>
												</div>
											</div>
											<div class="card-body speaker-card-details">
												
												<?php if (get_sub_field('speaker_description')) : ?>
													<p>
														<?php echo get_sub_field('speaker_description', $post->ID); ?>
													</p>
												<?php endif; ?>																
											</div>
										</div>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
					<!-- Meet The Speaker end -->
				  </div>
            </section>
			<?php } ?>
			<?php if (have_rows('webinars_host')) { ?>
            <section class="bg-light">
                <div class="container">
                    	<!-- Meet The Host start -->
                        <div class="meet-speaker mt-5">                                      
							<div class="title-heading">
								<h2>Meet The Host(s)<span class="heading-border"></span></h2>
							</div>
							<div class="speaker-section">
								<div class="speaker-carousel">
									<?php while (have_rows('webinars_host')) : the_row(); ?>
										<div class="items">
											<div class="speaker-card text-center">
												<?php if (get_sub_field('host_image')) : ?>
													<?php
													$host_image =  get_sub_field('host_image');
													$host_image_url = $host_image['sizes']['medium'];
													?>
												<?php endif; ?>
												<div class="card-image-box">
													<div class="card-image cover-bg speaker-image lazyload" <?php if (get_sub_field('host_image')) : ?> style="background-image: url('<?php echo $host_image_url; ?>')" <?php endif; ?>>
													</div>
													<div class="description">
													<?php if (get_sub_field('host_name')) : ?>
														<h5>
															<?php echo get_sub_field('host_name', $post->ID); ?>
														</h5>
													<?php endif; ?>
													<?php if (get_sub_field('host_designation')) : ?>
														<p class="mb-0">
															<?php echo get_sub_field('host_designation', $post->ID); ?>
														</p>
													<?php endif; ?>
													<?php if (get_sub_field('linkedin_url')) : ?>
														<a href="<?php echo get_sub_field('linkedin_url', $post->ID); ?>" target="_blank" ><i class="fab fa-linkedin-in"></i></a>
													<?php endif; ?>
													</div>
												</div>
												<div class="card-body speaker-card-details">
												   
												   
													<?php if (get_sub_field('host_description')) : ?>
														<p>
															<?php echo get_sub_field('host_description', $post->ID); ?>
														</p>
													<?php endif; ?>
													
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
						<!-- Meet The Host end -->
                </div>
            </section>
			<?php } ?>
        </div>
        <?php if (get_field('webinar_video_url', $post->ID)) : ?>
            <!-- Modal -->
            <div class="video-modal modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
                <div class="modal-dialog modal-lg  pb-0">
                    
				<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel"><?php the_title(); ?></h5>
							<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></i></button>
						</div>                       
                        <div class="modal-body  p-4 contact-form">
							<div class="modal-webinar-contact-form"><?php echo do_shortcode('[contact-form-7 id="30955" title="Webinar contact form"]'); ?></div>
                          <div class="ratio ratio-16x9 modal-video-main" style="display:none;">
							<iframe width="100%" height="350" src="" class="modal-video-iframe" ></iframe><!--allow="autoplay" -->
							</div>
						</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php endwhile;
endif;
get_footer(); ?>
<script>
jQuery( window ).on("load", function() {
	jQuery('#firstName').val('');
	jQuery('#lastName').val('');
	jQuery('#email').val('');
	//jQuery('#country').val('');
	//jQuery('#phone').val('');
	//jQuery('#organization').val('');
	//jQuery('#jobTitle').val('');
});
jQuery( document ).ready(function() {
	
	jQuery('#gotowebinar_registration_submit').click(function(){
		var hasError = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		//jQuery('#firstName').removeAttr('required');
		if(!jQuery('#firstName').val()){
			jQuery('#firstName').addClass('error');
			//jQuery("#firstName").after('<span class="error">Please enter your email address.</span>');
			hasError = true;
		} else {
			//jQuery('#firstName').after('');
			jQuery('#firstName').removeClass('error');
			hasError = false;
		}
		if(!jQuery('#lastName').val()){
			jQuery('#lastName').addClass('error');
			hasError = true;
		} else {
			jQuery('#lastName').removeClass('error');
			hasError = false;
		}
		if(!jQuery('#email').val()){
			jQuery('#email').addClass('error');
			hasError = true;
		} else if(!emailReg.test(jQuery('#email').val())){
			jQuery('#email').addClass('error');
			hasError = true;
		} else {
			jQuery('#email').removeClass('error');
			hasError = false;
		}
		/*if(!jQuery('#country').val()){
			jQuery('#country').addClass('error');
			hasError = true;
		} else {
			jQuery('#country').removeClass('error');
			hasError = false;
		}*/
		/*if(!jQuery('#phone').val()){
			jQuery('#phone').addClass('error');
			hasError = true;
		} else {
			jQuery('#phone').removeClass('error');
			hasError = false;
		}*/
		/*if(!jQuery('#organization').val()){
			jQuery('#organization').addClass('error');
			hasError = true;
		} else {
			jQuery('#organization').removeClass('error');
			hasError = false;
		}
		if(!jQuery('#jobTitle').val()){
			jQuery('#jobTitle').addClass('error');
			hasError = true;
		} else {
			jQuery('#jobTitle').removeClass('error');
			hasError = false;
		}*/
		if(hasError == true) { 
			return false; 
		} /*else {
			setTimeout(function(){
			   jQuery('#firstName').val('');
			}, 1000);
		}*/		
		
	});
});
document.addEventListener('wpcf7mailsent', function(e) {
	if(e.detail.contactFormId == 30955) {		
		jQuery(".modal-webinar-contact-form").hide();
		jQuery(".modal-video-main").show();
		//jQuery('.modal-video-iframe').attr('allow', 'autoplay');
	}
}, false);
</script>
<!--<script>
jQuery( document ).ready(function() {
	if (jQuery(".watch-video").length) {
		var videoModal = document.getElementById('videoModal')
		videoModal.addEventListener('show.bs.modal', function () {
			var theModal = "#videoModal",
				videoSRC = jQuery(".watch-video").attr("data-theVideo"),
				videoSRCauto = videoSRC;
			jQuery(theModal + ' iframe').attr('src', videoSRCauto + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
			videoModal.addEventListener('hide.bs.modal', function () {
				jQuery(theModal + ' iframe').attr('src', "");
			});
		})
	}
});
</script>-->