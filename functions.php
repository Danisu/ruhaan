<?php 

//To make the "read more" link to the post
//Reference: http://codex.wordpress.org/Function_Reference/the_excerpt
//Task 2: Note: This link will not appear in a new line. You'll need to use CSS on the read-more class.
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );
?>