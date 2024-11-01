<?php
/**
 * Themify Icon List for widgetkits
 */
function widgetkits_get_social_icons() {
    $ti_icons =  array(
        'ti-instagram',
        'ti-google',
        'ti-github',
        'ti-flickr',
        'ti-facebook',
        'ti-dropbox',
        'ti-dribbble',
        'ti-apple',
        'ti-android',
        'ti-yahoo',
        'ti-wordpress',
        'ti-vimeo-alt',
        'ti-twitter-alt',
        'ti-tumblr-alt',
        'ti-trello',
        'ti-stack-overflow',
        'ti-soundcloud',
        'ti-sharethis',
        'ti-sharethis-alt',
        'ti-reddit',
        'ti-pinterest-alt',
        'ti-microsoft-alt',
        'ti-linux',
        'ti-jsfiddle',
        'ti-joomla',
        'ti-html5',
        'ti-flickr-alt',
        'ti-email',
        'ti-drupal',
        'ti-dropbox-alt',
        'ti-css3',
        'ti-rss',
        'ti-rss-alt',
    );
    return apply_filters('widgetkits_icon_list', $ti_icons);
}



if ( ! function_exists( 'widgetkits_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function widgetkits_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;


if ( ! function_exists( 'widgetkits_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function widgetkits_posted_by() {
        $byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;


/**
 * Get Pages
 * 
 * @since 1.0
 * 
 * @return array
 */
if ( ! function_exists( 'widgetkits_get_all_pages' ) ) {
    function widgetkits_get_all_pages($posttype = 'page')
    {
        $args = array(
            'post_type' => $posttype, 
            'post_status' => 'publish', 
            'posts_per_page' => -1
        );

        $page_list = array();
        if( $data = get_posts($args)){
            foreach($data as $key){
                $page_list[$key->ID] = $key->post_title;
            }
        }
        return  $page_list;
    }
}
/**
 * Meta Output
 * 
 * @since 1.0
 * 
 * @return array
 */
if ( ! function_exists( 'widgetkits_get_meta' ) ) {
    function widgetkits_get_meta( $data ) {
        global $wp_embed;
        $content = $wp_embed->autoembed( $data );
        $content = $wp_embed->run_shortcode( $content );
        $content = do_shortcode( $content );
        $content = wpautop( $content );
        return $content;
    }
}

/**
 * Get a list of all CF7 forms
 *
 * @return array
 */
if ( ! function_exists( 'widgetkits_get_cf7_forms' ) ) {
    function widgetkits_get_cf7_forms() {
        $forms = get_posts( [
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ] );

        if ( ! empty( $forms ) ) {
            return wp_list_pluck( $forms, 'post_title', 'ID' );
        }
        return [];
    }
}
 /**
 * Check if contact form 7 is activated
 *
 * @return bool
 */
if ( ! function_exists( 'widgetkits_is_cf7_activated' ) ) {
   
    function widgetkits_is_cf7_activated() {
        return class_exists( 'WPCF7' );
    }
}

if ( ! function_exists( 'widgetkits_do_shortcode' ) ) {
    function widgetkits_do_shortcode( $tag, array $atts = array(), $content = null ) {
        global $shortcode_tags;
        if ( ! isset( $shortcode_tags[ $tag ] ) ) {
            return false;
        }
        return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
    }
}

