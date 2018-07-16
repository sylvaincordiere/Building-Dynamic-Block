<?php
/**
 * Server-side rendering of the `core/latest-posts` block.
 *
 * @package gutenberg
 */
function gutenberg_examples_dynamic_block_posts( $attributes ) {
    // get our 3 most recent posts using wp_get_recent_posts
    $recent_posts = wp_get_recent_posts( array(
        'numberposts' => 3,
        'post_status' => 'publish'
    ) );

    // If our content attribute is set output it within an h2 element
    if ( $attributes['content'] ) {
        $title_content = '';

        // The RichText component can ouput an array if enter is hit. The else portion is seeifing if a <br> exists and outputting one
        foreach ( $attributes['content'] as $title ) {
            if ( is_string($title) ) {
                $title_content .= $title;
            } else {
                $title_content .= '<' . $title['type'] . '>';
            }
        }

        $dynamic_block_title = sprintf( '<h2>%1$s</h2>', $title_content );
    }

    $list_item_markup = '';

    // Put together markup for each post to output
    foreach ( $recent_posts as $post ) {
        $post_id = $post['ID'];

        $title = get_the_title( $post_id );

        $list_item_markup .= sprintf(
            '<li><a href="%1$s">%2$s</a></li>',
            esc_url( get_permalink( $post_id ) ),
            esc_html( $title )
        );
    }

    // If our className attribute is set output it in addition to a class set in our PHP
    $class = 'prefix-dynamic-block';
    if ( isset( $attributes['className'] ) ) {
        $class .= ' ' . $attributes['className'];
    }

    // Built out our final output
    $block_content = sprintf(
        '<div class="%1$s">%2$s<ul>%3$s</ul></div>',
        esc_attr( $class ),
        $dynamic_block_title,
        $list_item_markup
    );

    return $block_content;
}

function register_dynamic_blocks() {
    register_block_type( 'gutenberg-examples/block-dynamic-block', array(
        'attributes' => array(
            'content' => array(
                'type' => 'array',
            ),
            'className' => array(
                'type' => 'string',
            ),
        ),
        'render_callback' => 'gutenberg_examples_dynamic_block_posts',
    ) );
}

add_action('init', 'register_dynamic_blocks');