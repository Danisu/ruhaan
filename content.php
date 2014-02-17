<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 			
			if ( is_single() ) ://When any single Post (or attachment, or custom Post Type) page is being displayed. (False for Pages)
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
?>

	<?php if ( is_search() ) : //When a search result page archive is being displayed ?>
	<div>
		<?php the_excerpt(); //Displays the excerpt of the current post with the "[...]" or "read more" ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div>
		<?php
			the_content("Continue reading " . the_title('', '', false));
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->