<?php 

if ( ! function_exists( 'ruhaan_setup' ) ) :

function ruhaan_setup(){

// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'ruhaan' ),
	) );
}
endif; // ruhaan_setup
add_action( 'after_setup_theme', 'ruhaan_setup' );


/**
*To make the "read more" link to the post
*Reference: http://codex.wordpress.org/Function_Reference/the_excerpt
*Task 2: Note: This link will not appear in a new line. You'll need to use CSS on the read-more class.
**/
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/**
 * Adds a box to the main column on the Post and Page edit screens.
 *Reference: http://codex.wordpress.org/Function_Reference/add_meta_box
 */
function fontAwesome_add_custom_box() {

    $screens = array( 'post', 'page' );

    foreach ( $screens as $screen ) {

        add_meta_box('fontAwesome_sectionid',__( 'Font-Awesome icon class name', 'fontAwesome_textdomain' ), 'fontAwesome_inner_custom_box', $screen);
    }
}
add_action( 'add_meta_boxes', 'fontAwesome_add_custom_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function fontAwesome_inner_custom_box( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'fontAwesome_inner_custom_box', 'fontAwesome_inner_custom_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );

  echo '<label for="fontAwesome_new_field">';
       _e( "Class name of the icon:\n", 'fontAwesome_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="fontAwesome_new_field" name="fontAwesome_new_field" value="' . esc_attr( $value ) . '" size="25" />';

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function fontAwesome_save_postdata( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['fontAwesome_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['fontAwesome_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'fontAwesome_inner_custom_box' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  $mydata = sanitize_text_field( $_POST['fontAwesome_new_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_my_meta_value_key', $mydata );
}
add_action( 'save_post', 'fontAwesome_save_postdata' );

/**
*	Custom Menu
*	It adds the icon (<i class="{}"></i> ) inside the the link element (<a>) in the nav menu 
*	Uses Walker_Nav_Menu class
*/
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$output .= $indent . '<li>';
		
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$faicon = get_post_meta( (get_post_meta( $item->ID, '_menu_item_object_id', true )), '_my_meta_value_key', true );

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . '<i class="' . $faicon . '"></i>' . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
?>