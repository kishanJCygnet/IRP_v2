<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
?>
	<section class="contact-form-content">
		<div class="contact-form"> 
			<div class="container" id="contactus">			
			<?php $post_slug = $post->post_name;
			if($post_slug != 'community-version' && $post_slug != 'download-enterprise' && $post_slug != 'sign-up' && $post_slug != 'thank-you-for-contacting-us' && $post_slug != 'thank-you-for-signing-up' && $post_slug != 'thank-you-for-your-interest' && $post_slug != 'thank-you-for-webinar-registration' && $post_slug != 'thank-you-for-downloading-case-study' && $post_slug != 'thank-you-for-signing-up-community' && $post_slug != 'thank-you-for-signing-up-enterprise' && !is_404()){  ?>				
				<div class="title-heading">	
					<h2>Get in touch
						<span class="heading-border"></span>
					</h2>
				</div>
				<div class="form-content">
					<?php echo do_shortcode('[contact-form-7 id="172" title="Contact Us"]'); ?>
					<input type="hidden" value="contact_us" id="hd_type">
				</div>
			<?php } ?>
			<?php //if ( is_front_page() ) : ?>
				<!--<div class="technology-move">
					<div class="text-center"> <img src="<?php echo THEME_PATH; ?>images/phraise.png" alt="" /></div>
				</div>-->
			<?php //endif; ?>
			</div>
		</div>
	</section>
	<?php /* Start Footer section dynamic display */
		if (get_field('footer_section_text')){ 	?>
		<section class="footer-section-text-main">
			<div class="container">
				<div class="footer-section-text" >
					<?php echo the_field('footer_section_text'); ?> 
					<?php if (get_field('footer_section_button_title')){ ?>
						<a href="<?php echo the_field('footer_section_button_url'); ?>" class="btn"><?php echo the_field('footer_section_button_title'); ?> </a>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } 
	/* End Footer section dynamic display */ ?>
	<!-- Footer -->
    <footer class="footer ">
        <div class="footer-container">
			<div class="container">				
				<div class="footer-contents d-flex justify-content-between align-items-center">
					<!-- Footer logo begin -->
					<div class="footer-logo">
						<a href="<?php echo site_url(); ?>" title="IRP" alt="IRP">
							<span class="visually-hidden">IRP</span>
							<img src='<?php echo get_field("footer_logo", "option"); ?>' alt="IRP">
						</a>
					</div>
					<!-- Footer logo end -->
					<div>
						<!-- social links begin -->
						<div class="social-media mb-3">
							<span class="mb-md-0 fw-medium textPrimery">
								<?php if (get_field('footer_inquiry_email', 'option')) : ?>
									<span class=" textSecondry">Inquiry :</span> 
									<a href="mailto:<?php echo the_field('footer_inquiry_email', 'option'); ?>"><?php echo the_field('footer_inquiry_email', 'option'); ?></a>
									<span class="v-divider mx-2"></span>
								<?php endif; ?>
								<?php if (get_field('footer_support_email', 'option')) : ?>
									<span class=" textSecondry">Support :</span> <a href="mailto:<?php echo the_field('footer_support_email', 'option'); ?>"><?php echo the_field('footer_support_email', 'option'); ?></a>
									<span class="v-divider mx-2"></span>
								<?php endif; ?>
								<?php if (get_field('footer_phone_number', 'option')) : ?>
									<span class=" textSecondry">Phone :</span> <a href="tel:<?php echo the_field('footer_phone_number', 'option'); ?>"><?php echo the_field('footer_phone_number', 'option'); ?></a>
								<?php endif; ?>
							</span>
						</div>
						<!-- social links end -->

						<!-- Copyright and footer links begin -->
						<div class="footer-links d-flex flex-wrap flex-column flex-md-row">
							<address
								class="copyright-text d-inline-flex mb-2 justify-content-center justify-content-md-end fw-medium">
								Copyright – <?php echo date('Y'); ?> <?php echo the_field('copyright_text', 'option'); ?> </address>
							<div class="menu-footer-links-container">
							<?php wp_nav_menu(array(
								'theme_location'  => 'footer_menu',
								'menu_class' => 'footer-links ps-0 d-inline-flex list-none mb-0 justify-content-center justify-content-md-end',
								'items_wrap'      => '<ul id="menu-footer-links" class="%2$s">%3$s</ul>',
								'echo'            => true
							)); ?>
							</div>
						</div>
						<!-- Copyright and footer links end -->
					</div>
				</div>
			</div>
        </div>
    </footer>
    <!-- End Footer -->
	
	<?php if ( is_front_page() ) : ?>
	<div class="modal fade" id="videoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-body">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="ratio ratio-16x9">								  
			  <iframe src="" allow="autoplay;" allowfullscreen></iframe>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<script>
	  jQuery(document).ready(function() {
		autoPlayYouTubeModal();
	  });
	  function autoPlayYouTubeModal() {
		  var triggerOpen = jQuery("body").find('[data-tagVideo]');
		  triggerOpen.click(function() {
			var theModal = jQuery(this).data("bs-target"),
			  videoSRC = jQuery(this).attr("data-tagVideo"),
			  videoSRCauto = videoSRC + "?autoplay=1";
			jQuery(theModal + ' iframe').attr('src', videoSRCauto);
			jQuery(theModal + ' button.btn-close').click(function() {
			  jQuery(theModal + ' iframe').attr('src', videoSRC);
			});
		  });
		}
	</script>
	<?php endif; ?>
	
   <!-- js -->
    <script src="<?php echo THEME_PATH; ?>assets/dist/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo THEME_PATH; ?>assets/dist/js/bootstrap.bundle.js"></script>   
	<script src="<?php echo THEME_PATH; ?>assets/dist/js/owl.carousel.min.js"></script>	
	<script src="<?php echo THEME_PATH; ?>assets/dist/js/wow.min.js"></script>
	<script src="<?php echo THEME_PATH; ?>assets/dist/js/particles.min.js"></script>	
	<script src="<?php echo THEME_PATH; ?>assets/dist/js/main.js"></script>	
	<script type='text/javascript' id='cygnet-global-js-extra'>
	/* <![CDATA[ */
	var templateUrl = '<?= site_url(); ?>'+'\/wp-admin\/admin-ajax.php';
	var ajaxPath = {"ajaxurl":templateUrl};
	/* ]]> */
	</script>
	<script src="<?php echo THEME_PATH; ?>assets/dist/js/scripts.js"></script>
    <!-- End js -->
	<script>
	jQuery(document).ready(function () {		
		CYGNET.init();
    });
	</script>
	<script>
	  var url = '<?php echo site_url(); ?>';
	  document.addEventListener('wpcf7mailsent', function(e) {
		if (e.detail.contactFormId == 666) {
			location = url + '/thank-you-for-your-interest';
		} else if(e.detail.contactFormId == 172 || e.detail.contactFormId == 30976) {
			location = url + '/thank-you-for-contacting-us';
		}
	  }, false);
	</script>
	
	<!-- Download PDF from fet a free copy pdf -->
	<!--<script>
	jQuery(document).ready(function(){
		var siteurl = '<?php echo THEME_PATH; ?>images/Cygnature_a_fresh_and_innovative_approach_to_digital_signing_Deep_Analysis_Vignette.pdf';
		if (siteurl) {
			document.addEventListener('wpcf7mailsent', function(e) {
				if (e.detail.contactFormId == 24597) {
				//if (e.detail.contactFormId == 22243) {  //local
					var pdfurl = siteurl ? siteurl : '';

					//e.stopPropagation();
					// You can place extra checks here.
					var tab = window.open(pdfurl, '_blank');
					tab.focus();
					location = url + '/thank-you-for-your-interest';
				}
			}, false);
		}
	});
	</script>-->
		
<?php wp_footer(); ?>

</body>
</html>