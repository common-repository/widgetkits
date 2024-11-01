<?php 
require_once(WIGETKITS_WIDGET_INC. 'Clasess/class-widgetkits-recent-post.php' );
require_once(WIGETKITS_WIDGET_INC. 'Clasess/class-widgetkits-about.php' );
require_once(WIGETKITS_WIDGET_INC. 'Clasess/class-widgetkits-socail.php' );
function wigetkit_scripts(){
	//icon css
    wp_enqueue_style( 'themify-icons', WIGETKITS_ASSETS_PUBLIC . '/vendor/themify-icons/themify-icons.css', array(), WIGETKITS_VERSION );
    //main css
    wp_enqueue_style( 'widgetkit-css', WIGETKITS_ASSETS_PUBLIC . '/css/widget-style.css', array(), WIGETKITS_VERSION );

}
add_action('wp_enqueue_scripts', 'wigetkit_scripts');