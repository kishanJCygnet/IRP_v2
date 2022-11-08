<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
/* banner content */ ?>
	<section class="banner-content">    
		<div class="banner-inner-content w-100" <?php if (get_field('blog_listing_banner_image', 'option')) : ?> style="background-image: url('<?php echo the_field('blog_listing_banner_image', 'option'); ?>')" <?php endif; ?>>  
			<div class="d-md-flex flex-wrap slide-content-main align-items-center justify-content-center w-100">
				<div class="banner-caption">
					<?php if (get_field('blog_listing_banner_title', 'option')) : ?>
						<h1 class="banner-title text-white">
							<?php the_field('blog_listing_banner_title', 'option'); ?>
						</h1>
					<?php endif; ?>
				</div>
			</div>
		</div>    
	</section>
<?php /* End banner content */	?>


<div class="category-contents">
	<?php if ( have_posts() ) : ?>

		<header class="page-header alignwide">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php if ( $description ) : ?>
				<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
			<?php endif; ?>
		</header><!-- .page-header -->

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) ); ?>
		<?php endwhile; ?>

		<?php twenty_twenty_one_the_posts_navigation(); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content-none' ); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
