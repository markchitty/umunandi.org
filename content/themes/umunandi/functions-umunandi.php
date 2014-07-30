<?php
// Title font
wp_enqueue_style('umunandi_fonts', 'http://fonts.googleapis.com/css?family=Roboto+Slab:400', false, false);

// WP only makes excerpts available on Posts. This turns on excerpts for Pages too.
function umunandi_add_excerpts_to_pages() {
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'umunandi_add_excerpts_to_pages');

// Writes out src url for featured image
function umunandi_the_featured_img_src() {
	$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID), 'full');
	echo roots_root_relative_url($img_src[0]);
}

// Returns an array of page objects for featured OVCs
function umunandi_featured_kids() {
	$ovcs_page = get_page_by_title('OVCs');
	$kids = get_pages(array(
		'child_of'     => $ovcs_page->ID,
		'hierarchical' => 0,
		'meta_key'     => '_featured-page',
		'meta_value'   => '1',
		'sort_column'  => 'menu_order'
	));
	return $kids;
}


// ======== Admin page stuff =========

// Add a Featured checkbox to pages
function umunandi_add_featured_meta_box() {
    add_meta_box('featured-page', __('Featured Page'), 'umunandi_the_featured_meta_box', 'page', 'side');
}
add_action('add_meta_boxes', 'umunandi_add_featured_meta_box', 1);


function umunandi_the_featured_meta_box($page) {
    $featured = get_post_meta($page->ID, '_featured-page', true);
    wp_nonce_field('umunandi_featured_page', 'umunandi_featured_page_nonce' );

    // Using _ before custom fields means they can't be edited via the custom fields UI
    // The hidden field unsets the _featured-page if the checkbox _isn't_ ticked
    echo "<input type='hidden'   name='_featured-page'                    value='0' /> ";
    echo "<input type='checkbox' name='_featured-page' id='featured-page' value='1' " . checked(1, $featured, false) . " /> ";
    echo "<label for='_featured-page'>Show this on the home page?</label>";
}

function umunandi_save_featured_meta($post_id) {

	// Validation
	if (!isset($_POST['umunandi_featured_page_nonce'])) return;																				// Validate the nonce
	if (!wp_verify_nonce($_POST['umunandi_featured_page_nonce'], 'umunandi_featured_page')) return;		// (as it were!)
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;																					// Ignore autosaves
	if (!current_user_can('edit_page', $post_id)) return;																							// Check user's permissions
	if (!isset($_POST['_featured-page'])) return;																											// Check we've got something to save

	// OK safe to save the data now
	update_post_meta($post_id, '_featured-page', sanitize_text_field($_POST['_featured-page']));			// Update the meta field in the db
}
add_action('save_post', 'umunandi_save_featured_meta');