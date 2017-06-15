<?php
/**
 * Blog section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_blog' ) ) :
	/**
	 * Blog section content.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_blog() {
		$hide_section = get_theme_mod( 'hestia_blog_hide', false );
		if ( (bool) $hide_section === true ) {
			return;
		}

		if ( current_user_can( 'edit_theme_options' ) ) {
			/* translators: 1 - link to customizer setting. 2 - 'customizer' */
			$hestia_blog_subtitle = get_theme_mod( 'hestia_blog_subtitle', sprintf( __( 'Change this subtitle in %s.','hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_blog_subtitle' ) ), __( 'customizer','hestia' ) ) ) );
		} else {
			$hestia_blog_subtitle = get_theme_mod( 'hestia_blog_subtitle' );
		}
		$hestia_blog_title = get_theme_mod( 'hestia_blog_title', __( 'Blog', 'hestia' ) );
		$hestia_blog_items = get_theme_mod( 'hestia_blog_items', 3 );
		?>
		<section class="blogs" id="blog" data-sorder="hestia_blog">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center">
					<?php if ( ! empty( $hestia_blog_title ) || is_customize_preview() ) : ?>
						<h2 class="title"><?php echo esc_html( $hestia_blog_title ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $hestia_blog_subtitle ) || is_customize_preview() ) : ?>
						<h5 class="description"><?php echo wp_kses_post( $hestia_blog_subtitle ); ?></h5>
					<?php endif; ?>
					</div>
				</div>
				<div class="row">
				<?php if ( ! empty( $hestia_blog_items ) ) : ?>
					<?php
					$loop = new WP_Query( array(
						'posts_per_page' => absint( $hestia_blog_items ),
						'ignore_sticky_posts' => true,
					) ); ?>
				<?php else : ?>
					<?php
					$loop = new WP_Query( array(
						'posts_per_page' => 3,
						'ignore_sticky_posts' => true,
					) ); ?>
				<?php endif; ?>
				<?php
				if ( $loop->have_posts() ) :
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
					<article class="col-md-4">
						<div class="card card-plain card-blog">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="card-image">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'hestia-blog' ); ?>
								</a>
							</div>
						<?php endif; ?>
							<div class="content">
								<h6 class="category"><?php hestia_category(); ?></h6>
								<?php the_title( sprintf( '<h4 class="card-title"><a class="blog-item-title-link" href="%s" title="%s" rel="bookmark">', esc_url( get_permalink() ), the_title_attribute( array(
									'echo' => false,
								) ) ), '</a></h4>' ); ?>
								<p class="card-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
							</div>
						</div>
					</article>
				<?php
					endwhile;
				endif;
				?>
				</div>
			</div>
		</section>
		<?php
	}

endif;

if ( function_exists( 'hestia_blog' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 50, 'hestia_blog' );
	add_action( 'hestia_sections', 'hestia_blog', absint( $section_priority ) );
}
