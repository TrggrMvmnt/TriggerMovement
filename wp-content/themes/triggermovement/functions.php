<?php 

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles');
function salient_child_enqueue_styles() {
	
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('font-awesome'));
    wp_enqueue_style( 'tm-base-styles', get_stylesheet_directory_uri() .'/css/main.css', array(), filemtime( get_stylesheet_directory() . '/css/main.css' ) , true );
    wp_enqueue_script( 'triggermovement-custom', get_stylesheet_directory_uri() . '/js/triggermovement.js', array(), filemtime( get_stylesheet_directory() . '/js/triggermovement.js' ) , true );

    if ( is_rtl() ) 
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
}

/*===================================================================================
 * Customise Login Logo & link to main website
 * =================================================================================*/

function customise_login_image() { ?>

  <style type="text/css">
    body.login #login h1 a {
      background: url('/wp/wp-content/uploads/2017/07/login-logo.jpg') 8px 0 no-repeat transparent;
      background-position: center;
      height:100px;
      width:320px; }
    </style>
<?php }
add_action("login_head", "customise_login_image");


//Redux Default Option Name
$opt_name = "salient_redux";

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if ( ! function_exists( 'change_arguments' ) ) {
    function change_arguments( $args ) {
        $args['menu_title'] = esc_attr__( 'Trigger Movement', 'rosematheme' );
        $args['page_title'] = esc_attr__( 'Trigger Options', 'rosematheme' );
        return $args;
    }
}

// Change Arguments
add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );




?>

