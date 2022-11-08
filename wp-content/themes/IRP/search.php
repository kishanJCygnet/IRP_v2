<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* banner content */ ?>
	<section class="banner-content">    
		<div class="banner-inner-content w-100" <?php if (get_field('search_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('search_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
			<div class="d-md-flex flex-wrap slide-content-main align-items-center w-100">
				<div class="banner-caption">
					<?php if (get_field('search_listing_banner_title', 'option')) : ?>
						<h1 class="banner-title text-white">
							<?php the_field('search_listing_banner_title', 'option'); ?>
						</h1>
					<?php endif; ?>
				</div>
			</div>
		</div>    
	</section>
<?php /* End banner content */	?>


<?php
if ( have_posts() ) {
	?>
	<header class="page-header alignwide">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: Search term. */
				esc_html__( 'Results for "%s"', 'twentytwentyone' ),
				'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</header><!-- .page-header -->

	<div class="search-result-count default-max-width">
		<?php
		printf(
			esc_html(
				/* translators: %d: The number of search results. */
				_n(
					'We found %d result for your search.',
					'We found %d results for your search.',
					(int) $wp_query->found_posts,
					'twentytwentyone'
				)
			),
			(int) $wp_query->found_posts
		);
		?>
	</div><!-- .search-result-count -->
	<?php
	// Start the Loop.
	while ( have_posts() ) {
		the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		//get_template_part( 'template-parts/content/content-excerpt', get_post_format() );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>						
			<header class="entry-header">
				<?php
				the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
				twenty_twenty_one_post_thumbnail();
				?>
				<span class="search-url"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_url( get_permalink() ); ?></a></span>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php //the_excerpt(); 
				$search_post_id = get_the_ID();
				$search_get_post = get_post($search_post_id);
				echo aioseo()->meta->description->getDescription($search_get_post);
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer default-max-width">
				<?php twenty_twenty_one_entry_meta_footer(); ?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-${ID} -->
		<?php
	} // End the loop.

	// Previous/next page navigation.
	//twenty_twenty_one_the_posts_navigation();
	the_posts_pagination(
			array(
				//'before_page_number' => esc_html__( 'Page', 'twentytwentyone' ) . ' ',
				'mid_size'           => 2,
				'prev_text'                  => __('<span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>', 'textdomain'),
				'next_text'                  => __('<span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>', 'textdomain'),
				/*'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ),
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),*/
				
				/*'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
				),*/
			)
		);

	// If no content, include the "No posts found" template.
} else {
	get_template_part( 'template-parts/content/content-none' );
}

get_footer();
